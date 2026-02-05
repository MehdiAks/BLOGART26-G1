<?php

class StatutController
{
    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require_once __DIR__ . '/../config.php';
        include __DIR__ . '/../header.php';
        include __DIR__ . '/../' . $view;
        include __DIR__ . '/../footer.php';
    }

    public function list(): void
    {
        require_once __DIR__ . '/../config.php';
        $ba_bec_statuts = sql_select('STATUT', '*');
        $this->render('views/backend/statuts/list.php', [
            'ba_bec_statuts' => $ba_bec_statuts,
        ]);
    }

    public function create(): void
    {
        $this->render('views/backend/statuts/create.php');
    }

    public function store(): void
    {
        require_once __DIR__ . '/../config.php';
        require_once __DIR__ . '/../functions/ctrlSaisies.php';

        $ba_bec_libStat = ctrlSaisies($_POST['libStat'] ?? '');

        $ba_bec_currentMax = sql_select('STATUT', 'MAX(numStat) AS maxStat');
        $ba_bec_nextNumStat = 1;
        if (!empty($ba_bec_currentMax) && isset($ba_bec_currentMax[0]['maxStat'])) {
            $ba_bec_nextNumStat = (int) $ba_bec_currentMax[0]['maxStat'] + 1;
        }

        sql_insert('STATUT', 'numStat, libStat', "'$ba_bec_nextNumStat', '$ba_bec_libStat'");

        header('Location: ' . ROOT_URL . '/public/index.php?controller=statut&action=list');
        exit;
    }

    public function edit(): void
    {
        require_once __DIR__ . '/../config.php';

        $ba_bec_numStat = $_GET['numStat'] ?? '';
        $ba_bec_libStat = '';

        if ($ba_bec_numStat !== '') {
            $ba_bec_libStat = sql_select('STATUT', 'libStat', "numStat = $ba_bec_numStat")[0]['libStat'] ?? '';
        }

        $this->render('views/backend/statuts/edit.php', [
            'ba_bec_numStat' => $ba_bec_numStat,
            'ba_bec_libStat' => $ba_bec_libStat,
        ]);
    }

    public function update(): void
    {
        require_once __DIR__ . '/../config.php';
        require_once __DIR__ . '/../functions/ctrlSaisies.php';

        $ba_bec_numStat = ctrlSaisies($_POST['numStat'] ?? '');
        $ba_bec_libStat = ctrlSaisies($_POST['libStat'] ?? '');

        sql_update(table: 'STATUT', attributs: 'libStat = "' . $ba_bec_libStat . '"', where: "numStat = $ba_bec_numStat");

        header('Location: ' . ROOT_URL . '/public/index.php?controller=statut&action=list');
        exit;
    }

    public function delete(): void
    {
        require_once __DIR__ . '/../config.php';

        $ba_bec_numStat = $_GET['numStat'] ?? '';
        $ba_bec_libStat = '';

        if ($ba_bec_numStat !== '') {
            $ba_bec_libStat = sql_select('STATUT', 'libStat', "numStat = $ba_bec_numStat")[0]['libStat'] ?? '';
        }

        $this->render('views/backend/statuts/delete.php', [
            'ba_bec_numStat' => $ba_bec_numStat,
            'ba_bec_libStat' => $ba_bec_libStat,
        ]);
    }

    public function destroy(): void
    {
        require_once __DIR__ . '/../config.php';
        require_once __DIR__ . '/../functions/ctrlSaisies.php';

        $ba_bec_numStat = ctrlSaisies($_POST['numStat'] ?? '');

        $ba_bec_countnumStat = sql_select('MEMBRE', 'COUNT(*) AS total', "numStat = $ba_bec_numStat")[0]['total'] ?? 0;

        if ($ba_bec_countnumStat > 0) {
            header('Location: ' . ROOT_URL . '/public/index.php?controller=statut&action=list&error=used');
            exit;
        }

        sql_delete('STATUT', "numStat = $ba_bec_numStat");

        header('Location: ' . ROOT_URL . '/public/index.php?controller=statut&action=list&success=deleted');
        exit;
    }
}
