<?= $this->element('admin_heading', ['title' => 'Winkelbeheer']) ?>
<div class="admin-dashboard">
    <?php foreach ([
        ['beheer-producten', 'Producten', 'Pas teksten en prijzen aan of haal een cadeau tijdelijk uit de winkel.'],
        ['beheer-nieuws', 'Nieuws', 'Bewerk berichten, bewaar een concept of plan de publicatie.'],
        ['beheer-bestellingen', 'Demo-bestellingen', 'Bekijk geplaatste orders en de gegevens van het bestelmoment.'],
        ['beheer-contact', 'Contactberichten', 'Lees de vragen uit het contactformulier.'],
        ['beheer-samenwerking', 'Samenwerking', 'Bekijk de voorstellen van makers en download hun bijlagen.'],
    ] as [$route, $label, $description]) : ?>
        <a class="admin-tile" href="<?= h($this->Url->build(['_name' => $route])) ?>">
            <h2><?= h($label) ?></h2>
            <p><?= h($description) ?></p>
        </a>
    <?php endforeach; ?>
</div>
