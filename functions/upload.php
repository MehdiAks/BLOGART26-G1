<?php

/**
 * Redimensionne une image si l'un de ses côtés dépasse la limite.
 * Retourne "skipped" lorsque GD ou le codec n'est pas disponible.
 */
function resize_image_to_max_dimensions(string $sourcePath, string $destinationPath, string $mime, int $maxDimension = 2000): array
{
    $ba_bec_dimensions = @getimagesize($sourcePath);
    if ($ba_bec_dimensions === false) {
        return ['success' => false, 'resized' => false, 'skipped' => false, 'error' => 'Image invalide.'];
    }
    $ba_bec_width = (int) $ba_bec_dimensions[0];
    $ba_bec_height = (int) $ba_bec_dimensions[1];
    if ($ba_bec_width <= $maxDimension && $ba_bec_height <= $maxDimension) {
        return ['success' => true, 'resized' => false, 'skipped' => false, 'error' => null];
    }
    if (!extension_loaded('gd') || !function_exists('imagecreatetruecolor')) {
        return ['success' => true, 'resized' => false, 'skipped' => true, 'error' => null];
    }

    $ba_bec_loaders = [
        'image/jpeg' => 'imagecreatefromjpeg',
        'image/png' => 'imagecreatefrompng',
        'image/webp' => 'imagecreatefromwebp',
        'image/avif' => 'imagecreatefromavif',
    ];
    $ba_bec_writers = [
        'image/jpeg' => 'imagejpeg',
        'image/png' => 'imagepng',
        'image/webp' => 'imagewebp',
        'image/avif' => 'imageavif',
    ];
    $ba_bec_loader = $ba_bec_loaders[$mime] ?? '';
    $ba_bec_writer = $ba_bec_writers[$mime] ?? '';
    if ($ba_bec_loader === '' || $ba_bec_writer === '' || !function_exists($ba_bec_loader) || !function_exists($ba_bec_writer)) {
        return ['success' => true, 'resized' => false, 'skipped' => true, 'error' => null];
    }

    $ba_bec_ratio = min($maxDimension / $ba_bec_width, $maxDimension / $ba_bec_height);
    $ba_bec_newWidth = max(1, (int) round($ba_bec_width * $ba_bec_ratio));
    $ba_bec_newHeight = max(1, (int) round($ba_bec_height * $ba_bec_ratio));
    $ba_bec_source = @$ba_bec_loader($sourcePath);
    if ($ba_bec_source === false) {
        return ['success' => false, 'resized' => false, 'skipped' => false, 'error' => 'Impossible de décoder l’image.'];
    }
    $ba_bec_target = imagecreatetruecolor($ba_bec_newWidth, $ba_bec_newHeight);
    if ($ba_bec_target === false) {
        imagedestroy($ba_bec_source);
        return ['success' => false, 'resized' => false, 'skipped' => false, 'error' => 'Impossible de préparer l’image.'];
    }
    if ($mime === 'image/png' || $mime === 'image/webp' || $mime === 'image/avif') {
        imagealphablending($ba_bec_target, false);
        imagesavealpha($ba_bec_target, true);
        $ba_bec_transparent = imagecolorallocatealpha($ba_bec_target, 0, 0, 0, 127);
        imagefilledrectangle($ba_bec_target, 0, 0, $ba_bec_newWidth, $ba_bec_newHeight, $ba_bec_transparent);
    }
    $ba_bec_copied = imagecopyresampled($ba_bec_target, $ba_bec_source, 0, 0, 0, 0, $ba_bec_newWidth, $ba_bec_newHeight, $ba_bec_width, $ba_bec_height);
    imagedestroy($ba_bec_source);
    if (!$ba_bec_copied) {
        imagedestroy($ba_bec_target);
        return ['success' => false, 'resized' => false, 'skipped' => false, 'error' => 'Impossible de redimensionner l’image.'];
    }

    $ba_bec_inPlace = realpath($sourcePath) !== false && realpath($sourcePath) === realpath($destinationPath);
    $ba_bec_outputPath = $ba_bec_inPlace ? $destinationPath . '.resize-' . bin2hex(random_bytes(4)) : $destinationPath;
    if ($mime === 'image/jpeg') {
        $ba_bec_written = imagejpeg($ba_bec_target, $ba_bec_outputPath, 82);
    } elseif ($mime === 'image/png') {
        $ba_bec_written = imagepng($ba_bec_target, $ba_bec_outputPath, 6);
    } elseif ($mime === 'image/webp') {
        $ba_bec_written = imagewebp($ba_bec_target, $ba_bec_outputPath, 82);
    } else {
        $ba_bec_written = imageavif($ba_bec_target, $ba_bec_outputPath, 82);
    }
    imagedestroy($ba_bec_target);
    if (!$ba_bec_written) {
        @unlink($ba_bec_outputPath);
        return ['success' => false, 'resized' => false, 'skipped' => false, 'error' => 'Impossible d’enregistrer l’image redimensionnée.'];
    }
    if ($ba_bec_inPlace && !rename($ba_bec_outputPath, $destinationPath)) {
        @unlink($ba_bec_outputPath);
        return ['success' => false, 'resized' => false, 'skipped' => false, 'error' => 'Impossible de remplacer l’image.'];
    }
    return ['success' => true, 'resized' => true, 'skipped' => false, 'error' => null];
}

