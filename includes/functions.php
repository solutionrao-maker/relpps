<?php
// clientes/Relpps-Cosméticos/site/includes/functions.php
require_once __DIR__ . '/db.php';

function categorias(): array {
    return [
        'unhas' => 'Unhas',
        'cilios' => 'Cílios',
        'sobrancelhas' => 'Sobrancelhas',
    ];
}

function config(string $chave, string $padrao = ''): string {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        foreach (db()->query('SELECT chave, valor FROM configuracoes') as $linha) {
            $cache[$linha['chave']] = $linha['valor'];
        }
    }
    return $cache[$chave] ?? $padrao;
}

function slugify(string $texto): string {
    $texto = mb_strtolower(trim($texto), 'UTF-8');
    $transliterado = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
    $texto = $transliterado !== false ? $transliterado : $texto;
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    return trim($texto, '-');
}

function whatsappLink(string $mensagem): string {
    $numero = config('whatsapp', WHATSAPP_NUMERO);
    return 'https://wa.me/' . $numero . '?text=' . rawurlencode($mensagem);
}

function renderProdutoCard(array $produto): string {
    $nome = htmlspecialchars($produto['nome']);
    $foto = htmlspecialchars($produto['foto'] ?: 'assets/img/sem-foto.png');
    $link = 'produto.php?slug=' . urlencode($produto['slug']);
    $selo = $produto['em_promocao'] ? '<span class="selo-promocao">Promoção</span>' : '';
    $preco = $produto['preco'] !== null
        ? '<p class="preco">R$ ' . number_format((float) $produto['preco'], 2, ',', '.') . '</p>'
        : '';
    return <<<HTML
    <a class="produto-card" href="{$link}">
        {$selo}
        <img src="{$foto}" alt="{$nome}" loading="lazy">
        <h3>{$nome}</h3>
        {$preco}
    </a>
    HTML;
}
