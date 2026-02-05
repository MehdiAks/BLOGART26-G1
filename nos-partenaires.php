<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [
    ROOT_URL . '/src/css/nos-partenaires.css',
];

require_once 'header.php';

$partners = [
    [
        'name' => 'Ville de Bordeaux',
        'type' => 'Institutionnel',
        'description' => 'Un soutien de proximité pour accompagner nos projets sportifs et citoyens.',
        'website' => 'https://www.bordeaux.fr',
    ],
    [
        'name' => 'Région Nouvelle-Aquitaine',
        'type' => 'Institutionnel',
        'description' => 'Un partenaire engagé pour le développement du sport étudiant.',
        'website' => 'https://www.nouvelle-aquitaine.fr',
    ],
    [
        'name' => 'Maison des Sports de Bordeaux',
        'type' => 'Infrastructure',
        'description' => 'Des infrastructures adaptées pour accueillir nos entraînements et événements.',
        'website' => 'https://www.bordeaux.fr/o7635/maison-des-sports',
    ],
    [
        'name' => 'Société Générale',
        'type' => 'Partenaire financier',
        'description' => 'Un accompagnement financier pour soutenir nos équipes et nos déplacements.',
        'website' => 'https://www.societegenerale.fr',
    ],
    [
        'name' => 'Intersport Campus',
        'type' => 'Équipementier',
        'description' => 'Des équipements performants pour nos joueurs et joueuses.',
        'website' => 'https://www.intersport.fr',
    ],
    [
        'name' => 'Groupe Ferré',
        'type' => 'Partenaire premium',
        'description' => 'Un soutien durable pour les actions locales et la formation.',
        'website' => 'https://www.groupeferre.com',
    ],
    [
        'name' => 'Le Bar des Étudiants',
        'type' => 'Partenaire événementiel',
        'description' => 'Un lieu convivial pour nos rencontres et nos soirées partenaires.',
        'website' => 'https://www.bordeaux.fr',
    ],
    [
        'name' => 'Imprimeur Aquitaine',
        'type' => 'Communication',
        'description' => 'La création de nos supports visuels et de nos affiches de match.',
        'website' => 'https://www.imprimeur-aquitaine.fr',
    ],
];
?>

<main class="container py-5 partners-page">
    <section class="partners-hero">
        <p class="partners-hero__eyebrow">Nos partenaires</p>
        <h1 class="partners-hero__title">Ils rendent possible l'aventure BEC</h1>
        <p class="partners-hero__text">
            Chaque saison, nous avançons aux côtés d'acteurs locaux, régionaux et nationaux qui partagent nos valeurs.
            Retrouvez ici la liste de celles et ceux qui soutiennent nos équipes, nos événements et nos projets.
        </p>
    </section>

    <section class="partners-list" aria-label="Liste des partenaires">
        <div class="row g-4">
            <?php foreach ($partners as $partner): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card partner-card h-100">
                        <div class="card-body d-flex flex-column gap-3">
                            <div>
                                <span class="badge partner-card__badge"><?php echo htmlspecialchars($partner['type']); ?></span>
                                <h2 class="partner-card__title"><?php echo htmlspecialchars($partner['name']); ?></h2>
                                <p class="partner-card__text"><?php echo htmlspecialchars($partner['description']); ?></p>
                            </div>
                            <a class="partner-card__link mt-auto" href="<?php echo htmlspecialchars($partner['website']); ?>" target="_blank" rel="noopener noreferrer">
                                Visiter le site
                            </a>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
