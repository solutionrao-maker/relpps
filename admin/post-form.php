<?php
// clientes/Relpps-Cosméticos/site/admin/post-form.php
require_once __DIR__ . '/../includes/auth.php';
exigirLogin();
require_once __DIR__ . '/../includes/functions.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);
$post = ['titulo' => '', 'resumo' => '', 'conteudo' => ''];
if ($id) {
    $stmt = db()->prepare('SELECT * FROM blog_posts WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $encontrado = $stmt->fetch();
    if ($encontrado) $post = $encontrado;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerificar();
    $post['titulo'] = trim($_POST['titulo'] ?? '');
    $post['resumo'] = trim($_POST['resumo'] ?? '');
    $post['conteudo'] = trim($_POST['conteudo'] ?? '');

    if ($post['titulo'] === '' || $post['conteudo'] === '') {
        $erro = 'Preencha título e conteúdo.';
    } else {
        // Só gera slug novo na criação. Em edição, mantém o slug existente (não muda a URL
        // pública ao renomear) — a menos que o registro nunca tenha tido um slug.
        $slug = (!$id || empty($post['slug'])) ? slugify($post['titulo']) : $post['slug'];
        try {
            if ($id) {
                $stmt = db()->prepare('UPDATE blog_posts SET titulo=:titulo, slug=:slug, resumo=:resumo, conteudo=:conteudo WHERE id=:id');
                $stmt->execute(['titulo' => $post['titulo'], 'slug' => $slug, 'resumo' => $post['resumo'], 'conteudo' => $post['conteudo'], 'id' => $id]);
            } else {
                $stmt = db()->prepare('INSERT INTO blog_posts (titulo, slug, resumo, conteudo) VALUES (:titulo, :slug, :resumo, :conteudo)');
                $stmt->execute(['titulo' => $post['titulo'], 'slug' => $slug, 'resumo' => $post['resumo'], 'conteudo' => $post['conteudo']]);
            }
            header('Location: blog.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $erro = 'Já existe um artigo com esse título/slug.';
            } else {
                throw $e;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Artigo — Admin Relpps</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<nav class="admin-nav">
    <a href="index.php">Painel</a>
    <a href="produtos.php">Produtos</a>
    <a href="blog.php">Blog</a>
    <a href="configuracoes.php">Configurações</a>
    <a href="logout.php">Sair</a>
</nav>
<main>
    <h1><?= $id ? 'Editar artigo' : 'Novo artigo' ?></h1>
    <?php if ($erro): ?><p class="erro"><?= htmlspecialchars($erro) ?></p><?php endif; ?>
    <form class="admin-form" method="post">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrfToken()) ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Título <input type="text" name="titulo" value="<?= htmlspecialchars($post['titulo']) ?>" required></label>
        <label>Resumo <input type="text" name="resumo" value="<?= htmlspecialchars($post['resumo']) ?>"></label>
        <label>Conteúdo <textarea name="conteudo" rows="10" required><?= htmlspecialchars($post['conteudo']) ?></textarea></label>
        <button type="submit">Salvar</button>
    </form>
</main>
</body>
</html>
