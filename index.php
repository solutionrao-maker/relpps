<?php
// clientes/Relpps-Cosméticos/site/index.php
require __DIR__ . '/includes/functions.php';

$titulo = 'Relpps Cosméticos — Produtos para Unhas, Cílios e Sobrancelhas';

$promocoes = db()->query(
    "SELECT * FROM produtos WHERE ativo = 1 AND em_promocao = 1 ORDER BY criado_em DESC LIMIT 4"
)->fetchAll();

$destaques = db()->query(
    "SELECT * FROM produtos WHERE ativo = 1 ORDER BY criado_em DESC LIMIT 8"
)->fetchAll();

$whatsHero = whatsappLink('Olá! Vim pelo site da Relpps Cosméticos.');

$heroFrameArquivos = glob(__DIR__ . '/assets/img/hero/frame-*.jpg');
sort($heroFrameArquivos);
// A partir do quadro ~178 ela abaixa o rosto de novo pra olhar as unhas.
// Paramos a animação um pouco antes disso, com o rosto sempre erguido.
$heroFrameArquivos = array_slice($heroFrameArquivos, 0, 177);
$heroQuadros = count($heroFrameArquivos);
$heroPrimeiroFrame = $heroFrameArquivos ? 'assets/img/hero/' . basename($heroFrameArquivos[0]) : '';

// Monta uma palavra como spans por letra, cada um com um pequeno atraso de
// transição — dá o efeito de "letras entrando" quando a classe .visivel é
// ligada via JS (ver script do hero mais abaixo).
function heroPalavraAnimada(string $texto): string {
    $html = '';
    $indice = 0;
    foreach (preg_split('//u', $texto, -1, PREG_SPLIT_NO_EMPTY) as $letra) {
        $atraso = $indice * 35;
        $conteudo = $letra === ' ' ? '&nbsp;' : htmlspecialchars($letra);
        $html .= '<span style="transition-delay:' . $atraso . 'ms">' . $conteudo . '</span>';
        $indice++;
    }
    return $html;
}

require __DIR__ . '/includes/header.php';
?>

<section class="hero-scrolly" id="hero">
    <div class="hero-scrolly-stage" id="heroStage">
        <img class="hero-scrolly-frame" id="heroFrame" src="<?= htmlspecialchars($heroPrimeiroFrame) ?>" alt="Cuidado profissional com beleza — Relpps Cosméticos">
        <div class="hero-scrolly-overlay" aria-hidden="true"></div>

        <div class="hero-scrolly-conteudo" id="heroConteudo">
            <span class="eyebrow">Relpps Cosméticos</span>
            <h1>Onde beleza encontra cuidado.</h1>
            <p>Insumos com procedência garantida para unhas, cílios e sobrancelhas.</p>
            <div class="botoes">
                <a class="botao" href="produtos.php">Ver catálogo</a>
                <a class="botao-secundario" href="<?= htmlspecialchars($whatsHero) ?>" target="_blank" rel="noopener">Falar no WhatsApp</a>
            </div>
        </div>

        <div class="hero-categorias" id="heroCategorias" aria-hidden="true">
            <span class="hero-categoria-palavra" data-inicio="0.14" data-fim="0.38"><?= heroPalavraAnimada('Unhas') ?></span>
            <span class="hero-categoria-palavra" data-inicio="0.42" data-fim="0.66"><?= heroPalavraAnimada('Cílios') ?></span>
            <span class="hero-categoria-palavra" data-inicio="0.70" data-fim="0.94"><?= heroPalavraAnimada('Sobrancelhas') ?></span>
        </div>

        <div class="hero-scroll-indicador" id="heroScrollIndicador" aria-hidden="true">
            <span>Role</span>
            <span class="linha"></span>
        </div>
    </div>
</section>

