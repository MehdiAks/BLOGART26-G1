<?php // Ouverture du bloc PHP pour exécuter du code serveur.
// On charge la configuration globale du site (connexion DB, constantes, etc.).
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Inclut le fichier de configuration en utilisant le chemin racine du serveur.

// On prépare la liste des feuilles de style spécifiques à cette page.
$pageStyles = [ // Déclare un tableau qui contiendra les styles spécifiques.
    ROOT_URL . '/src/css/style.css', // Ajoute le chemin absolu vers la feuille de style principale.
]; // Termine la déclaration du tableau.
$pageHasVideo = true; // Indique que la page utilise une vidéo de fond.
$pageBackgroundVideo = ROOT_URL . '/src/video/Background_index.mp4'; // Définit l'URL de la vidéo de fond.
$pageBackgroundPoster = ROOT_URL . '/src/images/background/background-index-1.webp'; // Définit l'image de secours (poster) de la vidéo.

// On inclut l'en-tête HTML (balises <head>, menu, etc.).
require_once 'header.php'; // Injecte le contenu de l'en-tête commun.

// On ouvre la connexion à la base de données.
sql_connect(); // Appelle la fonction qui initialise la connexion SQL.

function resolve_article_image_url(?string $path, string $defaultImage): string // Déclare une fonction qui résout l'URL de l'image d'article.
{
    if (!$path) { // Vérifie si le chemin d'image est vide ou nul.
        return $defaultImage; // Retourne l'image par défaut si aucun chemin n'est fourni.
    }

    if (preg_match('/^https?:\/\//', $path)) { // Teste si le chemin est déjà une URL complète.
        return $path; // Retourne l'URL telle quelle si elle est absolue.
    }

    if (strpos($path, '/src/uploads/') !== false) { // Vérifie si le chemin contient déjà le dossier d'uploads.
        $relative = substr($path, strpos($path, '/src/uploads/') + strlen('/src/uploads/')); // Extrait le chemin relatif après /src/uploads/.
    } else { // Sinon, si le chemin ne contient pas ce segment.
        $relative = ltrim($path, '/'); // Supprime les slashs initiaux pour obtenir un chemin relatif.
    }

    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $relative; // Construit le chemin disque complet vers l'image.
    if (file_exists($filePath)) { // Vérifie si le fichier existe réellement sur le serveur.
        return ROOT_URL . '/src/uploads/' . $relative; // Retourne l'URL publique de l'image si elle existe.
    }

    return $defaultImage; // Retourne l'image par défaut si le fichier n'existe pas.
}

// On prépare la requête SQL pour récupérer 3 articles au hasard.
// - ORDER BY RAND() mélange aléatoirement les lignes.
// - LIMIT 3 garantit qu'on n'affiche jamais plus de 3 articles.

$articleStmt = $DB->prepare( // Prépare une requête SQL via PDO.
    'SELECT numArt, libTitrArt, libChapoArt, urlPhotArt, dtCreaArt
    FROM ARTICLE
    ORDER BY RAND()
    LIMIT 3' // Déclare la requête qui sélectionne 3 articles aléatoires.
); // Termine la préparation de la requête.
// On exécute la requête préparée.
$articleStmt->execute(); // Lance l'exécution de la requête SQL.
// On récupère les résultats sous forme de tableau associatif.
$ba_bec_articles = $articleStmt->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes en tableau associatif.

// On récupère les prochains matchs à domicile (Barbey) pour les équipes 1 garçons et filles.
$nextMatches = [ // Initialise le tableau des prochains matchs.
    'SG1' => null, // Place une valeur nulle pour l'équipe garçons 1.
    'SF1' => null, // Place une valeur nulle pour l'équipe filles 1.
]; // Termine la déclaration du tableau.
$becMatchesAvailable = true; // Indique que les matchs sont disponibles par défaut.

$formatMatchDate = static function (string $matchDate): string { // Définit une fonction pour formater une date de match.
    $date = DateTime::createFromFormat('Y-m-d', $matchDate); // Crée un objet DateTime à partir du format attendu.
    if (!$date) { // Vérifie si la date n'a pas pu être créée.
        return $matchDate; // Retourne la chaîne d'origine si le parsing échoue.
    }

    $capitalizeFirst = static function (string $value): string { // Définit une fonction interne pour capitaliser la première lettre.
        if ($value === '') { // Vérifie si la chaîne est vide.
            return $value; // Retourne la chaîne vide sans modification.
        }
        if (function_exists('mb_substr') && function_exists('mb_strtoupper')) { // Vérifie si les fonctions multibyte existent.
            $first = mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8'); // Met en majuscule le premier caractère.
            $rest = mb_substr($value, 1, null, 'UTF-8'); // Récupère le reste de la chaîne en UTF-8.
            return $first . $rest; // Concatène la première lettre et le reste.
        }
        return ucfirst($value); // Utilise ucfirst si mb_* n'est pas disponible.
    };

    if (class_exists('IntlDateFormatter')) { // Vérifie si l'extension Intl est disponible.
        $formatter = new IntlDateFormatter( // Instancie un formateur de date en français.
            'fr_FR', // Locale française.
            IntlDateFormatter::FULL, // Format long pour le jour.
            IntlDateFormatter::NONE, // Pas d'heure.
            $date->getTimezone()->getName(), // Utilise le fuseau horaire de l'objet DateTime.
            IntlDateFormatter::GREGORIAN, // Utilise le calendrier grégorien.
            'EEEE d MMMM' // Définit le motif de formatage.
        );
        $formatted = $formatter->format($date); // Formate la date avec le formateur.
        if ($formatted !== false) { // Vérifie que le formatage a réussi.
            return $capitalizeFirst($formatted); // Retourne la date formatée avec majuscule.
        }
    }

    return $date->format('d/m/Y'); // Retourne un format simple si Intl n'est pas disponible.
};

$formatMatchTime = static function (?string $matchTime): string { // Définit une fonction pour formater l'heure du match.
    if (empty($matchTime)) { // Vérifie si l'heure est vide.
        return ''; // Retourne une chaîne vide si aucune heure n'est fournie.
    }
    $time = DateTime::createFromFormat('H:i:s', $matchTime) ?: DateTime::createFromFormat('H:i', $matchTime); // Parse l'heure avec ou sans secondes.
    return $time ? $time->format('H\hi') : $matchTime; // Formate en "Hhi" si possible, sinon renvoie l'original.
};

