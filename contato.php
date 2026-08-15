<?php
// clientes/Relpps-Cosméticos/site/contato.php
require __DIR__ . '/includes/functions.php';
$titulo = 'Contato — Relpps Cosméticos';
$embedMaps = config('embed_maps');
require __DIR__ . '/includes/header.php';
?>

<h1>Contato</h1>
<ul class="contato-lista">
    <li><strong>Endereço:</strong> <?= htmlspecialchars(config('endereco')) ?></li>
    <li><strong>Horário:</strong> <?= htmlspecialchars(config('horario')) ?></li>
    <li><strong>WhatsApp:</strong>
        <a href="<?= htmlspecialchars(whatsappLink('Olá! Vim pelo site da Relpps Cosméticos.')) ?>" target="_blank" rel="noopener">
            Falar agora
        </a>
    </li>
    <li><strong>Instagram:</strong>
        <a href="<?= htmlspecialchars(config('instagram')) ?>" target="_blank" rel="noopener">@relpps</a>
    </li>
</ul>

<?php if ($embedMaps !== ''): ?>
    <div class="mapa"><?= $embedMaps ?></div>
<?php else: ?>
    <p>
        <a href="<?= htmlspecialchars(config('link_google')) ?>" target="_blank" rel="noopener">
            Ver no Google Maps
        </a>
    </p>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
