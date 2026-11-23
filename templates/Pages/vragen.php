<?php
$this->assign('title', 'Veelgestelde vragen');
$questions = [
    'levertijden' => 'Wat zijn de levertijden?',
    'retourneren' => 'Kan ik mijn bestelling retourneren?',
    'contact-opnemen' => 'Hoe kan ik contact opnemen?',
    'cadeaubonnen' => 'Verkopen jullie ook cadeaubonnen?',
    'cadeau-inpakken' => 'Kan ik mijn bestelling als cadeau laten inpakken?',
    'samenwerken' => 'Ik wil samenwerken, kan dat?',
];
?>
<section class="inner-hero">
    <div class="wrap"><h1>Veelgestelde vragen</h1></div>
</section>
<div class="wrap faq-layout">
    <nav class="faq-nav" aria-label="Spring naar een vraag">
        <ul role="list">
            <?php foreach ($questions as $id => $question) : ?>
                <li><a href="#<?= h($id) ?>"><?= h($question) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div class="faq-answers">
        <section id="levertijden" tabindex="-1" aria-labelledby="vraag-levertijden">
            <h2 id="vraag-levertijden"><?= h($questions['levertijden']) ?></h2>
            <p>De winkel verstuurt pakketten normaal binnen 1–2 werkdagen. Zodra je pakket onderweg is, krijg je bericht. Binnen Nederland is het meestal de volgende dag in huis. Demo-bestellingen worden niet verstuurd.</p>
            <div class="shipping-scroll" tabindex="0" role="region" aria-label="Verzendtabel">
                <table class="shipping-table">
                    <caption>Levertijden en verzendkosten</caption>
                    <thead><tr><th scope="col">Bestemming</th><th scope="col">Levertijd</th><th scope="col">Kosten</th><th scope="col">Gratis vanaf</th></tr></thead>
                    <tbody>
                        <?php foreach ($store['shipping'] as $rate) : ?>
                            <tr>
                                <th scope="row"><?= h($rate['label']) ?></th>
                                <td><?= h($rate['delivery']) ?></td>
                                <td><?= $rate['fee_cents'] === 0 ? 'Gratis' : h(\Cake\I18n\Number::currency($rate['fee_cents'] / 100, 'EUR')) ?></td>
                                <td><?= $rate['free_from_cents'] === null ? '—' : h(\Cake\I18n\Number::currency($rate['free_from_cents'] / 100, 'EUR')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section id="retourneren" tabindex="-1" aria-labelledby="vraag-retourneren">
            <h2 id="vraag-retourneren"><?= h($questions['retourneren']) ?></h2>
            <p>Dat kan binnen 14 dagen na ontvangst, zolang de producten onbeschadigd en in originele staat zijn. Mail je ordernummer naar <a href="mailto:<?= h($store['email']) ?>"><?= h($store['email']) ?></a>, dan helpen we je verder.</p>
        </section>
        <section id="contact-opnemen" tabindex="-1" aria-labelledby="vraag-contact">
            <h2 id="vraag-contact"><?= h($questions['contact-opnemen']) ?></h2>
            <p>Gebruik het <?= $this->Html->link('contactformulier', ['_name' => 'contact', '#' => 'contactformulier']) ?> of mail naar <a href="mailto:<?= h($store['email']) ?>"><?= h($store['email']) ?></a>. We reageren meestal binnen één werkdag.</p>
        </section>
        <section id="cadeaubonnen" tabindex="-1" aria-labelledby="vraag-cadeaubonnen">
            <h2 id="vraag-cadeaubonnen"><?= h($questions['cadeaubonnen']) ?></h2>
            <p>Ja, kies een <?= $this->Html->link('digitale cadeaubon', ['_name' => 'cadeaubon']) ?> van €10, €25 of €50. Bij je demo-bestelling staat een code zonder echt tegoed.</p>
        </section>
        <section id="cadeau-inpakken" tabindex="-1" aria-labelledby="vraag-inpakken">
            <h2 id="vraag-inpakken"><?= h($questions['cadeau-inpakken']) ?></h2>
            <p>Ja, kies bij het afrekenen voor cadeauverpakking en voeg eventueel een persoonlijk berichtje voor op een kaartje toe.</p>
        </section>
        <section id="samenwerken" tabindex="-1" aria-labelledby="vraag-samenwerken">
            <h2 id="vraag-samenwerken"><?= h($questions['samenwerken']) ?></h2>
            <p>Ja, we werken graag samen met creatieve makers. Vertel ons over jouw product of idee via het <?= $this->Html->link('samenwerkingsformulier', ['_name' => 'samenwerken', '#' => 'aanvraag']) ?>.</p>
        </section>
    </div>
</div>
