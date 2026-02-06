<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [
    ROOT_URL . '/src/css/boutique.css',
];

require_once 'header.php';

$defaultBoutiqueArticles = [
    [
        'numArtBoutique' => 1,
        'libArtBoutique' => 'T-shirt',
        'descArtBoutique' => 'T-shirt officiel du BEC.',
        'couleursArtBoutique' => 'Rouge, noir',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 15.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 2,
        'libArtBoutique' => 'Short molleton',
        'descArtBoutique' => 'Short confortable en molleton.',
        'couleursArtBoutique' => 'Noir',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 20.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 3,
        'libArtBoutique' => 'Chaussettes',
        'descArtBoutique' => 'Chaussettes de sport BEC.',
        'couleursArtBoutique' => 'Rouge, blanc',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 10.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 4,
        'libArtBoutique' => 'Polo',
        'descArtBoutique' => 'Polo club pour les supporters.',
        'couleursArtBoutique' => 'Rouge, blanc',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 25.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 5,
        'libArtBoutique' => 'Short coton fin',
        'descArtBoutique' => 'Short léger en coton fin.',
        'couleursArtBoutique' => 'Noir',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 15.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 6,
        'libArtBoutique' => 'Casquette',
        'descArtBoutique' => 'Casquette officielle du BEC.',
        'couleursArtBoutique' => 'Blanc, bleu',
        'taillesArtBoutique' => 'Taille unique',
        'prixAdulteArtBoutique' => 15.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Accessoire',
    ],
    [
        'numArtBoutique' => 7,
        'libArtBoutique' => 'Pull',
        'descArtBoutique' => 'Pull chaud pour l\'entraînement ou le quotidien.',
        'couleursArtBoutique' => 'Rouge, noir',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 35.00,
        'prixEnfantArtBoutique' => 32.00,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 8,
        'libArtBoutique' => 'Short entraînement',
        'descArtBoutique' => 'Short respirant pour les séances.',
        'couleursArtBoutique' => 'Rouge',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 15.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 9,
        'libArtBoutique' => 'Serviette 100 x 140 cm',
        'descArtBoutique' => 'Serviette idéale pour l\'entraînement.',
        'couleursArtBoutique' => 'Rouge, blanc',
        'taillesArtBoutique' => '100 x 140 cm',
        'prixAdulteArtBoutique' => 20.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Accessoire',
    ],
    [
        'numArtBoutique' => 10,
        'libArtBoutique' => 'Doudoune sans manche',
        'descArtBoutique' => 'Doudoune légère sans manche.',
        'couleursArtBoutique' => 'Noir, bleu',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 36.00,
        'prixEnfantArtBoutique' => 34.00,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 11,
        'libArtBoutique' => 'Doudoune manche longue',
        'descArtBoutique' => 'Doudoune chaude à manches longues.',
        'couleursArtBoutique' => 'Noir, bleu',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 42.00,
        'prixEnfantArtBoutique' => 40.00,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 12,
        'libArtBoutique' => 'Jogging',
        'descArtBoutique' => 'Jogging BEC confortable.',
        'couleursArtBoutique' => 'Blanc, noir',
        'taillesArtBoutique' => 'XS à XXL',
        'prixAdulteArtBoutique' => 30.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Vêtement',
    ],
    [
        'numArtBoutique' => 13,
        'libArtBoutique' => 'Sac à dos',
        'descArtBoutique' => 'Sac à dos pratique pour les matchs.',
        'couleursArtBoutique' => 'Noir',
        'taillesArtBoutique' => 'Taille unique',
        'prixAdulteArtBoutique' => 25.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Accessoire',
    ],
    [
        'numArtBoutique' => 14,
        'libArtBoutique' => 'Gourde',
        'descArtBoutique' => 'Gourde réutilisable pour l\'entraînement.',
        'couleursArtBoutique' => 'Blanc, rouge',
        'taillesArtBoutique' => 'Taille unique',
        'prixAdulteArtBoutique' => 6.00,
        'prixEnfantArtBoutique' => null,
        'urlPhotoArtBoutique' => null,
        'categorieArtBoutique' => 'Accessoire',
    ],
];

$ba_bec_articles = sql_select('ARTICLE_BOUTIQUE', '*', null, null, 'numArtBoutique');
$useFallback = empty($ba_bec_articles);
if ($useFallback) {
    $ba_bec_articles = $defaultBoutiqueArticles;
}

$formatPrice = static function (?float $price): string {
    if ($price === null) {
        return '';
    }
    return number_format($price, 2, ',', ' ') . ' €';
};
?>

<section class="boutique-page">
    <div class="boutique-hero">
        <h1>La boutique du BEC</h1>
        <p>Découvrez nos articles officiels. Toutes les tenues sont disponibles du XS au XXL pour équiper petits et grands supporters.</p>
    </div>

    <?php if ($useFallback && sql_is_missing_table('ARTICLE_BOUTIQUE')): ?>
        <div class="boutique-note">
            La table <strong>ARTICLE_BOUTIQUE</strong> n'est pas encore disponible dans la base de données. Les articles affichés ci-dessous sont issus de la configuration par défaut en attendant l'import.
        </div>
    <?php endif; ?>

    <div class="boutique-grid">
        <?php foreach ($ba_bec_articles as $article): ?>
            <?php
            $imageName = $article['urlPhotoArtBoutique'] ?? '';
            $imageUrl = $imageName ? ROOT_URL . '/src/images/article-boutique/' . htmlspecialchars($imageName) : '';
            $adultPrice = $article['prixAdulteArtBoutique'] ?? null;
            $childPrice = $article['prixEnfantArtBoutique'] ?? null;
            ?>
            <article class="boutique-card">
                <div class="boutique-card__media">
                    <?php if ($imageUrl): ?>
                        <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($article['libArtBoutique']); ?>">
                    <?php else: ?>
                        Image à venir
                    <?php endif; ?>
                </div>
                <div>
                    <div class="boutique-card__category">
                        <?php echo htmlspecialchars($article['categorieArtBoutique'] ?? 'Boutique'); ?>
                    </div>
                    <h2 class="boutique-card__title"><?php echo htmlspecialchars($article['libArtBoutique']); ?></h2>
                    <?php if (!empty($article['descArtBoutique'])): ?>
                        <p class="mb-2"><?php echo htmlspecialchars($article['descArtBoutique']); ?></p>
                    <?php endif; ?>
                    <div class="boutique-card__details">
                        <?php if (!empty($article['couleursArtBoutique'])): ?>
                            <span><strong>Couleurs :</strong> <?php echo htmlspecialchars($article['couleursArtBoutique']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($article['taillesArtBoutique'])): ?>
                            <span><strong>Tailles :</strong> <?php echo htmlspecialchars($article['taillesArtBoutique']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="boutique-card__prices">
                    <?php if ($childPrice !== null && $childPrice !== ''): ?>
                        <span><span>Adulte</span><span><?php echo $formatPrice((float) $adultPrice); ?></span></span>
                        <span><span>Enfant</span><span><?php echo $formatPrice((float) $childPrice); ?></span></span>
                    <?php else: ?>
                        <span><span>Prix</span><span><?php echo $formatPrice((float) $adultPrice); ?></span></span>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
