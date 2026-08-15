<?php
// clientes/Relpps-Cosméticos/site/admin/configuracoes.php
require_once __DIR__ . '/../includes/auth.php';
exigirLogin();
require_once __DIR__ . '/../includes/functions.php';

$campos = ['endereco', 'horario', 'whatsapp', 'instagram', 'nota_google', 'link_google', 'embed_maps'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerificar();
    $stmt = db()->prepare('INSERT INTO configuracoes (chave, valor) VALUES (:chave, :valor) ON DUPLICATE KEY UPDATE valor = VALUES(valor)');
    foreach ($campos as $campo) {
        $stmt->execute(['chave' => $campo, 'valor' => trim($_POST[$campo] ?? '')]);
    }
    header('Location: configuracoes.php?salvo=1');
    exit;
}

$valores = [];
foreach ($campos as $campo) {
    $valores[$campo] = config($campo);
}
$salvo = isset($_GET['salvo']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Configurações — Admin Relpps</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<nav class="admin-nav">
    <a href="index.php">Painel</a>
    <a href="produtos.php">Produtos</a>
    <a href="blog.php">Blog</a>
    <a href="configuracoes.php">Configurações</a>
    <a href="logout.php">Sair</a>
</nav>
<main>
    <h1>Configurações da loja</h1>
    <?php if ($salvo): ?><p>Salvo com sucesso.</p><?php endif; ?>
    <form class="admin-form" method="post">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrfToken()) ?>">
        <label>Endereço <input type="text" name="endereco" value="<?= htmlspecialchars($valores['endereco']) ?>"></label>
        <label>Horário <input type="text" name="horario" value="<?= htmlspecialchars($valores['horario']) ?>"></label>
        <label>WhatsApp (só números) <input type="text" name="whatsapp" value="<?= htmlspecialchars($valores['whatsapp']) ?>"></label>
        <label>Instagram <input type="text" name="instagram" value="<?= htmlspecialchars($valores['instagram']) ?>"></label>
        <label>Nota do Google <input type="text" name="nota_google" value="<?= htmlspecialchars($valores['nota_google']) ?>"></label>
        <label>Link do perfil no Google <input type="text" name="link_google" value="<?= htmlspecialchars($valores['link_google']) ?>"></label>
        <label>Código de incorporação do Google Maps <textarea name="embed_maps"><?= htmlspecialchars($valores['embed_maps']) ?></textarea></label>
        <button type="submit">Salvar</button>
    </form>
</main>
</body>
</html>
