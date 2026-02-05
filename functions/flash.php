<?php
const FLASH_MESSAGE_SUCCESS = 'Opération réalisée avec succès.';
const FLASH_MESSAGE_ERROR = 'Une erreur est survenue. Merci de réessayer.';
const FLASH_MESSAGE_DELETE_IMPOSSIBLE = 'Suppression impossible : cet élément est utilisé.';

function flash_add(string $type, string $message): void {
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }
    $_SESSION['flash'][] = [
        'type' => $type,
        'message' => $message,
    ];
}

function flash_success(?string $message = null): void {
    flash_add('success', $message ?? FLASH_MESSAGE_SUCCESS);
}

function flash_error(?string $message = null): void {
    flash_add('error', $message ?? FLASH_MESSAGE_ERROR);
}

function flash_delete_impossible(?string $message = null): void {
    flash_add('warning', $message ?? FLASH_MESSAGE_DELETE_IMPOSSIBLE);
}

function flash_get(): array {
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}
?>