<script>
(function () {
    var secao = document.getElementById('hero');
    var frameEl = document.getElementById('heroFrame');
    var conteudo = document.getElementById('heroConteudo');
    var indicador = document.getElementById('heroScrollIndicador');
    var palavras = document.querySelectorAll('.hero-categoria-palavra');
    if (!secao || !frameEl) return;

    var TOTAL_QUADROS = <?= (int) $heroQuadros ?>;
    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) return; // fica só no primeiro quadro, sem animação presa ao scroll

    function caminhoQuadro(indice) {
        var numero = String(indice + 1).padStart(3, '0');
        return 'assets/img/hero/frame-' + numero + '.jpg';
    }

    for (var i = 0; i < TOTAL_QUADROS; i++) {
        var img = new Image();
        img.src = caminhoQuadro(i);
    }

    var SUAVIZACAO = 0.08;
    var progressoAlvo = 0;
    var progressoAtual = 0;
    var ultimoIndice = 0;

    function calcularProgressoAlvo() {
        var rect = secao.getBoundingClientRect();
        var distanciaRolavel = rect.height - window.innerHeight;
        if (distanciaRolavel <= 0) return 0;
        return Math.min(Math.max(-rect.top / distanciaRolavel, 0), 1);
    }

    function faixaOpacidade(p, saidaIni, saidaFim) {
        return 1 - Math.min(Math.max((p - saidaIni) / (saidaFim - saidaIni), 0), 1);
    }

    function renderizar(p) {
        var indice = Math.round(p * (TOTAL_QUADROS - 1));
        if (indice !== ultimoIndice) {
            frameEl.src = caminhoQuadro(indice);
            ultimoIndice = indice;
        }
        var opacidade = faixaOpacidade(p, 0.86, 0.98);
        if (conteudo) {
            conteudo.style.opacity = opacidade;
            conteudo.style.transform = 'translateY(' + ((1 - opacidade) * -16) + 'px)';
        }
        if (indicador) indicador.style.opacity = Math.max(0, 0.8 - p * 6);

        for (var w = 0; w < palavras.length; w++) {
            var el = palavras[w];
            var dentro = p >= parseFloat(el.dataset.inicio) && p <= parseFloat(el.dataset.fim);
            el.classList.toggle('visivel', dentro);
        }
    }

    function loop() {
        progressoAlvo = calcularProgressoAlvo();
        var diferenca = progressoAlvo - progressoAtual;
        progressoAtual += Math.abs(diferenca) < 0.0005 ? diferenca : diferenca * SUAVIZACAO;
        renderizar(progressoAtual);
        requestAnimationFrame(loop);
    }
    requestAnimationFrame(loop);
})();
</script>

<section class="frase-impacto" id="fraseImpacto">
    <p>Relpps: qualidade, cuidado e confiança em produtos pensados para o seu bem-estar.</p>
</section>

<script>
(function () {
    var alvo = document.getElementById('fraseImpacto');
    if (!alvo || !('IntersectionObserver' in window)) { if (alvo) alvo.classList.add('visivel'); return; }
    var observador = new IntersectionObserver(function (entradas) {
        entradas.forEach(function (entrada) {
            if (entrada.isIntersecting) {
                alvo.classList.add('visivel');
                observador.unobserve(alvo);
            }
        });
    }, { threshold: 0.4 });
    observador.observe(alvo);
})();
</script>

<section class="pilares">
    <div class="pilar">
        <div class="icone" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10" r="7"></circle><path d="M9 10l2 2 4-4"></path><path d="M9 16.5L7.5 21 12 18.5 16.5 21 15 16.5"></path></svg>
        </div>
        <strong>Produtos originais</strong>
    </div>
    <div class="pilar">
        <div class="icone" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="10.5" cy="10.5" r="6.5"></circle><path d="M20 20l-5-5"></path></svg>
        </div>
        <strong>Curadoria criteriosa</strong>
    </div>
    <div class="pilar">
        <div class="icone" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l9-4.5L21 8v9l-9 4.5L3 17V8z"></path><path d="M3 8l9 4.5L21 8"></path><path d="M12 12.5V21"></path></svg>
        </div>
        <strong>Estoque garantido</strong>
    </div>
</section>

<?php if ($promocoes): ?>
<section>
    <h2>Promoção da semana</h2>
    <div class="produto-grid">
        <?php foreach ($promocoes as $produto) echo renderProdutoCard($produto); ?>
    </div>
</section>
<?php endif; ?>

<section>
    <h2>Categorias</h2>
    <div class="categorias-grid">
        <?php foreach (categorias() as $slug => $nome): ?>
            <a class="categoria-card" href="produtos.php?categoria=<?= urlencode($slug) ?>" style="background-image: url('assets/img/categorias/<?= urlencode($slug) ?>.jpg')">
                <h3><?= htmlspecialchars($nome) ?></h3>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section>
    <h2>Produtos recentes</h2>
    <div class="produto-grid">
        <?php foreach ($destaques as $produto) echo renderProdutoCard($produto); ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