// Enregistre une image validée et retourne son chemin relatif à src/uploads.
function upload_image(array $file, string $subDir, string $baseName, int $maxBytes = 5000000): array {
    $ba_bec_allowedDirs = ['article', 'photos-joueurs', 'photos-equipes', 'photos-benevoles', 'photos-boutiques'];
    if (!in_array($subDir, $ba_bec_allowedDirs, true)) {
        return ['success' => false, 'path' => null, 'error' => 'Dossier d’upload invalide.'];
    }
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return ['success' => false, 'path' => null, 'error' => 'Le transfert du fichier a échoué.'];
    }
    $ba_bec_tmpName = (string) ($file['tmp_name'] ?? '');
    if ($ba_bec_tmpName === '' || !is_uploaded_file($ba_bec_tmpName)) {
        return ['success' => false, 'path' => null, 'error' => 'Fichier transféré invalide.'];
    }
    $ba_bec_size = (int) ($file['size'] ?? 0);
    if ($ba_bec_size <= 0 || $ba_bec_size > $maxBytes) {
        return ['success' => false, 'path' => null, 'error' => 'L’image ne doit pas dépasser 5 Mo.'];
    }
    if (!class_exists('finfo')) {
        return ['success' => false, 'path' => null, 'error' => 'Validation du type de fichier indisponible.'];
    }

    $ba_bec_finfo = new finfo(FILEINFO_MIME_TYPE);
    $ba_bec_mime = $ba_bec_finfo->file($ba_bec_tmpName);
    $ba_bec_extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/avif' => 'avif',
    ];
    if (!isset($ba_bec_extensions[$ba_bec_mime])) {
        return ['success' => false, 'path' => null, 'error' => 'Format d’image non autorisé.'];
    }

    $ba_bec_dimensions = @getimagesize($ba_bec_tmpName);
    $ba_bec_avifDimensionsSupported = $ba_bec_mime === 'image/avif'
        && defined('IMG_AVIF')
        && function_exists('imagetypes')
        && (imagetypes() & constant('IMG_AVIF')) !== 0;
    if ($ba_bec_dimensions === false && ($ba_bec_mime !== 'image/avif' || $ba_bec_avifDimensionsSupported)) {
        return ['success' => false, 'path' => null, 'error' => 'Le fichier n’est pas une image valide.'];
    }
    $ba_bec_asciiName = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $baseName) ?: $baseName;
    $ba_bec_cleanName = (string) preg_replace('/[^a-z0-9-]+/', '-', strtolower($ba_bec_asciiName));
    $ba_bec_cleanName = trim($ba_bec_cleanName, '-');
    $ba_bec_cleanName = rtrim(substr($ba_bec_cleanName, 0, 30), '-');
    if ($ba_bec_cleanName === '') {
        $ba_bec_cleanName = 'image';
    }
    $ba_bec_fileName = $ba_bec_cleanName . '-' . bin2hex(random_bytes(4)) . '.' . $ba_bec_extensions[$ba_bec_mime];
    $ba_bec_root = defined('ROOT') ? ROOT : dirname(__DIR__);
    $ba_bec_uploadRoot = $ba_bec_root . '/src/uploads';
    $ba_bec_directory = $ba_bec_uploadRoot . '/' . $subDir;
    if (!is_dir($ba_bec_directory) && !mkdir($ba_bec_directory, 0755, true)) {
        return ['success' => false, 'path' => null, 'error' => 'Impossible de préparer le dossier d’upload.'];
    }
    $ba_bec_destination = $ba_bec_directory . '/' . $ba_bec_fileName;
    $ba_bec_resize = ['success' => true, 'resized' => false, 'skipped' => true, 'error' => null];
    if ($ba_bec_dimensions !== false) {
        $ba_bec_resize = resize_image_to_max_dimensions($ba_bec_tmpName, $ba_bec_destination, $ba_bec_mime, 2000);
    }
    if (!$ba_bec_resize['success']) {
        return ['success' => false, 'path' => null, 'error' => $ba_bec_resize['error']];
    }
    if (!$ba_bec_resize['resized'] && !move_uploaded_file($ba_bec_tmpName, $ba_bec_destination)) {
        return ['success' => false, 'path' => null, 'error' => 'Impossible d’enregistrer l’image.'];
    }
    chmod($ba_bec_destination, 0644);
    return ['success' => true, 'path' => $subDir . '/' . $ba_bec_fileName, 'error' => null];
}

