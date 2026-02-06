<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Ligne vide pour aération.

// Cette ligne contient: $pageStyles = [
$pageStyles = [
// Cette ligne contient: ROOT_URL . '/src/css/boutique.css',
    ROOT_URL . '/src/css/boutique.css',
// Cette ligne contient: ];
];
// Ligne vide pour aération.

// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
// Ligne vide pour aération.

// Cette ligne contient: $ba_bec_articles = sql_select('boutique', '*', null, null, 'numArtBoutique');
$ba_bec_articles = sql_select('boutique', '*', null, null, 'numArtBoutique');
// Ligne vide pour aération.

// Cette ligne contient: $formatPrice = static function (?float $price): string {
$formatPrice = static function (?float $price): string {
// Cette ligne contient: if ($price === null) {
    if ($price === null) {
// Cette ligne contient: return '';
        return '';
// Cette ligne contient: }
    }
// Cette ligne contient: return number_format($price, 2, ',', ' ') . ' €';
    return number_format($price, 2, ',', ' ') . ' €';
// Cette ligne contient: };
};
// Ligne vide pour aération.

// Cette ligne contient: $formatList = static function ($value): string {
$formatList = static function ($value): string {
// Cette ligne contient: if ($value === null || $value === '') {
    if ($value === null || $value === '') {
// Cette ligne contient: return '';
        return '';
// Cette ligne contient: }
    }
// Cette ligne contient: if (is_array($value)) {
    if (is_array($value)) {
// Cette ligne contient: return implode(', ', $value);
        return implode(', ', $value);
// Cette ligne contient: }
    }
// Cette ligne contient: if (is_string($value)) {
    if (is_string($value)) {
// Cette ligne contient: $decoded = json_decode($value, true);
        $decoded = json_decode($value, true);
// Cette ligne contient: if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
// Cette ligne contient: return implode(', ', $decoded);
            return implode(', ', $decoded);
// Cette ligne contient: }
        }
// Cette ligne contient: return $value;
        return $value;
// Cette ligne contient: }
    }
// Cette ligne contient: return '';
    return '';
// Cette ligne contient: };
};
// Ligne vide pour aération.

// Cette ligne contient: $extractImage = static function ($value): string {
$extractImage = static function ($value): string {
// Cette ligne contient: if (empty($value)) {
    if (empty($value)) {
// Cette ligne contient: return '';
        return '';
// Cette ligne contient: }
    }
// Cette ligne contient: if (is_array($value)) {
    if (is_array($value)) {
// Cette ligne contient: return $value[0] ?? '';
        return $value[0] ?? '';
// Cette ligne contient: }
    }
// Cette ligne contient: if (is_string($value)) {
    if (is_string($value)) {
// Cette ligne contient: $decoded = json_decode($value, true);
        $decoded = json_decode($value, true);
// Cette ligne contient: if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
// Cette ligne contient: return $decoded[0] ?? '';
            return $decoded[0] ?? '';
// Cette ligne contient: }
        }
// Cette ligne contient: return $value;
        return $value;
// Cette ligne contient: }
    }
// Cette ligne contient: return '';
    return '';
// Cette ligne contient: };
};
// Cette ligne contient: ?>
?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="boutique-page"> -->
<section class="boutique-page">
<!-- Cette ligne contient: <div class="boutique-hero"> -->
    <div class="boutique-hero">
<!-- Cette ligne contient: <h1>La boutique du BEC</h1> -->
        <h1>La boutique du BEC</h1>
<!-- Cette ligne contient: <p>Découvrez nos articles officiels. Toutes les tenues sont disponibles du XS au XXL pour équiper petits et grands supporters.</p> -->
        <p>Découvrez nos articles officiels. Toutes les tenues sont disponibles du XS au XXL pour équiper petits et grands supporters.</p>
<!-- Cette ligne contient: </div> -->
    </div>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php if (empty($ba_bec_articles)): ?> -->
    <?php if (empty($ba_bec_articles)): ?>
<!-- Cette ligne contient: <div class="boutique-note"> -->
        <div class="boutique-note">
<!-- Cette ligne contient: Aucun article n'est disponible pour le moment. -->
            Aucun article n'est disponible pour le moment.
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: <?php endif; ?> -->
    <?php endif; ?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <div class="boutique-grid"> -->
    <div class="boutique-grid">
<!-- Cette ligne contient: <?php foreach ($ba_bec_articles as $article): ?> -->
        <?php foreach ($ba_bec_articles as $article): ?>
<!-- Cette ligne contient: <?php -->
            <?php
// Cette ligne contient: $imageName = $extractImage($article['urlPhotoArtBoutique'] ?? '');
            $imageName = $extractImage($article['urlPhotoArtBoutique'] ?? '');
// Cette ligne contient: $imageUrl = $imageName ? ROOT_URL . '/src/images/article-boutique/' . htmlspecialchars($imageName) : '';
            $imageUrl = $imageName ? ROOT_URL . '/src/images/article-boutique/' . htmlspecialchars($imageName) : '';