$logoDirectory = $_SERVER['DOCUMENT_ROOT'] . '/src/images/logo/logo-adversaire'; // Définit le dossier local des logos adverses.
$logoWebBase = ROOT_URL . '/src/images/logo/logo-adversaire'; // Définit la base URL correspondante aux logos.
$becLogoUrl = ROOT_URL . '/src/images/logo/logo-bec/logo.png'; // Définit l'URL du logo BEC.
$defaultLogoUrl = ROOT_URL . '/src/images/logo/team-default.svg'; // Définit l'URL du logo par défaut.

$normalizeClubKey = static function (string $name): string { // Définit une fonction pour normaliser un nom de club.
    $name = trim($name); // Supprime les espaces en début et fin.
    if ($name === '') { // Vérifie si le nom est vide.
        return ''; // Retourne une chaîne vide si le nom est vide.
    }
    $name = preg_replace('/\s+\d+$/', '', $name); // Supprime un numéro d'équipe en fin de nom.
    $name = preg_replace('/\s+/', ' ', $name); // Remplace les espaces multiples par un seul.
    $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT', $name); // Tente de translittérer en ASCII.
    if ($transliterated !== false) { // Vérifie si la translittération a réussi.
        $name = $transliterated; // Remplace le nom par sa version translittérée.
    }
    $name = strtoupper($name); // Passe le nom en majuscules.
    $name = preg_replace('/[^A-Z0-9]+/', '_', $name); // Remplace tout caractère non alphanumérique par un underscore.
    return trim($name, '_'); // Supprime les underscores en début et fin.
};

$buildLogoMap = static function () use ($logoDirectory, $logoWebBase, $normalizeClubKey): array { // Définit une fonction qui construit la carte des logos.
    static $logoMap = null; // Stocke la carte en cache statique.
    if (is_array($logoMap)) { // Vérifie si la carte est déjà construite.
        return $logoMap; // Retourne la carte en cache.
    }
    $logoMap = []; // Initialise la carte de logos vide.
    if (!is_dir($logoDirectory)) { // Vérifie si le dossier des logos existe.
        return $logoMap; // Retourne une carte vide si le dossier n'existe pas.
    }
    $files = glob($logoDirectory . '/*.{png,PNG,jpg,JPG,jpeg,JPEG,avif,AVIF,webp,WEBP,svg,SVG}', GLOB_BRACE) ?: []; // Liste les fichiers d'images compatibles.
    foreach ($files as $file) { // Parcourt chaque fichier de logo.
        $baseName = pathinfo($file, PATHINFO_FILENAME); // Récupère le nom de fichier sans extension.
        $key = $normalizeClubKey($baseName); // Normalise le nom pour en faire une clé.
        if ($key === '' || isset($logoMap[$key])) { // Ignore si la clé est vide ou déjà présente.
            continue; // Passe au fichier suivant.
        }
        $logoMap[$key] = $logoWebBase . '/' . basename($file); // Associe la clé à l'URL du logo.
    }
    return $logoMap; // Retourne la carte des logos.
};

$resolveClubLogo = static function (?string $clubName) use ($normalizeClubKey, $buildLogoMap, $defaultLogoUrl): string { // Définit une fonction qui résout le logo d'un club.
    $key = $normalizeClubKey((string) $clubName); // Normalise le nom du club.
    if ($key === '') { // Vérifie si la clé est vide.
        return $defaultLogoUrl; // Retourne le logo par défaut.
    }
    $logoMap = $buildLogoMap(); // Récupère la carte des logos.
    return $logoMap[$key] ?? $defaultLogoUrl; // Retourne le logo trouvé ou le défaut.
};

$resolveTeamLogo = static function (string $teamName, string $becTeamName) use ($normalizeClubKey, $resolveClubLogo, $becLogoUrl): string { // Définit une fonction qui choisit le logo pour une équipe.
    $normalizedTeam = $normalizeClubKey($teamName); // Normalise le nom de l'équipe.
    $normalizedBec = $normalizeClubKey($becTeamName); // Normalise le nom BEC.
    if ($normalizedTeam !== '' && $normalizedTeam === $normalizedBec) { // Vérifie si l'équipe est le BEC.
        return $becLogoUrl; // Retourne le logo BEC si c'est le même club.
    }
    return $resolveClubLogo($teamName); // Sinon, retourne le logo du club adverse.
};

$clubIdentifiers = [ // Déclare une liste d'identifiants de club.
    'bec', // Ajoute le mot-clé "bec".
    'bordeaux', // Ajoute le mot-clé "bordeaux".
    'etudiant', // Ajoute le mot-clé "etudiant".
]; // Termine la liste.

$matches = []; // Initialise le tableau des matchs.
try { // Démarre un bloc try pour interroger la base.
    $matchesStmt = $DB->prepare( // Prépare la requête SQL pour les matchs.
        "SELECT
            m.dateMatch AS matchDate,
            m.heureMatch AS matchTime,
            m.lieuMatch AS location,
            m.scoreBec AS scoreBec,
            m.scoreAdversaire AS scoreAdversaire,
            m.clubAdversaire AS clubAdversaire,
            m.numEquipeAdverse AS numEquipeAdverse,
            m.source AS source,
            m.codeEquipe AS teamCode,
            e.nomEquipe AS teamName
        FROM `MATCH` m
        INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe
        WHERE m.dateMatch >= CURDATE()
        ORDER BY m.dateMatch ASC, m.heureMatch ASC" // Sélectionne les matchs à venir triés par date.
    );
    $matchesStmt->execute(); // Exécute la requête SQL.
    $matches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC); // Récupère tous les résultats en tableau associatif.
} catch (PDOException $exception) { // Capture une exception PDO si la requête échoue.
    $becMatchesAvailable = false; // Indique que les matchs ne sont pas disponibles.
}

$resolveMatchSide = static function (?string $location): string { // Définit une fonction pour déterminer domicile/extérieur.
    $location = strtolower(trim((string) $location)); // Normalise le lieu en minuscules.
    if ($location === '') { // Vérifie si le lieu est vide.
        return 'home'; // Par défaut, considère que c'est à domicile.
    }
    if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) { // Teste les mots-clés d'extérieur.
        return 'away'; // Retourne "away" si c'est un match à l'extérieur.
    }
    if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) { // Teste les mots-clés domicile.
        return 'home'; // Retourne "home" si c'est un match à domicile.
    }
    return 'home'; // Valeur par défaut si aucun mot-clé reconnu.
};

$buildOpponent = static function (array $match): string { // Définit une fonction pour construire le nom de l'adversaire.
    $opponent = trim((string) ($match['clubAdversaire'] ?? '')); // Récupère le club adverse ou une chaîne vide.
    if (!empty($match['numEquipeAdverse'])) { // Vérifie si un numéro d'équipe adverse existe.
        $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']); // Ajoute le numéro d'équipe au nom.
    }
    return $opponent !== '' ? $opponent : 'Adversaire'; // Retourne le nom ou "Adversaire" par défaut.
};

