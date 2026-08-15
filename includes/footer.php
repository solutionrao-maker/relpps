<?php
// clientes/Relpps-Cosméticos/site/includes/footer.php
$enderecoRodape = config('endereco');
$horarioRodape = config('horario');
$instagramRodape = config('instagram');
$whatsappFlutuante = whatsappLink('Olá! Vim pelo site da Relpps Cosméticos.');
?>
</main>
<a class="whatsapp-flutuante" href="<?= htmlspecialchars($whatsappFlutuante) ?>" target="_blank" rel="noopener">
    Fale no WhatsApp
</a>
<footer class="rodape">
    <p><?= htmlspecialchars($enderecoRodape) ?></p>
    <p><?= htmlspecialchars($horarioRodape) ?></p>
    <p>
        <a class="instagram-link instagram-link-rodape" href="<?= htmlspecialchars($instagramRodape) ?>" target="_blank" rel="noopener" aria-label="Instagram da Relpps">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"></circle></svg>
        </a>
    </p>
    <p>&copy; <?= date('Y') ?> Relpps Cosméticos</p>
</footer>
<script>
(function () {
    // Revelação progressiva ao rolar — cada filho direto de <main> (exceto
    // o hero, que já tem sua própria animação presa ao scroll) recebe um
    // fade + leve deslocamento ao entrar na tela, com pequeno escalonamento
    // entre os elementos.
    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var alvos = document.querySelectorAll('main > *:not(script):not(.hero-scrolly)');

    if (prefersReduced || !('IntersectionObserver' in window)) {
        alvos.forEach(function (el) { el.classList.add('visivel'); });
        return;
    }

    var observador = new IntersectionObserver(function (entradas) {
        entradas.forEach(function (entrada) {
            if (entrada.isIntersecting) {
                entrada.target.classList.add('visivel');
                observador.unobserve(entrada.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

    alvos.forEach(function (el, indice) {
        el.classList.add('reveal');
        el.style.transitionDelay = (indice % 4) * 60 + 'ms';
        observador.observe(el);
    });
})();
</script>
</body>
</html>
