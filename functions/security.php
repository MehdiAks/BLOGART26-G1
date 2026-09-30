<?php

// Échappe une valeur HTML sans réencoder les entités déjà stockées.
function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8', false);
}

// Génère ou retourne le jeton CSRF de la session courante.
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Produit le champ caché CSRF commun à tous les formulaires POST.
function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

// Vérifie un jeton CSRF avec une comparaison résistante au timing.
function csrf_verify(?string $token): bool {
    return !empty($_SESSION['csrf_token']) && !empty($token)
        && hash_equals($_SESSION['csrf_token'], $token);
}

// Retourne l'identifiant entier du membre connecté.
function current_user_id(): ?int {
    $ba_bec_userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
    return $ba_bec_userId > 0 ? $ba_bec_userId : null;
}

// Relit en base le statut courant du membre une seule fois par requête.
function current_user_stat(): ?int {
    static $ba_bec_loaded = false;
    static $ba_bec_stat = null;

    if ($ba_bec_loaded) {
        return $ba_bec_stat;
    }
    $ba_bec_loaded = true;
    $ba_bec_userId = current_user_id();
    if ($ba_bec_userId === null) {
        return null;
    }

    $ba_bec_member = sql_select('MEMBRE', 'numStat, pseudoMemb', 'numMemb = ?', null, null, '1', [$ba_bec_userId]);
    if (empty($ba_bec_member)) {
        if (sql_get_last_error() !== null) {
            return null;
        }
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        return null;
    }

    $ba_bec_stat = (int) $ba_bec_member[0]['numStat'];
    $_SESSION['numStat'] = $ba_bec_stat;
    $_SESSION['pseudoMemb'] = $ba_bec_member[0]['pseudoMemb'];
    return $ba_bec_stat;
}

// Indique si le script courant appartient à l'API.
function is_api_request(): bool {
    return strpos($_SERVER['SCRIPT_NAME'] ?? '', '/api/') !== false;
}

// Exige une session membre valide et adapte la réponse au contexte API ou page.
function require_login(): void {
    if (current_user_id() !== null && current_user_stat() !== null) {
        return;
    }
    if (is_api_request()) {
        http_response_code(403);
        exit('Accès interdit.');
    }
    header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
    exit();
}

// Exige un niveau de statut inférieur ou égal au seuil demandé.
function require_stat(int $maxStat): void {
    require_login();
    $ba_bec_stat = current_user_stat();
    if ($ba_bec_stat !== null && $ba_bec_stat <= $maxStat) {
        return;
    }
    if (is_api_request()) {
        http_response_code(403);
        exit('Accès interdit.');
    }
    header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
    exit();
}

// Vérifie un niveau d'accès sans provoquer de redirection.
function check_access($level) {
    $ba_bec_stat = current_user_stat();
    return $ba_bec_stat !== null && $ba_bec_stat <= (int) $level;
}

// Restreint une redirection à un chemin local sûr.
function safe_redirect_target(?string $url, string $fallback): string {
    $ba_bec_url = (string) $url;
    if ($ba_bec_url === '' || $ba_bec_url[0] !== '/' || strpos($ba_bec_url, '//') === 0
        || strpos($ba_bec_url, '/\\') === 0 || preg_match('/[\r\n]/', $ba_bec_url)
        || preg_match('/^[a-z][a-z0-9+.-]*:/i', $ba_bec_url)) {
        return $fallback;
    }
    return $ba_bec_url;
}

// Reproduit exactement la transformation appliquée aux anciens mots de passe.
function legacy_password_variant(string $pw): string {
    return stripslashes(trim(htmlspecialchars($pw, ENT_QUOTES)));
}

// Détermine l'adresse cliente en ne faisant confiance au proxy que si cela est explicitement configuré.
function client_ip(): string {
    $ba_bec_remoteAddr = trim((string) ($_SERVER['REMOTE_ADDR'] ?? ''));
    $ba_bec_trustProxy = filter_var(getenv('TRUST_PROXY'), FILTER_VALIDATE_BOOLEAN) === true;
    if ($ba_bec_trustProxy && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ba_bec_forwardedIps = array_reverse(explode(',', (string) $_SERVER['HTTP_X_FORWARDED_FOR']));
        foreach ($ba_bec_forwardedIps as $ba_bec_forwardedIp) {
            $ba_bec_forwardedIp = trim($ba_bec_forwardedIp);
            if (filter_var($ba_bec_forwardedIp, FILTER_VALIDATE_IP) !== false) {
                return $ba_bec_forwardedIp;
            }
        }
    }
    return filter_var($ba_bec_remoteAddr, FILTER_VALIDATE_IP) !== false ? $ba_bec_remoteAddr : '0.0.0.0';
}

// Prépare la table et purge les anciennes tentatives de connexion.
function login_throttle_init(): bool {
    static $ba_bec_ready = null;
    if ($ba_bec_ready !== null) {
        return $ba_bec_ready;
    }
    $ba_bec_ready = sql_create_table('LOGIN_ATTEMPT');
    if ($ba_bec_ready) {
        global $DB;
        try {
            $ba_bec_stmt = $DB->prepare('DELETE FROM LOGIN_ATTEMPT WHERE attemptedAt < DATE_SUB(NOW(), INTERVAL 1 DAY)');
            $ba_bec_stmt->execute();
        } catch (PDOException $ba_bec_exception) {
            error_log('Erreur purge LOGIN_ATTEMPT: ' . $ba_bec_exception->getMessage());
        }
    }
    return $ba_bec_ready;
}