foreach ($matches as $match) { // Parcourt chaque match récupéré.
    $side = $resolveMatchSide($match['location'] ?? ''); // Détermine si le match est à domicile ou extérieur.
    $isHome = $side !== 'away'; // Définit un booléen pour le domicile.
    $opponent = $buildOpponent($match); // Construit le nom de l'adversaire.
    $teamHome = $isHome ? ($match['teamName'] ?? 'BEC') : $opponent; // Définit l'équipe à domicile.
    $teamAway = $isHome ? $opponent : ($match['teamName'] ?? 'BEC'); // Définit l'équipe à l'extérieur.
    $teamCode = strtoupper(trim((string) ($match['teamCode'] ?? ''))); // Normalise le code d'équipe en majuscules.
    $teamHomeName = strtolower($teamHome); // Met le nom de l'équipe domicile en minuscules.
    $teamAwayName = strtolower($teamAway); // Met le nom de l'équipe extérieure en minuscules.
    $key = null; // Initialise la clé d'équipe ciblée.
    if ($teamCode === 'SF1') { // Vérifie si le code est SF1.
        $key = 'SF1'; // Assigne la clé SF1.
    } elseif ($teamCode === 'SG1') { // Vérifie si le code est SG1.
        $key = 'SG1'; // Assigne la clé SG1.
    } elseif ($teamHomeName !== '' && (str_contains($teamHomeName, 'sf1') || str_contains($teamHomeName, 'filles 1') || str_contains($teamHomeName, 'fille 1'))) { // Détecte SF1 dans le nom.
        $key = 'SF1'; // Assigne la clé SF1.
    } elseif ($teamHomeName !== '' && (str_contains($teamHomeName, 'sg1') || str_contains($teamHomeName, 'garçons 1') || str_contains($teamHomeName, 'garcons 1') || str_contains($teamHomeName, 'garcon 1'))) { // Détecte SG1 dans le nom.
        $key = 'SG1'; // Assigne la clé SG1.
    }

    if ($key === null || $nextMatches[$key] !== null) { // Ignore si la clé est nulle ou déjà remplie.
        continue; // Passe au match suivant.
    }
    $location = strtolower(trim((string) ($match['location'] ?? ''))); // Normalise le lieu en minuscules.
    if ($location !== '' && !str_contains($location, 'barbey') && !str_contains($location, 'domicile')) { // Vérifie si le match est à Barbey.
        continue; // Ignore les matchs qui ne sont pas à domicile.
    }

    $nextMatches[$key] = [ // Stocke le prochain match pour la clé sélectionnée.
        'teamHome' => $teamHome, // Ajoute l'équipe à domicile.
        'teamAway' => $teamAway, // Ajoute l'équipe extérieure.
        'matchDate' => $match['matchDate'], // Ajoute la date du match.
        'matchTime' => $match['matchTime'] ?? '', // Ajoute l'heure du match.
        'location' => $match['location'] ?? 'Gymnase Barbey', // Ajoute le lieu du match.
        'source' => $match['source'] ?? '', // Ajoute la source d'information.
        'becTeam' => $match['teamName'] ?? 'BEC', // Ajoute le nom de l'équipe BEC.
        'teamCode' => $teamCode, // Ajoute le code d'équipe.
    ];
}

$homeStats = []; // Initialise le tableau des statistiques à domicile.
if ($becMatchesAvailable) { // Vérifie si les matchs sont disponibles.
    try { // Démarre un bloc try pour la requête des statistiques.
        $homeStatsStmt = $DB->prepare( // Prépare la requête SQL des statistiques.
            "SELECT
                SUM(CASE WHEN scoreBec IS NOT NULL THEN scoreBec ELSE 0 END) AS pointsFor,
                SUM(CASE WHEN scoreAdversaire IS NOT NULL THEN scoreAdversaire ELSE 0 END) AS pointsAgainst,
                SUM(CASE WHEN scoreBec IS NOT NULL AND scoreAdversaire IS NOT NULL THEN 1 ELSE 0 END) AS homeMatchCount
            FROM `MATCH`" // Calcule les points et le nombre de matchs.
        );
        $homeStatsStmt->execute(); // Exécute la requête des statistiques.
        $homeStats = $homeStatsStmt->fetch(PDO::FETCH_ASSOC) ?: []; // Récupère les résultats ou un tableau vide.
        $homeStats = [ // Normalise les statistiques en entiers.
            'matches' => (int) ($homeStats['homeMatchCount'] ?? 0), // Convertit le nombre de matchs en entier.
            'pointsFor' => (int) ($homeStats['pointsFor'] ?? 0), // Convertit les points marqués en entier.
            'pointsAgainst' => (int) ($homeStats['pointsAgainst'] ?? 0), // Convertit les points encaissés en entier.
        ];
    } catch (PDOException $exception) { // Capture l'exception si la requête échoue.
        $becMatchesAvailable = false; // Signale l'indisponibilité des statistiques.
    }
}

if (!$becMatchesAvailable) { // Vérifie si les matchs ne sont pas disponibles.
    $homeStats = [ // Définit des valeurs de repli pour les statistiques.
        'matches' => 'À déterminer', // Texte de remplacement pour le nombre de matchs.
        'pointsFor' => 'beaucoup', // Texte de remplacement pour les points marqués.
        'pointsAgainst' => '0', // Texte de remplacement pour les points encaissés.
    ];
}
?>

