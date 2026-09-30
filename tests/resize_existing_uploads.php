<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Ce script est réservé à la ligne de commande.\n");
}

require_once dirname(__DIR__) . '/functions/upload.php';

$ba_bec_apply = in_array('--apply', $argv, true);
$ba_bec_uploadRoot = realpath(dirname(__DIR__) . '/src/uploads');
if ($ba_bec_uploadRoot === false) {
    fwrite(STDERR, "Le dossier src/uploads est introuvable.\n");
    exit(1);
}

echo $ba_bec_apply ? "Mode application.\n" : "Mode simulation (--dry-run). Utilisez --apply pour écrire.\n";
$ba_bec_iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($ba_bec_uploadRoot, FilesystemIterator::SKIP_DOTS)
);
$ba_bec_finfo = new finfo(FILEINFO_MIME_TYPE);
$ba_bec_count = 0;

foreach ($ba_bec_iterator as $ba_bec_file) {
    if (!$ba_bec_file->isFile()) {
        continue;
    }
    $ba_bec_path = $ba_bec_file->getPathname();
    $ba_bec_mime = $ba_bec_finfo->file($ba_bec_path);
    if (!in_array($ba_bec_mime, ['image/jpeg', 'image/png', 'image/webp', 'image/avif'], true)) {
        continue;
    }
    $ba_bec_dimensions = @getimagesize($ba_bec_path);
    if ($ba_bec_dimensions === false || ((int) $ba_bec_dimensions[0] <= 2000 && (int) $ba_bec_dimensions[1] <= 2000)) {
        continue;
    }
    $ba_bec_relative = substr($ba_bec_path, strlen($ba_bec_uploadRoot) + 1);
    if (!$ba_bec_apply) {
        echo "[simulation] {$ba_bec_relative} ({$ba_bec_dimensions[0]} × {$ba_bec_dimensions[1]})\n";
        $ba_bec_count++;
        continue;
    }
    $ba_bec_result = resize_image_to_max_dimensions($ba_bec_path, $ba_bec_path, $ba_bec_mime, 2000);
    if ($ba_bec_result['resized']) {
        chmod($ba_bec_path, 0644);
        echo "[redimensionné] {$ba_bec_relative}\n";
        $ba_bec_count++;
    } elseif ($ba_bec_result['skipped']) {
        echo "[ignoré: codec GD indisponible] {$ba_bec_relative}\n";
    } elseif (!$ba_bec_result['success']) {
        fwrite(STDERR, "[erreur] {$ba_bec_relative}: {$ba_bec_result['error']}\n");
    }
}

echo $ba_bec_count . ($ba_bec_apply ? " fichier(s) redimensionné(s).\n" : " fichier(s) à redimensionner.\n");

