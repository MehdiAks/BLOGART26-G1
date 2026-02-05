<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('COOKIE_DURATION', 365 * 24 * 60 * 60);
define('COOKIE_NAME', 'bec_cookie_consent');

/* =========================
OUTILS
========================= */

function setConsentCookie(int $consent) {
    setcookie(
        COOKIE_NAME,
        (string) $consent,
        time() + COOKIE_DURATION,
        '/',
        '',
        false,
        true
    );
}

/* =========================
LECTURE CONSENTEMENT
========================= */

function getCookieConsent($pdo) {
    if (!$pdo instanceof PDO) {
        if (isset($_COOKIE[COOKIE_NAME])) {
            return (int) $_COOKIE[COOKIE_NAME];
        }
        return null;
    }

    // CAS 1 : MEMBRE CONNECTE
    if (!empty($_SESSION['user_id'])) {
        $stmt = $pdo->prepare(
            "SELECT cookieMemb FROM membre WHERE numMemb = ?"
        );
        $stmt->execute([$_SESSION['user_id']]);
        $memberConsent = $stmt->fetchColumn();
        if ($memberConsent !== false && $memberConsent !== null && $memberConsent !== '') {
            return $memberConsent;
        }
        if (isset($_COOKIE[COOKIE_NAME])) {
            $cookieConsent = (int) $_COOKIE[COOKIE_NAME];
            $stmt = $pdo->prepare(
                "UPDATE membre
                SET cookieMemb = ?, dtMajMemb = NOW()
                WHERE numMemb = ?"
            );
            $stmt->execute([$cookieConsent, $_SESSION['user_id']]);
            return $cookieConsent;
        }
        return null;
    }

    // CAS 2 : VISITEUR ANONYME
    if (isset($_COOKIE[COOKIE_NAME])) {
        return (int) $_COOKIE[COOKIE_NAME];
    }

    return null;
}

/* =========================
SAUVEGARDE CONSENTEMENT
========================= */

function saveCookieConsent($pdo, int $consent) {
    if (!$pdo instanceof PDO) {
        return;
    }

    // MEMBRE CONNECTE
    if (!empty($_SESSION['user_id'])) {
        $stmt = $pdo->prepare(
            "UPDATE membre
            SET cookieMemb = ?, dtMajMemb = NOW()
            WHERE numMemb = ?"
        );
        $stmt->execute([$consent, $_SESSION['user_id']]);
        setConsentCookie($consent);
        return;
    }

    // VISITEUR ANONYME
    setConsentCookie($consent);
}
