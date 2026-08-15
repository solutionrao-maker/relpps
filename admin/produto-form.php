<?php
// clientes/Relpps-Cosméticos/site/admin/produto-form.php
require_once __DIR__ . '/../includes/auth.php';
exigirLogin();
require_once __DIR__ . '/../includes/functions.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);
$produto = ['nome' => '', 'descricao' => '', 'categoria' => 'unhas', 'preco' => '', 'em_promocao' => 0, 'ativo' => 1, 'foto' => null];
if ($id) {
    $stmt = db()->prepare('SELECT * FROM produtos WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $encontrado = $stmt->fetch();
    if ($encontrado) $produto = $encontrado;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerificar();
    $produto['nome'] = trim($_POST['nome'] ?? '');
    $produto['descricao'] = trim($_POST['descricao'] ?? '');
    $produto['categoria'] = $_POST['categoria'] ?? 'unhas';
    $produto['preco'] = $_POST['preco'] !== '' ? (float) $_POST['preco'] : null;
    $produto['em_promocao'] = isset($_POST['em_promocao']) ? 1 : 0;
    $produto['ativo'] = isset($_POST['ativo']) ? 1 : 0;

    if ($produto['nome'] === '' || !array_key_exists($produto['categoria'], categorias())) {
        $erro = 'Preencha o nome e escolha uma categoria válida.';
    } else {
        // Só gera slug novo na criação. Em edição, mantém o slug existente (não muda a URL
        // pública ao renomear) — a menos que o registro nunca tenha tido um slug.
        $slug = (!$id || empty($produto['slug'])) ? slugify($produto['nome']) : $produto['slug'];

        if (!empty($_FILES['foto']['name'])) {
            $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if (!in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $erro = 'Formato de imagem inválido. Use JPG, PNG ou WEBP.';
            } else {
                $nomeArquivo = $slug . '-' . time() . '.' . $extensao;
                $destino = __DIR__ . '/../uploads/produtos/' . $nomeArquivo;
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                    $erro = 'Erro ao salvar a imagem. Verifique as permissões de upload.';
                } else {
                    $produto['foto'] = 'uploads/produtos/' . $nomeArquivo;
                }
            }
        }

        if ($erro === '') {
            try {
                if ($id) {
                    $stmt = db()->prepare(
                        'UPDATE produtos SET nome=:nome, slug=:slug, descricao=:descricao, categoria=:categoria,
                         preco=:preco, em_promocao=:em_promocao, ativo=:ativo, foto=COALESCE(:foto, foto) WHERE id=:id'
                    );
                    $stmt->execute([
                        'nome' => $produto['nome'], 'slug' => $slug, 'descricao' => $produto['descricao'],
                        'categoria' => $produto['categoria'], 'preco' => $produto['preco'],
                        'em_promocao' => $produto['em_promocao'], 'ativo' => $produto['ativo'],
                        'foto' => $produto['foto'], 'id' => $id,
                    ]);
                } else {
                    $stmt = db()->prepare(
                        'INSERT INTO produtos (nome, slug, descricao, categoria, preco, em_promocao, ativo, foto)
                         VALUES (:nome, :slug, :descricao, :categoria, :preco, :em_promocao, :ativo, :foto)'
                    );
                    $stmt->execute([
                        'nome' => $produto['nome'], 'slug' => $slug, 'descricao' => $produto['descricao'],
                        'categoria' => $produto['categoria'], 'preco' => $produto['preco'],
                        'em_promocao' => $produto['em_promocao'], 'ativo' => $produto['ativo'],
                        'foto' => $produto['foto'],
                    ]);
                }
                header('Location: produtos.php');
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {
                    $erro = 'Já existe um produto com esse nome/slug.';
                } else {
                    throw $e;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Produto — Admin Relpps</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<nav class="admin-nav">
    <a href="index.php">Painel</a>
    <a href="produtos.php">Produtos</a>
    <a href="blog.php">Blog</a>
    <a href="configuracoes.php">Configurações</a>
    <a href="logout.php">Sair</a>
</nav>
<main>
    <h1><?= $id ? 'Editar produto' : 'Novo produto' ?></h1>
    <?php if ($erro): ?><p class="erro"><?= htmlspecialchars($erro) ?></p><?php endif; ?>
    <form class="admin-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrfToken()) ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Nome <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required></label>
        <label>Descrição <textarea name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea></label>
        <label>Categoria
            <select name="categoria">
                <?php foreach (categorias() as $slug => $nome): ?>
                    <option value="<?= $slug ?>" <?= $produto['categoria'] === $slug ? 'selected' : '' ?>><?= $nome ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Preço (opcional) <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars((string) $produto['preco']) ?>"></label>
        <label><input type="checkbox" name="em_promocao" <?= $produto['em_promocao'] ? 'checked' : '' ?>> Promoção da semana</label>
        <label><input type="checkbox" name="ativo" <?= $produto['ativo'] ? 'checked' : '' ?>> Ativo (visível no site)</label>
        <label>Foto <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp"></label>
        <button type="submit">Salvar</button>
    </form>
</main>
</body>
</html>