// Supprime uniquement un fichier réellement situé dans src/uploads.
function delete_uploaded_file($path): bool {
    $ba_bec_path = str_replace('\\', '/', (string) $path);
    if (strpos($ba_bec_path, '/src/uploads/') !== false) {
        $ba_bec_path = substr($ba_bec_path, strpos($ba_bec_path, '/src/uploads/') + 13);
    }
    $ba_bec_path = ltrim($ba_bec_path, '/');
    $ba_bec_root = defined('ROOT') ? ROOT : dirname(__DIR__);
    $ba_bec_uploadRoot = realpath($ba_bec_root . '/src/uploads');
    $ba_bec_file = realpath($ba_bec_root . '/src/uploads/' . $ba_bec_path);
    if ($ba_bec_uploadRoot === false || $ba_bec_file === false
        || strpos($ba_bec_file, $ba_bec_uploadRoot . DIRECTORY_SEPARATOR) !== 0
        || !is_file($ba_bec_file)) {
        return false;
    }
    return unlink($ba_bec_file);
}

// Retourne une URL uniquement si le fichier se trouve réellement sous src/uploads.
function uploaded_file_url($path, string $fallback = ''): string {
    $ba_bec_path = str_replace('\\', '/', (string) $path);
    if (strpos($ba_bec_path, '/src/uploads/') !== false) {
        $ba_bec_path = substr($ba_bec_path, strpos($ba_bec_path, '/src/uploads/') + 13);
    }
    $ba_bec_path = ltrim($ba_bec_path, '/');
    $ba_bec_root = defined('ROOT') ? ROOT : dirname(__DIR__);
    $ba_bec_uploadRoot = realpath($ba_bec_root . '/src/uploads');
    $ba_bec_file = realpath($ba_bec_root . '/src/uploads/' . $ba_bec_path);
    if ($ba_bec_uploadRoot === false || $ba_bec_file === false
        || strpos($ba_bec_file, $ba_bec_uploadRoot . DIRECTORY_SEPARATOR) !== 0
        || !is_file($ba_bec_file)) {
        return $fallback;
    }
    $ba_bec_relative = substr($ba_bec_file, strlen($ba_bec_uploadRoot) + 1);
    return ROOT_URL . '/src/uploads/' . str_replace(DIRECTORY_SEPARATOR, '/', $ba_bec_relative);
}

// Résout les images de boutique uploadées ou les anciens fichiers du dossier public dédié.
function boutique_image_url($path, string $fallback = ''): string {
    $ba_bec_path = trim((string) $path);
    if ($ba_bec_path === '') {
        return $fallback;
    }
    if (strpos($ba_bec_path, '/src/uploads/') === 0 || strpos($ba_bec_path, 'photos-boutiques/') === 0) {
        return uploaded_file_url($ba_bec_path, $fallback);
    }

    if (strpos($ba_bec_path, '/src/images/article-boutique/') === 0) {
        $ba_bec_path = substr($ba_bec_path, strlen('/src/images/article-boutique/'));
    }
    if ($ba_bec_path !== basename($ba_bec_path)) {
        return $fallback;
    }

    $ba_bec_root = defined('ROOT') ? ROOT : dirname(__DIR__);
    $ba_bec_imageRoot = realpath($ba_bec_root . '/src/images/article-boutique');
    $ba_bec_file = realpath($ba_bec_root . '/src/images/article-boutique/' . $ba_bec_path);
    if ($ba_bec_imageRoot === false || $ba_bec_file === false
        || strpos($ba_bec_file, $ba_bec_imageRoot . DIRECTORY_SEPARATOR) !== 0
        || !is_file($ba_bec_file)) {
        return $fallback;
    }
    return ROOT_URL . '/src/images/article-boutique/' . rawurlencode(basename($ba_bec_file));
}

?>
