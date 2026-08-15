<?php
// clientes/Relpps-Cosméticos/site/includes/header.php
// Espera que $titulo esteja definido antes do include.
require_once __DIR__ . '/functions.php';
$titulo = $titulo ?? 'Relpps Cosméticos';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($titulo) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topo">
    <a href="index.php" class="marca">
        <img src="assets/img/logo.png" alt="Relpps Cosméticos" height="48">
    </a>
    <div class="topo-acoes">
        <nav class="menu" id="menuPrincipal">
            <a href="index.php">Início</a>
            <a href="produtos.php">Catálogo</a>
            <a href="produtos.php?promocao=1">Promoções</a>
            <a href="blog.php">Blog</a>
            <a href="sobre.php">Sobre</a>
            <a href="contato.php">Contato</a>
        </nav>
        <a class="instagram-link" href="<?= htmlspecialchars(config('instagram')) ?>" target="_blank" rel="noopener" aria-label="Instagram da Relpps">
            <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"></circle></svg>
        </a>
        <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu" aria-expanded="false" aria-controls="menuPrincipal">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
<script>
(function () {
    var botao = document.getElementById('menuToggle');
    var menu = document.getElementById('menuPrincipal');
    if (!botao || !menu) return;
    botao.addEventListener('click', function () {
        var aberto = menu.classList.toggle('aberto');
        botao.classList.toggle('aberto', aberto);
        botao.setAttribute('aria-expanded', aberto ? 'true' : 'false');
    });
    menu.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            menu.classList.remove('aberto');
            botao.classList.remove('aberto');
            botao.setAttribute('aria-expanded', 'false');
        });
    });
})();
</script>
<main>
