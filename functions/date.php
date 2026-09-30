<?php

/**
 * Formate une date en français sans dépendre de l'extension intl.
 *
 * @param mixed $date Chaîne, timestamp ou objet DateTimeInterface.
 */
function format_date_fr($date, bool $withTime = false): string
{
    if ($date instanceof DateTimeInterface) {
        $ba_bec_date = $date instanceof DateTimeImmutable ? $date : DateTimeImmutable::createFromMutable($date);
    } elseif (is_int($date) || (is_string($date) && preg_match('/^\d{10}$/', $date))) {
        $ba_bec_date = (new DateTimeImmutable())->setTimestamp((int) $date);
    } else {
        $ba_bec_value = trim((string) $date);
        if ($ba_bec_value === '') {
            return '';
        }
        $ba_bec_date = null;
        foreach (['!Y-m-d H:i:s', '!Y-m-d H:i', '!Y-m-d', '!d/m/Y H:i:s', '!d/m/Y H:i', '!d/m/Y'] as $ba_bec_format) {
            $ba_bec_candidate = DateTimeImmutable::createFromFormat($ba_bec_format, $ba_bec_value);
            $ba_bec_errors = DateTimeImmutable::getLastErrors();
            if ($ba_bec_candidate !== false && ($ba_bec_errors === false || ($ba_bec_errors['warning_count'] === 0 && $ba_bec_errors['error_count'] === 0))) {
                $ba_bec_date = $ba_bec_candidate;
                break;
            }
        }
        if (!$ba_bec_date) {
            try {
                $ba_bec_date = new DateTimeImmutable($ba_bec_value);
            } catch (Exception $exception) {
                return $ba_bec_value;
            }
        }
    }

    $ba_bec_months = [1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
    $ba_bec_result = (int) $ba_bec_date->format('j') . ' ' . $ba_bec_months[(int) $ba_bec_date->format('n')] . ' ' . $ba_bec_date->format('Y');

    if ($withTime) {
        $ba_bec_result .= ' à ' . $ba_bec_date->format('H') . ' h ' . $ba_bec_date->format('i');
    }

    return $ba_bec_result;
}

/**
 * Format compact utilisé par les cartes du calendrier.
 */
function format_match_date_fr($date, $time = null): string
{
    $ba_bec_value = trim((string) $date . ' ' . (string) $time);
    try {
        $ba_bec_date = new DateTimeImmutable($ba_bec_value);
    } catch (Exception $exception) {
        return trim((string) $date);
    }

    $ba_bec_days = [0 => 'dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'];
    $ba_bec_months = [1 => 'janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
    $ba_bec_result = $ba_bec_days[(int) $ba_bec_date->format('w')] . ' ' . (int) $ba_bec_date->format('j') . ' ' . $ba_bec_months[(int) $ba_bec_date->format('n')];
    if ($time !== null && trim((string) $time) !== '') {
        $ba_bec_result .= ' · ' . $ba_bec_date->format('H') . ' h ' . $ba_bec_date->format('i');
    }
    return $ba_bec_result;
}
