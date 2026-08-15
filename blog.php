<?php
// clientes/Relpps-Cosméticos/site/blog.php
require __DIR__ . '/includes/functions.php';

$titulo = 'Blog — Relpps Cosméticos';
$posts = db()->query('SELECT * FROM blog_posts ORDER BY publicado_em DESC')->fetchAll();

require __DIR__ . '/includes/header.php';
?>

<h1>Blog</h1>
<p class="blog-intro">Conteúdo pra quem vive de beleza — técnicas, comparativos e dicas de negócio pra profissionais de unhas, cílios e sobrancelhas.</p>

<?php if (!$posts): ?>
    <p>Nenhum artigo publicado ainda.</p>
<?php else: ?>
    <?php $destaque = array_shift($posts); ?>
    <a class="blog-destaque" href="post.php?slug=<?= urlencode($destaque['slug']) ?>">
        <span class="eyebrow">Mais recente</span>
        <h2><?= htmlspecialchars($destaque['titulo']) ?></h2>
        <p><?= htmlspecialchars($destaque['resumo'] ?? '') ?></p>
        <span class="blog-destaque-link">Ler artigo →</span>
    </a>

    <?php if ($posts): ?>
    <div class="blog-lista">
        <?php foreach ($posts as $post): ?>
            <a class="blog-card" href="post.php?slug=<?= urlencode($post['slug']) ?>">
                <h2><?= htmlspecialchars($post['titulo']) ?></h2>
                <p><?= htmlspecialchars($post['resumo'] ?? '') ?></p>
                <span class="data"><?= (new DateTime($post['publicado_em']))->format('d/m/Y') ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
