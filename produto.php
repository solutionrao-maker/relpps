<?php
// clientes/Relpps-Cosméticos/site/produto.php
require __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$stmt = db()->prepare('SELECT * FROM produtos WHERE slug = :slug AND ativo = 1');
$stmt->execute(['slug' => $slug]);
$produto = $stmt->fetch();

if (!$produto) {
    http_response_code(404);
    $titulo = 'Produto não encontrado — Relpps Cosméticos';
    require __DIR__ . '/includes/header.php';
    echo '<p>Produto não encontrado.</p>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$titulo = $produto['nome'] . ' — Relpps Cosméticos';
$linkWhats = whatsappLink('Olá! Tenho interesse no produto: ' . $produto['nome']);

require __DIR__ . '/includes/header.php';
?>

<article class="produto-detalhe">
    <img src="<?= htmlspecialchars($produto['foto'] ?: 'assets/img/sem-foto.png') ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
    <div>
        <h1><?= htmlspecialchars($produto['nome']) ?></h1>
        <p class="categoria"><?= htmlspecialchars(categorias()[$produto['categoria']] ?? '') ?></p>
        <?php if ($produto['preco'] !== null): ?>
            <p class="preco">R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></p>
        <?php endif; ?>
        <p><?= nl2br(htmlspecialchars($produto['descricao'] ?? '')) ?></p>
        <a class="botao" href="<?= htmlspecialchars($linkWhats) ?>" target="_blank" rel="noopener">
            Comprar pelo WhatsApp
        </a>
    </div>
</article>

<?php require __DIR__ . '/includes/footer.php'; ?>
