<?php
// includes/cookie-consent.php

// Durée de validité en MINUTES
define('COOKIE_CONSENT_DURATION_MINUTES', 1440); // 1 jour

/**
 * Obtenir l'adresse IP de l'utilisateur
 */
function getCookieUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

/**
 * Vérifier si l'utilisateur a déjà fait un choix (valide)
 */
function hasUserMadeCookieChoice() {
    $ip = getCookieUserIP();

    $ba_bec_result = sql_select(
        "COOKIE_CONSENT",
        "*",
        "ipAdresse = '" . $ip . "'"
    );

    if (empty($ba_bec_result)) {
        return false;
    }

    // Vérifier manuellement si la date d'expiration n'est pas dépassée
    $expiration = strtotime($ba_bec_result[0]['dateExpiration']);
    $now = time();

    return $expiration > $now;
}

/**
 * Vérifier si l'utilisateur a accepté les cookies
 */
function hasAcceptedCookies() {
    $ip = getCookieUserIP();

    $ba_bec_result = sql_select(
        "COOKIE_CONSENT",
        "choixConsent, dateExpiration",
        "ipAdresse = '" . $ip . "'"
    );

    if (empty($ba_bec_result)) {
        return false;
    }

    // Vérifier manuellement si la date d'expiration n'est pas dépassée
    $expiration = strtotime($ba_bec_result[0]['dateExpiration']);
    $now = time();

    if ($expiration <= $now) {
        return false;
    }

    return $ba_bec_result[0]['choixConsent'] === 'accepted';
}

/**
 * Enregistrer le choix de l'utilisateur
 */
function saveCookieConsent($choice) {
    global $DB;

    $ip = getCookieUserIP();
    $dateExpiration = date('Y-m-d H:i:s', strtotime('+' . COOKIE_CONSENT_DURATION_MINUTES . ' minutes'));

    // Vérifier si l'IP existe déjà
    $existing = sql_select(
        "COOKIE_CONSENT",
        "numCon",
        "ipAdresse = '" . $ip . "'"
    );

    if (!empty($existing)) {
        // Mettre à jour
        $query = "UPDATE COOKIE_CONSENT 
            SET choixConsent = '" . $choice . "', 
                dateCon = NOW(), 
                dateExpiration = '" . $dateExpiration . "' 
                WHERE ipAdresse = '" . $ip . "'";
        $DB->exec($query);
    } else {
        // Insérer
        $query = "INSERT INTO COOKIE_CONSENT (ipAdresse, choixConsent, dateCon, dateExpiration) 
                VALUES ('" . $ip . "', '" . $choice . "', NOW(), '" . $dateExpiration . "')";
        $DB->exec($query);
    }
}

/**
 * Nettoyer les consentements expirés
 */
function cleanExpiredConsents() {
    global $DB;
    $query = "DELETE FROM COOKIE_CONSENT WHERE dateExpiration < NOW()";
    $DB->exec($query);
}

// Traiter l'acceptation/refus des cookies via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept_cookies'])) {
        saveCookieConsent('accepted');

        setcookie(
            'cookieConsent',
            'accepted',
            time() + (COOKIE_CONSENT_DURATION_MINUTES * 60),
            '/',
            '',
            false,
            true
        );

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    if (isset($_POST['reject_cookies'])) {
        saveCookieConsent('rejected');

        setcookie(
            'cookieConsent',
            'rejected',
            time() + (COOKIE_CONSENT_DURATION_MINUTES * 60),
            '/',
            '',
            false,
            true
        );

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// Nettoyer les consentements expirés (1 fois sur 100)
if (rand(1, 100) === 1) {
    cleanExpiredConsents();
}
?>