<?php
$currentPage = $this->getRequest()->getParam('shopPage');
$navigation = [
    'home' => 'Home',
    'over' => 'Over Studio Spikkel',
    'cadeaus' => 'Cadeaus',
    'nieuws' => 'Nieuws',
    'team' => 'Team',
    'contact' => 'Contact',
];
$pageTitle = $this->fetch('title');
$cartCount = array_sum($this->getRequest()->getSession()->read(\App\Store\Cart::SESSION_KEY, []));
$cartLink = ['class' => 'cart-link'];
if ($currentPage === 'winkelmand') {
    $cartLink['aria-current'] = 'page';
}
if ($cartCount > 0) {
    $cartLink['aria-label'] = 'Mandje, ' . $cartCount . ' stuks';
    $cartLink['data-count'] = $cartCount > 99 ? '99+' : (string)$cartCount;
}
?>
<!doctype html>
<html lang="nl">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#faf6ef">
    <meta name="description" content="Studio Spikkel is een kleine cadeauwinkel met originele, handgemaakte en duurzame cadeaus.">
    <title><?= $pageTitle !== '' ? h($pageTitle) . ' · ' : '' ?>Studio Spikkel</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= h($this->Url->image('spikkel-favicon.png')) ?>">
    <?= $this->Html->css('studio-spikkel') ?>
    <?= $this->Html->script('navigation', ['defer' => true]) ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <a class="skip-link" href="#inhoud">Naar de inhoud</a>
    <header class="site-header">
        <div class="wrap header-inner">
            <a class="brand" href="<?= h($this->Url->build(['_name' => 'home'])) ?>" aria-label="Studio Spikkel, home">
                <?= $this->Html->image('spikkel-mark.png', ['alt' => '', 'width' => 46, 'height' => 46]) ?>
                <span>studio<span class="brand-name">spikkel</span></span>
            </a>
            <button class="menu-button" type="button" aria-controls="hoofdmenu" aria-expanded="false" hidden>Menu</button>
            <nav class="site-nav" id="hoofdmenu" aria-label="Hoofdmenu">
                <?php foreach ($navigation as $route => $label): ?>
                    <?= $this->Html->link($label, ['_name' => $route], $route === $currentPage ? ['aria-current' => 'page'] : []) ?>
                <?php endforeach; ?>
            </nav>
            <nav class="shop-nav" aria-label="Winkel en account">
                <?= $this->Html->link('Account', ['_name' => 'account'], $currentPage === 'account' ? ['aria-current' => 'page'] : []) ?>
                <?= $this->Html->link('Mandje', ['_name' => 'winkelmand'], $cartLink) ?>
            </nav>
        </div>
    </header>

    <?php if (!empty($holiday['active'])) : ?>
        <?= $this->element('holiday_notice', compact('holiday')) ?>
    <?php endif; ?>

    <main id="inhoud" tabindex="-1">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <footer class="site-footer">
        <div class="wrap footer-inner">
            <section aria-label="Studio Spikkel">
                <p class="footer-name">Studio Spikkel</p>
                <p>Originele cadeaus voor de kleine momenten.</p>
            </section>
            <nav aria-label="Hulp en contact">
                <?= $this->Html->link('Veelgestelde vragen', ['_name' => 'vragen'], $currentPage === 'vragen' ? ['aria-current' => 'page'] : []) ?>
                <?= $this->Html->link('Contact', ['_name' => 'contact'], $currentPage === 'contact' ? ['aria-current' => 'page'] : []) ?>
                <?= $this->Html->link('Samenwerken', ['_name' => 'samenwerken'], $currentPage === 'samenwerken' ? ['aria-current' => 'page'] : []) ?>
            </nav>
            <nav aria-label="Sociale media">
                <a href="https://www.instagram.com/mkbmarketingteam/">Instagram</a>
                <a href="https://www.facebook.com/MKBMarketingTeam">Facebook</a>
            </nav>
        </div>
    </footer>
</body>
</html>
