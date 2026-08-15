<?php
// clientes/Relpps-Cosméticos/site/admin/index.php
require_once __DIR__ . '/../includes/auth.php';
exigirLogin();
require_once __DIR__ . '/../includes/functions.php';

$totalProdutos = (int) db()->query('SELECT COUNT(*) AS t FROM produtos')->fetch()['t'];
$totalPosts = (int) db()->query('SELECT COUNT(*) AS t FROM blog_posts')->fetch()['t'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Painel — Relpps</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<nav class="admin-nav">
    <a href="index.php">Painel</a>
    <a href="produtos.php">Produtos</a>
    <a href="blog.php">Blog</a>
    <a href="configuracoes.php">Configurações</a>
    <a href="logout.php">Sair</a>
</nav>
<main>
    <h1>Painel administrativo</h1>
    <p><?= $totalProdutos ?> produtos cadastrados.</p>
    <p><?= $totalPosts ?> artigos de blog publicados.</p>
</main>
</body>
</html>