<style> /* Ouvre une balise style pour définir du CSS spécifique. */
    .typewriter-line { /* Déclare le style des lignes animées. */
        position: relative; /* Place l'élément en position relative pour l'after. */
        display: inline-block; /* Garde la ligne en bloc inline. */
        white-space: nowrap; /* Empêche le retour à la ligne automatique. */
    }
    .typewriter-line::after { /* Définit le curseur du typewriter. */
        content: ""; /* Crée un pseudo-élément vide. */
        display: inline-block; /* Affiche le curseur comme un bloc inline. */
        width: 2px; /* Définit la largeur du curseur. */
        height: 1em; /* Définit la hauteur du curseur. */
        background: currentColor; /* Utilise la couleur du texte pour le curseur. */
        margin-left: 6px; /* Ajoute un espace à gauche du curseur. */
        vertical-align: -0.1em; /* Ajuste l'alignement vertical. */
        animation: caret-blink 0.9s steps(1) infinite; /* Anime le clignotement du curseur. */
    }
    .typewriter-line.is-done::after { /* Style du curseur quand l'animation est terminée. */
        opacity: 0; /* Rend le curseur invisible. */
        animation: none; /* Arrête l'animation. */
    }
    @keyframes caret-blink { /* Définit l'animation de clignotement. */
        50% { opacity: 0; } /* Cache le curseur à 50% du cycle. */
    }
    @media (prefers-reduced-motion: reduce) { /* Média query pour réduire les animations. */
        .typewriter-line::after { /* Cible le curseur en mode réduit. */
            animation: none; /* Désactive l'animation du curseur. */
        }
    }

    .home-matches-section { /* Style général de la section des matchs. */
        background: #7a0019; /* Définit un fond rouge foncé. */
        color: #ffffff; /* Définit une couleur de texte blanche. */
        padding: 2rem; /* Ajoute un padding intérieur. */
        border-radius: 1.5rem; /* Arrondit les angles de la section. */
    }

    .home-matches-section h2 { /* Style du titre de la section. */
        font-size: 1.5rem; /* Définit la taille du titre. */
    }

    .home-matches-section p { /* Style des paragraphes de la section. */
        font-size: 0.95rem; /* Définit la taille du texte. */
    }

    .home-matches-section .text-body-secondary { /* Style du texte secondaire dans la section. */
        color: rgba(255, 255, 255, 0.75) !important; /* Définit un blanc semi-transparent. */
    }

    .home-matches-section .card { /* Style des cartes de match. */
        background: transparent; /* Rend le fond transparent. */
        color: #ffffff; /* Définit le texte en blanc. */
        border: 1px solid rgba(255, 255, 255, 0.2); /* Ajoute une bordure translucide. */
    }

    .home-matches-section .card .text-body-secondary { /* Style du texte secondaire dans les cartes. */
        color: rgba(255, 255, 255, 0.7) !important; /* Définit un blanc encore plus translucide. */
    }

    .home-match-card h3 { /* Style des titres de match. */
        font-size: 1rem; /* Réduit la taille du titre. */
    }

    .home-match-logos { /* Style du conteneur des logos. */
        display: flex; /* Affiche les logos en flexbox. */
        align-items: center; /* Aligne verticalement les logos. */
        gap: 0.75rem; /* Définit l'espace entre les logos. */
    }

    .home-match-logo { /* Style de chaque logo. */
        width: 88px; /* Définit la largeur du logo. */
        height: 88px; /* Définit la hauteur du logo. */
        display: flex; /* Utilise flexbox pour centrer l'image. */
        align-items: center; /* Centre verticalement l'image. */
        justify-content: center; /* Centre horizontalement l'image. */
    }

    .home-match-logo img { /* Style de l'image de logo. */
        max-width: 100%; /* Limite la largeur de l'image au conteneur. */
        max-height: 100%; /* Limite la hauteur de l'image au conteneur. */
        object-fit: contain; /* Conserve les proportions de l'image. */
    }

    .home-match-vs { /* Style du séparateur "vs". */
        font-size: 0.85rem; /* Définit la taille du texte. */
        font-weight: 600; /* Définit une graisse moyenne. */
        letter-spacing: 0.08em; /* Augmente l'espacement des lettres. */
        text-transform: uppercase; /* Force le texte en majuscules. */
        color: #ffffff; /* Définit la couleur blanche. */
        opacity: 1; /* Définit l'opacité à 100%. */
    }

    .home-match-info { /* Style des informations de match. */
        margin-bottom: 0; /* Supprime la marge basse. */
        line-height: 1.2; /* Définit l'interligne. */
    }

    .home-matches-section .btn-outline-light { /* Style du bouton clair. */
        color: #ffffff; /* Définit la couleur du texte en blanc. */
        border-color: #ffffff; /* Définit la couleur de la bordure en blanc. */
    }
</style> /* Ferme la balise style. */
<section class="home-hero full-bleed"> <!-- Ouvre la section héro avec largeur pleine. -->
    <div class="home-hero-content text-start"> <!-- Ouvre le conteneur du contenu héro aligné à gauche. -->
        <h2 class="fw-bold mb-0 typewriter-line" data-typewriter data-text="Bordeaux étudiant club"></h2><br> <!-- Titre principal avec animation typewriter et saut de ligne. -->
        <h3 class="fw-bold mb-0 typewriter-line" data-typewriter data-text="Basket-ball"></h3> <!-- Sous-titre avec animation typewriter. -->
    </div> <!-- Ferme le conteneur du contenu héro. -->
