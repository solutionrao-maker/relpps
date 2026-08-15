<?php
// clientes/Relpps-Cosméticos/site/produtos.php
require __DIR__ . '/includes/functions.php';

$titulo = 'Catálogo — Relpps Cosméticos';

$categoria = $_GET['categoria'] ?? '';
$busca = trim($_GET['busca'] ?? '');
$somentePromocao = isset($_GET['promocao']);

$condicoes = ['ativo = 1'];
$parametros = [];

if ($categoria !== '' && array_key_exists($categoria, categorias())) {
    $condicoes[] = 'categoria = :categoria';
    $parametros['categoria'] = $categoria;
}
if ($busca !== '') {
    $condicoes[] = 'nome LIKE :busca';
    $parametros['busca'] = '%' . $busca . '%';
}
if ($somentePromocao) {
    $condicoes[] = 'em_promocao = 1';
}

$sql = 'SELECT * FROM produtos WHERE ' . implode(' AND ', $condicoes) . ' ORDER BY criado_em DESC';
$stmt = db()->prepare($sql);
$stmt->execute($parametros);
$produtos = $stmt->fetchAll();

require __DIR__ . '/includes/header.php';
?>

<h1><?= $somentePromocao ? 'Promoções' : 'Catálogo' ?></h1>

<form class="filtros" method="get">
    <input type="text" name="busca" placeholder="Buscar produto" value="<?= htmlspecialchars($busca) ?>">
    <select name="categoria">
        <option value="">Todas as categorias</option>
        <?php foreach (categorias() as $slug => $nome): ?>
            <option value="<?= htmlspecialchars($slug) ?>" <?= $categoria === $slug ? 'selected' : '' ?>>
                <?= htmlspecialchars($nome) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filtrar</button>
</form>

<div class="produto-grid">
    <?php if (!$produtos): ?>
        <p>Nenhum produto encontrado.</p>
    <?php endif; ?>
    <?php foreach ($produtos as $produto) echo renderProdutoCard($produto); ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
