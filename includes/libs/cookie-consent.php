<?php
/**
 * GESTION DU CONSENTEMENT COOKIES (RGPD)
 * Ce script permet de synchroniser le choix de l'utilisateur entre son navigateur (Cookie)
 * et son compte utilisateur en base de données (Table membre).
 */

// Initialisation de la session pour identifier si un utilisateur est connecté
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuration : Nom du cookie et durée de validité (ici 1 an)
define('COOKIE_DURATION', 365 * 24 * 60 * 60);
define('COOKIE_NAME', 'bec_cookie_consent');

/* ==========================================================================
   OUTILS : Fonctions utilitaires
   ========================================================================== */

/**
 * Crée ou met à jour le cookie physique sur le navigateur de l'utilisateur
 * @param int $consent (0 pour refus, 1 pour acceptation)
 */
function setConsentCookie(int $consent) {
    setcookie(
        COOKIE_NAME,
        (string) $consent,
        time() + COOKIE_DURATION, // Expiration : maintenant + 1 an
        '/',                      // Disponible sur tout le domaine
        '',                       // Domaine vide = domaine actuel
        false,                    // Secure : false (devrait être true si HTTPS)
        true                      // HttpOnly : true (protection contre les failles XSS/JS)
    );
}

/* ==========================================================================
   LECTURE : Récupération du choix actuel
   ========================================================================== */

/**
 * Récupère le consentement en priorité depuis la BDD (si connecté) sinon via cookie
 * @param PDO|null $pdo Connexion à la base de données
 */
function getCookieConsent($pdo) {
    // Sécurité : Si l'objet PDO n'est pas valide, on ne regarde que le cookie navigateur
    if (!$pdo instanceof PDO) {
        if (isset($_COOKIE[COOKIE_NAME])) {
            return (int) $_COOKIE[COOKIE_NAME];
        }
        return null; // Aucun choix n'a encore été fait
    }

    // --- CAS 1 : L'UTILISATEUR EST CONNECTÉ ---
    if (!empty($_SESSION['user_id'])) {
        // 1. On cherche d'abord la valeur stockée dans son profil membre
        $stmt = $pdo->prepare("SELECT cookieMemb FROM membre WHERE numMemb = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $memberConsent = $stmt->fetchColumn();

        // Si une valeur existe en BDD (différente de vide ou false), on la retourne
        if ($memberConsent !== false && $memberConsent !== null && $memberConsent !== '') {
            return $memberConsent;
        }

        // 2. Si rien en BDD mais qu'un cookie existe sur le navigateur, on synchronise
        if (isset($_COOKIE[COOKIE_NAME])) {
            $cookieConsent = (int) $_COOKIE[COOKIE_NAME];
            
            // On enregistre le choix du cookie dans le compte du membre
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

    // --- CAS 2 : VISITEUR ANONYME (NON CONNECTÉ) ---
    // On se base uniquement sur le cookie du navigateur
    if (isset($_COOKIE[COOKIE_NAME])) {
        return (int) $_COOKIE[COOKIE_NAME];
    }

    return null; // Le visiteur n'a pas encore fait de choix
}

/* ==========================================================================
   SAUVEGARDE : Enregistrement d'un nouveau choix
   ========================================================================== */

/**
 * Enregistre le choix de l'utilisateur (Acceptation ou Refus)
 * @param PDO|null $pdo
 * @param int $consent Valeur du consentement
 */
function saveCookieConsent($pdo, int $consent) {
    // Si la base de données est indisponible, on arrête tout
    if (!$pdo instanceof PDO) {
        return;
    }

    // --- SI CONNECTÉ : Sauvegarde BDD + Cookie ---
    if (!empty($_SESSION['user_id'])) {
        $stmt = $pdo->prepare(
            "UPDATE membre 
             SET cookieMemb = ?, dtMajMemb = NOW() 
             WHERE numMemb = ?"
        );
        $stmt->execute([$consent, $_SESSION['user_id']]);
        
        // On crée aussi le cookie pour que le choix soit persistant côté client
        setConsentCookie($consent);
        return;
    }

    // --- SI ANONYME : Sauvegarde Cookie uniquement ---
    setConsentCookie($consent);
}