// Cette ligne contient: $adultPrice = $article['prixAdulteArtBoutique'] ?? null;
            $adultPrice = $article['prixAdulteArtBoutique'] ?? null;
// Cette ligne contient: $childPrice = $article['prixEnfantArtBoutique'] ?? null;
            $childPrice = $article['prixEnfantArtBoutique'] ?? null;
// Cette ligne contient: $colors = $formatList($article['couleursArtBoutique'] ?? '');
            $colors = $formatList($article['couleursArtBoutique'] ?? '');
// Cette ligne contient: $sizes = $formatList($article['taillesArtBoutique'] ?? '');
            $sizes = $formatList($article['taillesArtBoutique'] ?? '');
// Cette ligne contient: ?>
            ?>
<!-- Cette ligne contient: <article class="boutique-card"> -->
            <article class="boutique-card">
<!-- Cette ligne contient: <div class="boutique-card__media"> -->
                <div class="boutique-card__media">
<!-- Cette ligne contient: <?php if ($imageUrl): ?> -->
                    <?php if ($imageUrl): ?>
<!-- Cette ligne contient: <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($article['libArtBoutique']); ?>"> -->
                        <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($article['libArtBoutique']); ?>">
<!-- Cette ligne contient: <?php else: ?> -->
                    <?php else: ?>
<!-- Cette ligne contient: Image à venir -->
                        Image à venir
<!-- Cette ligne contient: <?php endif; ?> -->
                    <?php endif; ?>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <div> -->
                <div>
<!-- Cette ligne contient: <div class="boutique-card__category"> -->
                    <div class="boutique-card__category">
<!-- Cette ligne contient: <?php echo htmlspecialchars($article['categorieArtBoutique'] ?? 'Boutique'); ?> -->
                        <?php echo htmlspecialchars($article['categorieArtBoutique'] ?? 'Boutique'); ?>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: <h2 class="boutique-card__title"><?php echo htmlspecialchars($article['libArtBoutique']); ?></h2> -->
                    <h2 class="boutique-card__title"><?php echo htmlspecialchars($article['libArtBoutique']); ?></h2>
<!-- Cette ligne contient: <?php if (!empty($article['descArtBoutique'])): ?> -->
                    <?php if (!empty($article['descArtBoutique'])): ?>
<!-- Cette ligne contient: <p class="mb-2"><?php echo htmlspecialchars($article['descArtBoutique']); ?></p> -->
                        <p class="mb-2"><?php echo htmlspecialchars($article['descArtBoutique']); ?></p>
<!-- Cette ligne contient: <?php endif; ?> -->
                    <?php endif; ?>
<!-- Cette ligne contient: <div class="boutique-card__details"> -->
                    <div class="boutique-card__details">
<!-- Cette ligne contient: <?php if (!empty($colors)): ?> -->
                        <?php if (!empty($colors)): ?>
<!-- Cette ligne contient: <span><strong>Couleurs :</strong> <?php echo htmlspecialchars($colors); ?></span> -->
                            <span><strong>Couleurs :</strong> <?php echo htmlspecialchars($colors); ?></span>
<!-- Cette ligne contient: <?php endif; ?> -->
                        <?php endif; ?>
<!-- Cette ligne contient: <?php if (!empty($sizes)): ?> -->
                        <?php if (!empty($sizes)): ?>
<!-- Cette ligne contient: <span><strong>Tailles :</strong> <?php echo htmlspecialchars($sizes); ?></span> -->
                            <span><strong>Tailles :</strong> <?php echo htmlspecialchars($sizes); ?></span>
<!-- Cette ligne contient: <?php endif; ?> -->
                        <?php endif; ?>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <div class="boutique-card__prices"> -->
                <div class="boutique-card__prices">
<!-- Cette ligne contient: <?php if ($childPrice !== null && $childPrice !== ''): ?> -->
                    <?php if ($childPrice !== null && $childPrice !== ''): ?>
<!-- Cette ligne contient: <span><span>Adulte</span><span><?php echo $formatPrice((float) $adultPrice); ?></span></span> -->
                        <span><span>Adulte</span><span><?php echo $formatPrice((float) $adultPrice); ?></span></span>
<!-- Cette ligne contient: <span><span>Enfant</span><span><?php echo $formatPrice((float) $childPrice); ?></span></span> -->
                        <span><span>Enfant</span><span><?php echo $formatPrice((float) $childPrice); ?></span></span>
<!-- Cette ligne contient: <?php else: ?> -->
                    <?php else: ?>
<!-- Cette ligne contient: <span><span>Prix</span><span><?php echo $formatPrice((float) $adultPrice); ?></span></span> -->
                        <span><span>Prix</span><span><?php echo $formatPrice((float) $adultPrice); ?></span></span>
<!-- Cette ligne contient: <?php endif; ?> -->
                    <?php endif; ?>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </article> -->
            </article>
<!-- Cette ligne contient: <?php endforeach; ?> -->
        <?php endforeach; ?>
<!-- Cette ligne contient: </div> -->
    </div>
<!-- Cette ligne contient: </section> -->
</section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
// Cette ligne contient: ?>
?>
