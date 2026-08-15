<?php
// clientes/Relpps-Cosméticos/site/admin/produtos.php
require_once __DIR__ . '/../includes/auth.php';
exigirLogin();
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    csrfVerificar();
    $stmt = db()->prepare('DELETE FROM produtos WHERE id = :id');
    $stmt->execute(['id' => (int) $_POST['excluir_id']]);
    header('Location: produtos.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alternar_id'])) {
    csrfVerificar();
    $stmt = db()->prepare('UPDATE produtos SET ativo = NOT ativo WHERE id = :id');
    $stmt->execute(['id' => (int) $_POST['alternar_id']]);
    header('Location: produtos.php');
    exit;
}

$produtos = db()->query('SELECT * FROM produtos ORDER BY criado_em DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Produtos — Admin Relpps</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<nav class="admin-nav">
    <a href="index.php">Painel</a>
    <a href="produtos.php">Produtos</a>
    <a href="blog.php">Blog</a>
    <a href="configuracoes.php">Configurações</a>
    <a href="logout.php">Sair</a>
</nav>
<main>
    <h1>Produtos</h1>
    <p><a href="produto-form.php">+ Novo produto</a></p>
    <table>
        <tr><th>Nome</th><th>Categoria</th><th>Promoção</th><th>Ativo</th><th>Ações</th></tr>
        <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td><?= htmlspecialchars(categorias()[$p['categoria']] ?? '') ?></td>
            <td><?= $p['em_promocao'] ? 'Sim' : 'Não' ?></td>
            <td><?= $p['ativo'] ? 'Sim' : 'Não' ?></td>
            <td>
                <a href="produto-form.php?id=<?= $p['id'] ?>">Editar</a>
                <form method="post" style="display:inline">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrfToken()) ?>">
                    <input type="hidden" name="alternar_id" value="<?= $p['id'] ?>">
                    <button type="submit"><?= $p['ativo'] ? 'Desativar' : 'Ativar' ?></button>
                </form>
                <form method="post" style="display:inline" onsubmit="return confirm('Excluir este produto?');">
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
