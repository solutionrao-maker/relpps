<?php
// clientes/Relpps-Cosméticos/site/admin/login.php
require_once __DIR__ . '/../includes/auth.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerificar();
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $stmt = db()->prepare('SELECT * FROM admin_usuarios WHERE usuario = :usuario');
    $stmt->execute(['usuario' => $usuario]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($senha, $admin['senha_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: index.php');
        exit;
    }
    $erro = 'Usuário ou senha inválidos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Login — Admin Relpps</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<main class="admin-login">
<h1>Login</h1>
<?php if ($erro): ?><p class="erro"><?= htmlspecialchars($erro) ?></p><?php endif; ?>
<form method="post">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrfToken()) ?>">
    <label>Usuário <input type="text" name="usuario" required></label>
    <label>Senha <input type="password" name="senha" required></label>
    <button type="submit">Entrar</button>
</form>
</main>
</body>
</html>
