<?php if ($code === 404) : ?>
    <?= $this->element('page_intro', [
        'title' => 'Pagina niet gevonden',
        'intro' => 'Deze pagina is verplaatst of bestaat niet meer.',
        'link' => 'Terug naar home',
        'route' => 'home',
    ]) ?>
<?php else : ?>
    <?= $this->element('page_intro', [
        'title' => 'Deze pagina is niet beschikbaar',
        'intro' => 'Ga terug naar home om verder te kijken.',
        'link' => 'Terug naar home',
        'route' => 'home',
    ]) ?>
<?php endif; ?>
