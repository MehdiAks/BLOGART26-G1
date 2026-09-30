<?php

class ArticleController
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
        $this->render('views/backend/articles/list.php', [
            'pageTitle' => 'Articles · Administration',
            'ba_bec_articles' => sql_select('ARTICLE', '*'),
            'ba_bec_keywords' => sql_select('MOTCLE', '*'),
            'ba_bec_keywordsart' => sql_select('MOTCLEARTICLE', '*'),
            'ba_bec_thematiques' => sql_select('THEMATIQUE', '*'),
        ]);
    }

    public function create(): void
    {
        require_once __DIR__ . '/../config.php';
        $this->render('views/backend/articles/create.php', [
            'pageTitle' => 'Nouvel article · Administration',
            'pageStyles' => [ROOT_URL . '/src/css/stylearticle.css', ROOT_URL . '/src/css/article-editor.css'],
            'ba_bec_thematiques' => sql_select('THEMATIQUE', '*'),
            'ba_bec_keywords' => sql_select('MOTCLE', '*'),
        ]);
    }

    public function store(): void
    {
        require __DIR__ . '/../api/articles/create.php';
    }

    public function edit(): void
    {
        require_once __DIR__ . '/../config.php';
        $ba_bec_numArt = isset($_GET['numArt']) ? (int) $_GET['numArt'] : 0;
        $ba_bec_article = $ba_bec_numArt
            ? (sql_select('ARTICLE', '*', 'numArt = ?', null, null, '1', [$ba_bec_numArt])[0] ?? [])
            : [];
        $this->render('views/backend/articles/edit.php', [
            'pageTitle' => 'Modifier un article · Administration',
            'pageStyles' => [ROOT_URL . '/src/css/stylearticle.css', ROOT_URL . '/src/css/article-editor.css'],
            'ba_bec_numArt' => $ba_bec_numArt,
            'ba_bec_article' => $ba_bec_article,
            'ba_bec_thematiques' => sql_select('THEMATIQUE', '*'),
            'ba_bec_keywords' => sql_select('MOTCLE', '*'),
            'ba_bec_selectedKeywords' => $ba_bec_numArt ? sql_select('MOTCLEARTICLE', '*', 'numArt = ?', null, null, null, [$ba_bec_numArt]) : [],
            'ba_bec_urlPhotArt' => $ba_bec_article['urlPhotArt'] ?? '',
        ]);
    }

    public function update(): void
    {
        require __DIR__ . '/../api/articles/update.php';
    }

    public function delete(): void
    {
        require_once __DIR__ . '/../config.php';
        $ba_bec_numArt = isset($_GET['numArt']) ? (int) $_GET['numArt'] : 0;
        $ba_bec_article = $ba_bec_numArt
            ? (sql_select('ARTICLE', '*', 'numArt = ?', null, null, '1', [$ba_bec_numArt])[0] ?? [])
            : [];
        $ba_bec_thematique = !empty($ba_bec_article['numThem'])
            ? (sql_select('THEMATIQUE', '*', 'numThem = ?', null, null, '1', [(int) $ba_bec_article['numThem']])[0] ?? [])
            : [];
        $ba_bec_keywordsList = [];
        $ba_bec_keywords = $ba_bec_numArt ? sql_select('MOTCLEARTICLE', '*', 'numArt = ?', null, null, null, [$ba_bec_numArt]) : [];
        foreach ($ba_bec_keywords as $ba_bec_keyword) {
            $ba_bec_info = sql_select('MOTCLE', '*', 'numMotCle = ?', null, null, '1', [(int) $ba_bec_keyword['numMotCle']])[0] ?? [];
            if (!empty($ba_bec_info['libMotCle'])) {
                $ba_bec_keywordsList[] = $ba_bec_info['libMotCle'];
            }
        }
        $this->render('views/backend/articles/delete.php', compact('ba_bec_article', 'ba_bec_thematique', 'ba_bec_keywordsList'));
    }

    public function destroy(): void
    {
        require __DIR__ . '/../api/articles/delete.php';
    }
}
