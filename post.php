<?php
// clientes/Relpps-Cosméticos/site/post.php
require __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$stmt = db()->prepare('SELECT * FROM blog_posts WHERE slug = :slug');
$stmt->execute(['slug' => $slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    $titulo = 'Artigo não encontrado — Relpps Cosméticos';
    require __DIR__ . '/includes/header.php';
    echo '<p>Artigo não encontrado.</p>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$titulo = $post['titulo'] . ' — Blog Relpps Cosméticos';
$linkWhatsPost = whatsappLink('Olá! Vim pelo blog da Relpps Cosméticos.');
require __DIR__ . '/includes/header.php';
?>

<article class="post-detalhe">
    <a class="post-voltar" href="blog.php">← Voltar ao blog</a>
    <h1><?= htmlspecialchars($post['titulo']) ?></h1>
    <p class="data"><?= (new DateTime($post['publicado_em']))->format('d/m/Y') ?></p>
    <div class="conteudo"><?= nl2br(htmlspecialchars($post['conteudo'])) ?></div>

    <div class="post-cta">
        <p>Gostou do conteúdo? Fale com a gente e conheça os produtos certos pro seu trabalho.</p>
        <a class="botao" href="<?= htmlspecialchars($linkWhatsPost) ?>" target="_blank" rel="noopener">Falar no WhatsApp</a>
    </div>
</article>

<?php require __DIR__ . '/includes/footer.php'; ?>
