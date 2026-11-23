<?php
$currentController = $this->getRequest()->getParam('controller');
$sections = [
    'Dashboard' => ['beheer', 'Overzicht'],
    'Products' => ['beheer-producten', 'Producten'],
    'News' => ['beheer-nieuws', 'Nieuws'],
    'Orders' => ['beheer-bestellingen', 'Bestellingen'],
    'ContactMessages' => ['beheer-contact', 'Contact'],
    'Collaborations' => ['beheer-samenwerking', 'Samenwerking'],
];
?>
<!doctype html>
<html lang="nl">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title><?= h($this->fetch('title')) ?> · Studio Spikkel beheer</title>
    <link rel="icon" type="image/png" href="<?= h($this->Url->image('spikkel-favicon.png')) ?>">
    <?= $this->Html->css(['studio-spikkel', 'spikkel-beheer']) ?>
</head>
<body class="admin-body">
    <a class="skip-link" href="#inhoud">Naar de inhoud</a>
    <header class="admin-header">
        <div class="wrap admin-top">
            <a class="brand" href="<?= h($this->Url->build(['_name' => 'beheer'])) ?>">
                <?= $this->Html->image('spikkel-mark.png', ['alt' => '', 'width' => 38, 'height' => 38]) ?>
                <span>Studio Spikkel <span class="brand-name">beheer</span></span>
            </a>
            <div class="admin-session">
                <?= $this->Html->link('Naar de winkel', ['_name' => 'home'], ['class' => 'text-link']) ?>
                <?= $this->Form->create(null, ['url' => ['_name' => 'uitloggen']]) ?>
                <?= $this->Form->button('Uitloggen', ['class' => 'button button-outline']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <nav class="wrap admin-nav" aria-label="Beheermenu">
            <?php foreach ($sections as $controller => [$route, $label]): ?>
                <?= $this->Html->link($label, ['_name' => $route], $currentController === $controller ? ['aria-current' => 'page'] : []) ?>
            <?php endforeach; ?>
        </nav>
    </header>
    <main id="inhoud" class="wrap admin-main" tabindex="-1">
        <div class="form-feedback" aria-live="polite"><?= $this->Flash->render() ?></div>
        <?= $this->fetch('content') ?>
    </main>
</body>
</html>