</section> <!-- Ferme la section héro. -->
<div class="container py-5 home-main-surface home-main-surface--hidden"> <!-- Ouvre le conteneur principal avec padding. -->
    <section class="home-section text-center"> <!-- Ouvre la section d'accueil centrée. -->
        <h1 class="fw-bold mb-3">Bienvenue au BEC</h1> <!-- Titre principal de bienvenue. -->
        <p class="lead mb-4"> <!-- Ouvre le paragraphe de présentation. -->
            Bordeaux n'est pas seulement son miroir d'eau ou encore ses cannelés. C'est aussi une ville de sport et de talent ! <br> <!-- Texte descriptif avec saut de ligne. -->
            Ce blog permet de suivre toute l'actualité du Bordeaux Etudiant Club, les jours de matchs, les résultats, les évènements, les joueurs, ... <!-- Suite du texte descriptif. -->
            <br>Le but ? Mettre en valeur la section basket du club, partager les performances de l'équipe ainsi que ses valeurs du sport. <!-- Objectif du blog avec saut de ligne. -->
        </p> <!-- Ferme le paragraphe de présentation. -->
        <div class="d-flex gap-2 justify-content-center"> <!-- Ouvre le conteneur des boutons alignés. -->
            <a class="btn btn-primary" href="actualites.php">Voir les actualités</a> <!-- Lien vers la page actualités. -->
            <a class="btn btn-outline-secondary" href="contact.php">Nous contacter</a> <!-- Lien vers la page contact. -->
        </div> <!-- Ferme le conteneur des boutons. -->
    </section> <!-- Ferme la section d'accueil. -->

    <section class="home-section home-matches-section"> <!-- Ouvre la section des matchs à domicile. -->
        <h2 class="fw-bold mb-3 text-center">Nos prochains matchs à Barbey !</h2> <!-- Titre de la section matchs. -->
        <div class="row g-4"> <!-- Ouvre la rangée de cartes. -->
            <?php if (!$becMatchesAvailable): ?> <!-- Vérifie si les matchs ne sont pas disponibles. -->
                <div class="col-12"> <!-- Ouvre une colonne pleine largeur. -->
                    <article class="card h-100 border-0 shadow-sm"> <!-- Ouvre une carte d'information. -->
                        <div class="card-body"> <!-- Ouvre le corps de la carte. -->
                            <span class="badge text-bg-secondary mb-2">Matchs à venir</span> <!-- Badge d'information. -->
                            <h3 class="h5 mb-2">Consultez le calendrier officiel</h3> <!-- Titre de la carte. -->
                            <p class="mb-3 text-body-secondary"> <!-- Ouvre le paragraphe descriptif. -->
                                Les prochains matchs sont disponibles sur le site de la FFBB. <!-- Texte d'information. -->
                            </p> <!-- Ferme le paragraphe. -->
                            <a class="btn btn-primary" href="https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024" target="_blank" rel="noopener noreferrer"> <!-- Lien vers le calendrier FFBB. -->
                                Voir le calendrier FFBB <!-- Texte du bouton. -->
                            </a> <!-- Ferme le lien du bouton. -->
                        </div> <!-- Ferme le corps de la carte. -->
                    </article> <!-- Ferme la carte. -->
                </div> <!-- Ferme la colonne. -->
            <?php else: ?> <!-- Sinon, si les matchs sont disponibles. -->
                <?php
                $matchCards = [ // Prépare les cartes de match à afficher.
                    $nextMatches['SG1'] ? array_merge($nextMatches['SG1'], ['badge' => 'text-bg-primary']) : null, // Ajoute le match SG1 si dispo.
                    $nextMatches['SF1'] ? array_merge($nextMatches['SF1'], ['badge' => 'text-bg-danger']) : null, // Ajoute le match SF1 si dispo.
                ];
                ?>
                <?php foreach ($matchCards as $match): ?> <!-- Parcourt chaque carte de match. -->
                    <div class="col-12 col-lg-6"> <!-- Ouvre une colonne responsive. -->
                        <article class="card h-100 border-0 shadow-sm home-match-card"> <!-- Ouvre la carte de match. -->
                            <div class="card-body"> <!-- Ouvre le corps de la carte de match. -->
                                <?php if ($match): ?> <!-- Vérifie si le match existe. -->
                                    <?php $label = $match['label'] ?? ''; ?> <!-- Récupère un label optionnel. -->
                                    <?php if ($label !== ''): ?> <!-- Vérifie si le label n'est pas vide. -->
                                        <span class="badge <?php echo $match['badge']; ?> mb-2"> <!-- Ouvre un badge coloré. -->
                                            <?php echo htmlspecialchars($label); ?> <!-- Affiche le label en échappant HTML. -->
                                        </span> <!-- Ferme le badge. -->
                                    <?php endif; ?> <!-- Termine la condition du label. -->
                                    <?php
                                    $becTeamKey = $normalizeClubKey($match['becTeam'] ?? ''); // Normalise la clé de l'équipe BEC.
                                    $homeKey = $normalizeClubKey($match['teamHome'] ?? ''); // Normalise la clé de l'équipe domicile.
                                    $awayKey = $normalizeClubKey($match['teamAway'] ?? ''); // Normalise la clé de l'équipe extérieure.
                                    $teamCodeLabel = $match['teamCode'] ?? ''; // Récupère le code d'équipe pour affichage.
                                    $displayHome = ($homeKey !== '' && $homeKey === $becTeamKey && $teamCodeLabel !== '')
                                        ? $teamCodeLabel
                                        : ($match['teamHome'] ?? ''); // Définit le texte affiché pour domicile.
                                    $displayAway = ($awayKey !== '' && $awayKey === $becTeamKey && $teamCodeLabel !== '')
                                        ? $teamCodeLabel
                                        : ($match['teamAway'] ?? ''); // Définit le texte affiché pour extérieur.
                                    ?>
                                    <h3 class="h5 mb-2 text-center"> <!-- Ouvre le titre du match. -->
                                        <?php echo htmlspecialchars($displayHome); ?> vs. <?php echo htmlspecialchars($displayAway); ?> <!-- Affiche les équipes. -->
                                    </h3> <!-- Ferme le titre du match. -->
                                    <?php
                                    $homeLogo = $resolveTeamLogo($match['teamHome'], $match['becTeam']); // Résout le logo domicile.
                                    $awayLogo = $resolveTeamLogo($match['teamAway'], $match['becTeam']); // Résout le logo extérieur.
                                    $location = trim((string) ($match['location'] ?? '')); // Récupère le lieu du match.
                                    $locationLower = function_exists('mb_strtolower')
                                        ? mb_strtolower($location, 'UTF-8')
                                        : strtolower($location); // Normalise le lieu en minuscules.
                                    ?>
                                    <div class="home-match-logos justify-content-center my-3"> <!-- Ouvre la zone des logos. -->
                                        <div class="home-match-logo"> <!-- Ouvre le conteneur logo domicile. -->
                                            <img src="<?php echo htmlspecialchars($homeLogo); ?>" alt="Logo <?php echo htmlspecialchars($match['teamHome']); ?>"> <!-- Affiche le logo domicile. -->
                                        </div> <!-- Ferme le conteneur logo domicile. -->
                                        <span class="home-match-vs">vs</span> <!-- Affiche le séparateur "vs". -->
                                        <div class="home-match-logo"> <!-- Ouvre le conteneur logo extérieur. -->
                                            <img src="<?php echo htmlspecialchars($awayLogo); ?>" alt="Logo <?php echo htmlspecialchars($match['teamAway']); ?>"> <!-- Affiche le logo extérieur. -->
                                        </div> <!-- Ferme le conteneur logo extérieur. -->
                                    </div> <!-- Ferme la zone des logos. -->
                                    <p class="home-match-info text-center"> <!-- Ouvre le paragraphe date. -->
                                        <strong><?php echo htmlspecialchars($formatMatchDate($match['matchDate'])); ?></strong> <!-- Affiche la date formatée. -->
                                    </p> <!-- Ferme le paragraphe date. -->
                                    <?php if ($formatMatchTime($match['matchTime']) !== ''): ?> <!-- Vérifie si l'heure existe. -->
                                        <p class="home-match-info text-center"><?php echo htmlspecialchars($formatMatchTime($match['matchTime'])); ?></p> <!-- Affiche l'heure formatée. -->
                                    <?php endif; ?> <!-- Termine la condition sur l'heure. -->
                                    <?php if ($location !== '' && $locationLower !== 'domicile'): ?> <!-- Vérifie s'il faut afficher le lieu. -->
                                        <p class="home-match-info text-center text-body-secondary"><?php echo htmlspecialchars($location); ?></p> <!-- Affiche le lieu du match. -->
                                    <?php endif; ?> <!-- Termine la condition sur le lieu. -->
                                    <?php if (!empty($match['source'])): ?> <!-- Vérifie si une source existe. -->
                                        <div class="text-center mt-3"> <!-- Ouvre le conteneur du bouton source. -->
                                            <a class="btn btn-outline-light btn-sm" href="<?php echo htmlspecialchars($match['source']); ?>" target="_blank" rel="noopener noreferrer"> <!-- Lien vers la source. -->
                                                En savoir plus <!-- Texte du bouton. -->
                                            </a> <!-- Ferme le lien du bouton. -->
                                        </div> <!-- Ferme le conteneur du bouton. -->
                                    <?php endif; ?> <!-- Termine la condition sur la source. -->
                                <?php else: ?> <!-- Sinon, si aucun match. -->
                                    <span class="badge text-bg-secondary mb-2">Match à venir</span> <!-- Badge par défaut. -->
                                    <h3 class="h5 mb-2">Planning en cours</h3> <!-- Titre par défaut. -->
                                    <p class="mb-1 text-body-secondary">Planning des prochains matchs en cours.</p> <!-- Texte par défaut. -->
                                <?php endif; ?> <!-- Termine la condition sur le match. -->
                            </div> <!-- Ferme le corps de la carte. -->
                        </article> <!-- Ferme la carte. -->
                    </div> <!-- Ferme la colonne. -->
                <?php endforeach; ?> <!-- Termine la boucle sur les cartes. -->
            <?php endif; ?> <!-- Termine la condition sur les matchs disponibles. -->
        </div> <!-- Ferme la rangée de cartes. -->
    </section> <!-- Ferme la section des matchs. -->

    <section class="home-section"> <!-- Ouvre la section statistiques. -->
        <h2 class="fw-bold mb-4">Cette saison à Barbey</h2> <!-- Titre des statistiques. -->
        <p class="text-body-secondary mb-4"> <!-- Ouvre le paragraphe descriptif. -->
        Les chiffres des matchs séniors disputés à domicile. <!-- Texte descriptif des stats. -->
        </p> <!-- Ferme le paragraphe descriptif. -->
        <div class="row g-4"> <!-- Ouvre la rangée des cartes de stats. -->
        <div class="col-12 col-md-4"> <!-- Ouvre la colonne statistiques 1. -->
            <article class="card h-100 border-0 shadow-sm"> <!-- Ouvre la carte statistiques 1. -->
            <div class="card-body"> <!-- Ouvre le corps de la carte. -->
                <p class="text-uppercase text-body-secondary mb-2">Matchs joués</p> <!-- Libellé de la statistique. -->
                <p <!-- Ouvre le paragraphe qui affiche la statistique. -->
                class="display-6 fw-bold mb-0" <!-- Applique la classe de style du compteur. -->
                <?php if ($becMatchesAvailable): ?> <!-- Vérifie si les données sont disponibles. -->
                    data-counter <!-- Ajoute l'attribut utilisé par le script de compteur. -->
                    data-target="<?php echo number_format((int) $homeStats['matches'], 0, ',', ' '); ?>" <!-- Définit la cible du compteur. -->
                <?php endif; ?> <!-- Termine la condition d'attributs. -->
                > <!-- Ferme la balise d'ouverture du paragraphe. -->
                <?php echo $becMatchesAvailable ? '0' : htmlspecialchars((string) $homeStats['matches']); ?> <!-- Affiche 0 ou la valeur de repli. -->
                </p> <!-- Ferme le paragraphe de la statistique. -->
            </div> <!-- Ferme le corps de la carte. -->
            </article> <!-- Ferme la carte. -->
        </div> <!-- Ferme la colonne. -->
        <div class="col-12 col-md-4"> <!-- Ouvre la colonne statistiques 2. -->
            <article class="card h-100 border-0 shadow-sm"> <!-- Ouvre la carte statistiques 2. -->
            <div class="card-body"> <!-- Ouvre le corps de la carte. -->
                <p class="text-uppercase text-body-secondary mb-2">Points marqués</p> <!-- Libellé de la statistique. -->
                <p <!-- Ouvre le paragraphe qui affiche la statistique. -->
                class="display-6 fw-bold mb-0" <!-- Applique la classe de style du compteur. -->
                <?php if ($becMatchesAvailable): ?> <!-- Vérifie si les données sont disponibles. -->
                    data-counter <!-- Ajoute l'attribut utilisé par le script de compteur. -->
                    data-target="<?php echo number_format((int) $homeStats['pointsFor'], 0, ',', ' '); ?>" <!-- Définit la cible du compteur. -->
                <?php endif; ?> <!-- Termine la condition d'attributs. -->
                > <!-- Ferme la balise d'ouverture du paragraphe. -->
                <?php echo $becMatchesAvailable ? '0' : htmlspecialchars((string) $homeStats['pointsFor']); ?> <!-- Affiche 0 ou la valeur de repli. -->
                </p> <!-- Ferme le paragraphe de la statistique. -->
            </div> <!-- Ferme le corps de la carte. -->
            </article> <!-- Ferme la carte. -->
        </div> <!-- Ferme la colonne. -->
        <div class="col-12 col-md-4"> <!-- Ouvre la colonne statistiques 3. -->
            <article class="card h-100 border-0 shadow-sm"> <!-- Ouvre la carte statistiques 3. -->
            <div class="card-body"> <!-- Ouvre le corps de la carte. -->
                <p class="text-uppercase text-body-secondary mb-2">Points encaissés</p> <!-- Libellé de la statistique. -->
                <p <!-- Ouvre le paragraphe qui affiche la statistique. -->
                class="display-6 fw-bold mb-0" <!-- Applique la classe de style du compteur. -->
                <?php if ($becMatchesAvailable): ?> <!-- Vérifie si les données sont disponibles. -->
                    data-counter <!-- Ajoute l'attribut utilisé par le script de compteur. -->
                    data-target="<?php echo number_format((int) $homeStats['pointsAgainst'], 0, ',', ' '); ?>" <!-- Définit la cible du compteur. -->
                <?php endif; ?> <!-- Termine la condition d'attributs. -->
                > <!-- Ferme la balise d'ouverture du paragraphe. -->
                <?php echo $becMatchesAvailable ? '0' : htmlspecialchars((string) $homeStats['pointsAgainst']); ?> <!-- Affiche 0 ou la valeur de repli. -->
                </p> <!-- Ferme le paragraphe de la statistique. -->
            </div> <!-- Ferme le corps de la carte. -->
            </article> <!-- Ferme la carte. -->
        </div> <!-- Ferme la colonne. -->
        </div> <!-- Ferme la rangée des cartes de stats. -->
    </section> <!-- Ferme la section statistiques. -->
