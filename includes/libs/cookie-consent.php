<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('COOKIE_DURATION', 365 * 24 * 60 * 60);

/* =========================
OUTILS
========================= */

function generateToken() {
    return bin2hex(random_bytes(32));
}

function setConsentCookie($token) {
    setcookie(
        'cookie_consent_token',
        $token,
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
        if (!empty($_COOKIE['cookie_consent_token'])) {
            $stmt = $pdo->prepare(
                "SELECT consent FROM cookie_consent
                WHERE token = ? AND expires_at > NOW()"
            );
            $stmt->execute([$_COOKIE['cookie_consent_token']]);
            $tokenConsent = $stmt->fetchColumn();
            if ($tokenConsent !== false && $tokenConsent !== null && $tokenConsent !== '') {
                $stmt = $pdo->prepare(
                    "UPDATE membre
                    SET cookieMemb = ?, dtMajMemb = NOW()
                    WHERE numMemb = ?"
                );
                $stmt->execute([(int) $tokenConsent, $_SESSION['user_id']]);
                return $tokenConsent;
            }
        }
        return null;
    }

    // CAS 2 : VISITEUR ANONYME
    if (!empty($_COOKIE['cookie_consent_token'])) {
        $stmt = $pdo->prepare(
            "SELECT consent FROM cookie_consent
            WHERE token = ? AND expires_at > NOW()"
        );
        $stmt->execute([$_COOKIE['cookie_consent_token']]);
        return $stmt->fetchColumn();
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
        return;
    }

    // VISITEUR ANONYME
    $token = $_COOKIE['cookie_consent_token'] ?? generateToken();

    $stmt = $pdo->prepare(
        "REPLACE INTO cookie_consent
        (token, consent, created_at, expires_at)
        VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR))"
    );
    $stmt->execute([$token, $consent]);

    setConsentCookie($token);
}
