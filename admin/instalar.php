<?php
// clientes/Relpps-Cosméticos/site/admin/instalar.php
require_once __DIR__ . '/../includes/auth.php';

$jaExiste = (int) db()->query('SELECT COUNT(*) AS total FROM admin_usuarios')->fetch()['total'] > 0;
$erro = '';
$sucesso = false;

if ($jaExiste) {
    http_response_code(403);
    echo 'Já existe um usuário administrador. Essa página está bloqueada.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerificar();
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';
    if ($usuario === '' || strlen($senha) < 8) {
        $erro = 'Informe um usuário e uma senha com pelo menos 8 caracteres.';
    } else {
        $stmt = db()->prepare('INSERT INTO admin_usuarios (usuario, senha_hash) VALUES (:usuario, :hash)');
        $stmt->execute(['usuario' => $usuario, 'hash' => password_hash($senha, PASSWORD_DEFAULT)]);
        $sucesso = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Instalação — Admin Relpps</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<main class="admin-login">
<?php if ($sucesso): ?>
    <p>Usuário administrador criado. <a href="login.php">Ir para o login</a>.</p>
<?php else: ?>
    <h1>Criar primeiro usuário administrador</h1>
    <?php if ($erro): ?><p class="erro"><?= htmlspecialchars($erro) ?></p><?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrfToken()) ?>">
        <label>Usuário <input type="text" name="usuario" required></label>
        <label>Senha (mín. 8 caracteres) <input type="password" name="senha" required></label>
        <button type="submit">Criar</button>
    </form>
<?php endif; ?>
</main>
</body>
</html>