<script> // Ouvre le bloc JavaScript pour les compteurs.
    const counters = document.querySelectorAll("[data-counter]"); // Sélectionne les éléments qui portent l'attribut data-counter.

    function parseNumber(value) { // Déclare une fonction pour convertir une valeur affichée en nombre.
        const normalized = value.replace(/\\s/g, \"\").replace(\",\", \".\"); // Supprime les espaces et normalise la virgule.
        return Number.parseFloat(normalized); // Retourne la valeur en nombre flottant.
    }

    function formatNumber(value, template) { // Déclare une fonction pour reformater un nombre à l'affichage.
        const hasSpace = template.includes(\" \"); // Détecte si la valeur cible contient un séparateur d'espace.
        return value.toLocaleString(\"fr-FR\", { // Formate la valeur selon la locale française.
            maximumFractionDigits: 0, // Limite le nombre de décimales.
            useGrouping: hasSpace, // Active les séparateurs si nécessaire.
        }); // Ferme l'appel de formatage.
    }

    function animateCounter(element) { // Déclare une fonction qui anime un compteur.
        const targetText = element.dataset.target || \"0\"; // Récupère la cible ou 0 par défaut.
        const rawTarget = parseNumber(targetText); // Convertit la cible en nombre.
        if (!Number.isFinite(rawTarget) || rawTarget < 0) { // Vérifie si la cible est invalide.
            element.textContent = targetText; // Affiche la cible brute si invalide.
            return; // Sort de la fonction.
        }

        const target = Math.floor(rawTarget); // Arrondit la cible à l'entier inférieur.
        if (target === 0) { // Vérifie si la cible est zéro.
            element.textContent = formatNumber(0, targetText); // Affiche zéro formaté.
            return; // Sort de la fonction.
        }

        let current = 0; // Initialise la valeur courante.
        const durationMs = Number.parseInt(element.dataset.duration || \"2500\", 10); // Lit la durée de l'animation.
        const safeDuration = Number.isFinite(durationMs) && durationMs > 0 ? durationMs : 1500; // Sécurise la durée.
        const minStepTime = 10; // Définit un temps de pas minimal.
        const normalStepTime = Math.max(minStepTime, Math.floor(safeDuration / Math.max(1, target))); // Calcule le pas normal.
        const fastStepTime = Math.max(8, Math.floor(normalStepTime * 0.4)); // Calcule le pas rapide.
        const midStepTime = Math.max(12, Math.floor(normalStepTime * 0.7)); // Calcule le pas intermédiaire.
        const halfTarget = Math.floor(target * 0.5); // Calcule la moitié de la cible.
        const threeQuarterTarget = Math.floor(target * 0.75); // Calcule les trois quarts de la cible.

        const tick = () => { // Définit une fonction interne de mise à jour.
            let step = 1; // Définit l'incrément par défaut.
            let delay = normalStepTime; // Définit le délai par défaut.

            if (current < halfTarget) { // Vérifie si on est avant la moitié.
                step = 10; // Accélère l'incrément.
                delay = fastStepTime; // Accélère le délai.
            } else if (current < threeQuarterTarget) { // Vérifie si on est avant les trois quarts.
                step = 2; // Ralentit l'incrément.
                delay = midStepTime; // Ajuste le délai.
            }

            current = Math.min(target, current + step); // Incrémente la valeur sans dépasser la cible.
            element.textContent = formatNumber(current, targetText); // Met à jour l'affichage du compteur.

            if (current < target) { // Vérifie si l'animation doit continuer.
                setTimeout(tick, delay); // Programme l'appel suivant.
            }
        }; // Ferme la fonction tick.

        tick(); // Démarre l'animation.
    }

    function triggerCounter(element) { // Déclare une fonction qui déclenche un compteur.
        if (element.dataset.started === \"true\") { // Vérifie si le compteur a déjà démarré.
            return; // Sort si le compteur est déjà lancé.
        }
        element.dataset.started = \"true\"; // Marque le compteur comme démarré.
        setTimeout(() => animateCounter(element), 1000); // Lance l'animation après un délai.
    }

    if (\"IntersectionObserver\" in window) { // Vérifie si l'API IntersectionObserver est disponible.
        const observer = new IntersectionObserver( // Crée un observer d'intersection.
            (entries) => { // Fonction de rappel appelée lors des intersections.
                entries.forEach((entry) => { // Parcourt chaque entrée observée.
                    if (entry.isIntersecting) { // Vérifie si l'élément est visible.
                        triggerCounter(entry.target); // Déclenche le compteur pour l'élément visible.
                        observer.unobserve(entry.target); // Arrête d'observer l'élément.
                    }
                }); // Termine la boucle sur les entrées.
            }, // Termine la fonction de rappel.
            { threshold: 0.4 } // Configure le seuil de déclenchement.
        ); // Termine la création de l'observer.

        counters.forEach((counter) => observer.observe(counter)); // Observe chaque compteur.
    } else { // Sinon, si l'API n'est pas disponible.
        window.addEventListener(\"load\", () => { // Ajoute un écouteur de chargement.
            counters.forEach((counter) => triggerCounter(counter)); // Déclenche chaque compteur au chargement.
        }); // Ferme l'écouteur de chargement.
    } // Ferme la condition IntersectionObserver.
</script> // Ferme le bloc JavaScript des compteurs.

    <section aria-label="Dernières actualités" class="home-articles"> <!-- Ouvre la section des dernières actualités. -->
        <h2 class="fw-bold mb-4">Nos dernières actualités</h2> <!-- Titre de la section des actualités. -->
            <p class="text-body-secondary mb-4">Retrouvez ci-dessous nos dernières actualités et articles récents.</p> <!-- Texte d'introduction de la section. -->
        <!-- Si on a au moins un article récupéré, on les affiche. -->
        <?php if (!empty($ba_bec_articles)): ?> <!-- Vérifie si des articles existent. -->
            <div class="home-articles-container"> <!-- Ouvre le conteneur des articles. -->
                <div class="row g-4"> <!-- Ouvre la rangée d'articles. -->
                    <!-- On parcourt les 3 articles aléatoires récupérés depuis la base. -->
                    <?php foreach ($ba_bec_articles as $ba_bec_article): ?> <!-- Parcourt chaque article. -->
                        <?php
                        // 1) On détermine l'image à afficher :
                        //    - si l'article a une image, on utilise celle-ci
                        //    - sinon on utilise l'image par défaut.
                        $defaultImagePath = ROOT_URL . '/src/images/image-defaut.jpeg'; // Définit le chemin de l'image par défaut.
                        $ba_bec_imagePath = resolve_article_image_url($ba_bec_article['urlPhotArt'] ?? null, $defaultImagePath); // Résout l'image finale.
                        // 2) On récupère le chapo (texte d'accroche) ou une chaîne vide si absent.
                        $chapo = $ba_bec_article['libChapoArt'] ?? ''; // Récupère le chapo ou une chaîne vide.
                        // 3) On fixe la longueur max de l'extrait affiché.
                        $maxLength = 160; // Définit la longueur maximale de l'extrait.
                        // 4) On tronque le chapo proprement (multibyte si disponible).
                        $excerptBase = function_exists('mb_substr') ? mb_substr($chapo, 0, $maxLength) : substr($chapo, 0, $maxLength); // Coupe le texte.
                        // 5) On calcule la longueur réelle du chapo.
                        $chapoLength = function_exists('mb_strlen') ? mb_strlen($chapo) : strlen($chapo); // Mesure la longueur réelle.
                        // 6) On ajoute "..." seulement si le chapo dépassait la limite.
                        $excerpt = $excerptBase . ($chapoLength > $maxLength ? '...' : ''); // Ajoute les points de suspension si besoin.
                        ?>
                        <div class="col-lg-4 col-md-6"> <!-- Ouvre la colonne d'article. -->
                            <article class="home-article-card" data-hover-card> <!-- Ouvre la carte d'article. -->
                                <img src="<?php echo $ba_bec_imagePath; ?>" <!-- Définit la source de l'image. -->
                                    class="home-article-image mb-3" <!-- Applique la classe d'image. -->
                                    alt="<?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?>"> <!-- Définit le texte alternatif. -->
                                <h3 class="h5 fw-bold mb-2"><?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?></h3> <!-- Affiche le titre de l'article. -->
                                <p class="fst-italic"><?php echo htmlspecialchars($excerpt); ?></p> <!-- Affiche l'extrait de l'article. -->
                                <div class="d-flex justify-content-between align-items-center mt-auto"> <!-- Ouvre la zone bas de carte. -->
                                    <small class="text-body-secondary"> <!-- Ouvre la zone date. -->
                                        <?php echo htmlspecialchars($ba_bec_article['dtCreaArt']); ?> <!-- Affiche la date de création. -->
                                    </small> <!-- Ferme la zone date. -->
                                    <a href="<?php echo ROOT_URL . '/article.php?numArt=' . (int) $ba_bec_article['numArt']; ?>" class="home-article-link">Lire la suite</a> <!-- Lien vers l'article. -->
                                </div> <!-- Ferme la zone bas de carte. -->
                            </article> <!-- Ferme la carte d'article. -->
                        </div> <!-- Ferme la colonne d'article. -->
                    <?php endforeach; ?> <!-- Termine la boucle des articles. -->
                </div> <!-- Ferme la rangée d'articles. -->
                <div class="mt-4"> <!-- Ouvre la zone du bouton voir plus. -->
                    <a class="btn btn-primary" href="actualites.php">Voir les autres actualités</a> <!-- Lien vers toutes les actualités. -->
                </div> <!-- Ferme la zone du bouton. -->
            </div> <!-- Ferme le conteneur des articles. -->
        <?php else: ?> <!-- Sinon, si aucun article n'existe. -->
            <!-- Si aucun article n'est disponible, on affiche un message d'information. -->
            <div class="alert alert-info mb-0" role="status"> <!-- Ouvre l'alerte d'information. -->
                Aucune actualité disponible pour le moment. <!-- Texte d'alerte. -->
            </div> <!-- Ferme l'alerte d'information. -->
        <?php endif; ?> <!-- Termine la condition sur les articles. -->
    </section> <!-- Ferme la section des actualités. -->
</div> <!-- Ferme le conteneur principal. -->

<script> // Ouvre le script d'animation du typewriter.
    (function () { // Encapsule le script dans une IIFE.
        const lines = Array.from(document.querySelectorAll("[data-typewriter]")); // Sélectionne les lignes à animer.
        if (!lines.length) { // Vérifie s'il n'y a aucune ligne.
            return; // Quitte le script si rien à animer.
        }

        const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches; // Détecte la préférence de mouvement réduit.
        const speedMs = 70; // Définit la vitesse de frappe.
        const lineDelayMs = 350; // Définit le délai entre les lignes.

        const typeLine = (element) => // Définit une fonction pour animer une ligne.
            new Promise((resolve) => { // Retourne une promesse résolue en fin d'animation.
                const text = element.dataset.text || ""; // Récupère le texte à afficher.
                if (prefersReducedMotion) { // Vérifie si l'utilisateur préfère moins d'animations.
                    element.textContent = text; // Affiche le texte immédiatement.
                    element.classList.add("is-done"); // Ajoute la classe de fin.
                    resolve(); // Résout la promesse.
                    return; // Quitte la fonction.
                }

                let index = 0; // Initialise l'index de progression.
                element.textContent = ""; // Vide le texte au départ.
                element.classList.remove("is-done"); // Retire la classe de fin si présente.

                const tick = () => { // Définit une fonction interne de frappe.
                    element.textContent = text.slice(0, index); // Affiche le texte jusqu'à l'index.
                    if (index >= text.length) { // Vérifie si la ligne est complète.
                        element.classList.add("is-done"); // Marque la ligne comme terminée.
                        setTimeout(resolve, lineDelayMs); // Attends puis résout la promesse.
                        return; // Sort de la fonction tick.
                    }
                    index += 1; // Incrémente l'index.
                    setTimeout(tick, speedMs); // Programme le prochain tick.
                };

                tick(); // Lance la frappe de la ligne.
            }); // Ferme la promesse.

        (async () => { // Démarre une IIFE asynchrone.
            for (const line of lines) { // Parcourt chaque ligne.
                await typeLine(line); // Anime chaque ligne séquentiellement.
            }
        })(); // Exécute l'IIFE asynchrone.
    })(); // Exécute l'IIFE principale.
</script> // Ferme le script d'animation du typewriter.
<script src="<?php echo ROOT_URL . '/src/js/home-articles-hover.js'; ?>"></script> <!-- Charge le script de survol des articles. -->
<script src="<?php echo ROOT_URL . '/src/js/home-scroll-reveal.js'; ?>"></script> <!-- Charge le script d'apparition au scroll. -->
<?php require_once 'footer.php'; ?> <!-- Inclut le pied de page commun. -->

<p></p> <!-- Ligne vide finale. -->
