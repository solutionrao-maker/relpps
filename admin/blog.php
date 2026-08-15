<?php
// clientes/Relpps-Cosméticos/site/admin/blog.php
require_once __DIR__ . '/../includes/auth.php';
exigirLogin();
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    csrfVerificar();
    $stmt = db()->prepare('DELETE FROM blog_posts WHERE id = :id');
    $stmt->execute(['id' => (int) $_POST['excluir_id']]);
    header('Location: blog.php');
    exit;
}

$posts = db()->query('SELECT * FROM blog_posts ORDER BY publicado_em DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Blog — Admin Relpps</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<nav class="admin-nav">
    <a href="index.php">Painel</a>
    <a href="produtos.php">Produtos</a>
    <a href="blog.php">Blog</a>
    <a href="configuracoes.php">Configurações</a>
    <a href="logout.php">Sair</a>
</nav>
<main>
    <h1>Blog</h1>
    <p><a href="post-form.php">+ Novo artigo</a></p>
    <table>
        <tr><th>Título</th><th>Publicado em</th><th>Ações</th></tr>
        <?php foreach ($posts as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['titulo']) ?></td>
            <td><?= (new DateTime($p['publicado_em']))->format('d/m/Y') ?></td>
            <td>
                <a href="post-form.php?id=<?= $p['id'] ?>">Editar</a>
                <form method="post" style="display:inline" onsubmit="return confirm('Excluir este artigo?');">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrfToken()) ?>">
                    <input type="hidden" name="excluir_id" value="<?= $p['id'] ?>">
                    <button type="submit">Excluir</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</main>
</body>
</html>