// Indique si l'adresse cliente ou le compte a atteint sa limite sur quinze minutes.
function login_throttle_blocked($pseudo = ''): bool {
    if (!login_throttle_init()) {
        return false;
    }
    global $DB;
    try {
        $ba_bec_stmt = $DB->prepare(
            'SELECT
                SUM(CASE WHEN ip = ? THEN 1 ELSE 0 END) AS ipFailures,
                SUM(CASE WHEN pseudo = ? THEN 1 ELSE 0 END) AS pseudoFailures
             FROM LOGIN_ATTEMPT
             WHERE attemptedAt >= DATE_SUB(NOW(), INTERVAL 15 MINUTE)'
        );
        $ba_bec_stmt->execute([client_ip(), substr((string) $pseudo, 0, 70)]);
        $ba_bec_failures = $ba_bec_stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        return (int) ($ba_bec_failures['ipFailures'] ?? 0) >= 5
            || (int) ($ba_bec_failures['pseudoFailures'] ?? 0) >= 10;
    } catch (PDOException $ba_bec_exception) {
        error_log('Erreur contrôle LOGIN_ATTEMPT: ' . $ba_bec_exception->getMessage());
        return false;
    }
}

// Enregistre un échec de connexion pour l'adresse cliente.
function login_throttle_fail($pseudo): void {
    if (!login_throttle_init()) {
        return;
    }
    global $DB;
    try {
        $ba_bec_stmt = $DB->prepare('INSERT INTO LOGIN_ATTEMPT (ip, pseudo, attemptedAt) VALUES (?, ?, NOW())');
        $ba_bec_stmt->execute([client_ip(), substr((string) $pseudo, 0, 70)]);
    } catch (PDOException $ba_bec_exception) {
        error_log('Erreur écriture LOGIN_ATTEMPT: ' . $ba_bec_exception->getMessage());
    }
}

// Efface les tentatives de l'adresse cliente après une connexion réussie.
function login_throttle_clear(): void {
    if (!login_throttle_init()) {
        return;
    }
    global $DB;
    try {
        $ba_bec_stmt = $DB->prepare('DELETE FROM LOGIN_ATTEMPT WHERE ip = ?');
        $ba_bec_stmt->execute([client_ip()]);
    } catch (PDOException $ba_bec_exception) {
        error_log('Erreur nettoyage LOGIN_ATTEMPT: ' . $ba_bec_exception->getMessage());
    }
}

// Vérifie un jeton reCAPTCHA auprès de Google avec contrôle du score et de l'action.
function verifyRecaptcha($token, $action, $threshold = null) {
    $secretKey = getenv('RECAPTCHA_SECRET_KEY');
    $siteKey = getenv('RECAPTCHA_SITE_KEY');
    $resolvedThreshold = $threshold ?? (float) (getenv('RECAPTCHA_THRESHOLD') ?: 0.5);
    $recaptchaEnabled = null;

    if (array_key_exists('RECAPTCHA_ENABLED', $_ENV)) {
        $recaptchaEnabled = filter_var($_ENV['RECAPTCHA_ENABLED'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
    if ($recaptchaEnabled === null) {
        $recaptchaEnabled = !empty($secretKey) && !empty($siteKey);
    }
    if (!$recaptchaEnabled) {
        return ['valid' => true, 'score' => 0, 'message' => ''];
    }
    if (empty($secretKey)) {
        return ['valid' => false, 'score' => 0, 'message' => 'Configuration reCAPTCHA manquante.'];
    }
    if (empty($token)) {
        return ['valid' => false, 'score' => 0, 'message' => 'Veuillez valider le reCAPTCHA.'];
    }

    $payload = http_build_query(['secret' => $secretKey, 'response' => $token]);
    $response = false;
    if (function_exists('curl_init')) {
        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        if ($response === false) {
            error_log('Erreur reCAPTCHA: ' . curl_error($ch));
        }
        curl_close($ch);
    } else {
        $context = stream_context_create(['http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => $payload,
            'timeout' => 10,
        ]]);
        $response = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
    }
    if ($response === false) {
        return ['valid' => false, 'score' => 0, 'message' => 'Vérification reCAPTCHA impossible.'];
    }
    $data = json_decode($response, true);
    if (!is_array($data)) {
        return ['valid' => false, 'score' => 0, 'message' => 'Réponse reCAPTCHA invalide.'];
    }
    $ba_bec_success = $data['success'] ?? false;
    $hasScore = array_key_exists('score', $data);
    $score = $hasScore ? (float) $data['score'] : 0.0;
    $responseAction = $data['action'] ?? '';
    if (!$ba_bec_success) {
        return ['valid' => false, 'score' => $score, 'message' => 'La vérification reCAPTCHA a échoué.'];
    }
    if ($hasScore && $responseAction !== $action) {
        return ['valid' => false, 'score' => $score, 'message' => 'Action reCAPTCHA invalide.'];
    }
    if ($hasScore && $score < $resolvedThreshold) {
        return ['valid' => false, 'score' => $score, 'message' => 'Score reCAPTCHA insuffisant.'];
    }
    return ['valid' => true, 'score' => $score, 'message' => ''];
}

?>
