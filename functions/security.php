<?php
// Check if user have access to ressource, take level needed and return boolean
function check_access($level) {
    if(isset($_SESSION['id_user'])){
        $user_level = sql_select("MEMBRE", 'numStat', "numMemb = " . $_SESSION['id_user'])[0]['numStat'];
        if($user_level <= $level){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function verifyRecaptcha($token, $action, $threshold = null) {
    $secretKey = getenv('RECAPTCHA_SECRET_KEY');
    $siteKey = getenv('RECAPTCHA_SITE_KEY');
    $resolvedThreshold = $threshold ?? (float) (getenv('RECAPTCHA_THRESHOLD') ?: 0.5);
    $recaptchaEnabled = null;

    if (array_key_exists('RECAPTCHA_ENABLED', $_ENV)) {
        $recaptchaEnabled = (bool) $_ENV['RECAPTCHA_ENABLED'];
    }

    if ($recaptchaEnabled === null) {
        $recaptchaEnabled = !empty($secretKey) && !empty($siteKey);
    }

    if (!$recaptchaEnabled) {
        if (getenv('APP_DEBUG') === 'true') {
            error_log('reCAPTCHA disabled: skipping verification.');
        }

        return [
            'valid' => true,
            'score' => 0,
            'message' => ''
        ];
    }

    if (empty($secretKey)) {
        return [
            'valid' => false,
            'score' => 0,
            'message' => 'Configuration reCAPTCHA manquante.'
        ];
    }

    if (empty($token)) {
        return [
            'valid' => false,
            'score' => 0,
            'message' => 'Veuillez valider le reCAPTCHA.'
        ];
    }

    $payload = http_build_query([
        'secret' => $secretKey,
        'response' => $token
    ]);

    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        return [
            'valid' => false,
            'score' => 0,
            'message' => 'Vérification reCAPTCHA impossible.'
        ];
    }

    $data = json_decode($response, true);
    if (!is_array($data)) {
        return [
            'valid' => false,
            'score' => 0,
            'message' => 'Réponse reCAPTCHA invalide.'
        ];
    }

    $ba_bec_success = $data['success'] ?? false;
    $hasScore = array_key_exists('score', $data);
    $score = $hasScore ? (float) $data['score'] : 0.0;
    $responseAction = $data['action'] ?? '';

    if (getenv('APP_DEBUG') === 'true') {
        error_log(sprintf(
            'reCAPTCHA action=%s success=%s score=%.2f error=%s',
            $action,
            $ba_bec_success ? 'true' : 'false',
            $score,
            $curlError
        ));
    }

    if (!$ba_bec_success) {
        return [
            'valid' => false,
            'score' => $score,
            'message' => 'La vérification reCAPTCHA a échoué.'
        ];
    }

    if ($hasScore && $responseAction !== $action) {
        return [
            'valid' => false,
            'score' => $score,
            'message' => 'Action reCAPTCHA invalide.'
        ];
    }

    if ($hasScore && $score < $resolvedThreshold) {
        return [
            'valid' => false,
            'score' => $score,
            'message' => 'Score reCAPTCHA insuffisant.'
        ];
    }

    return [
        'valid' => true,
        'score' => $score,
        'message' => ''
    ];
}
