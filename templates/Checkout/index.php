<?php
$this->assign('title', 'Afrekenen');
$this->Html->script('checkout', ['block' => true, 'defer' => true]);
$money = static fn(int $cents): string => \Cake\I18n\Number::currency($cents / 100, 'EUR');
?>
<section class="inner-hero"><div class="wrap"><h1>Afrekenen</h1></div></section>
<div class="wrap basket-page">
    <div class="form-feedback" aria-live="polite"><?= $this->Flash->render('checkout') ?></div>
    <?php if ($cart['removed']) : ?>
        <p class="form-summary-error" role="status">Een cadeau is niet meer beschikbaar en is uit je mandje gehaald.</p>
    <?php endif; ?>
    <div class="basket-grid">
        <section class="form-card" aria-labelledby="bezorging-kop">
            <h2 id="bezorging-kop">Bezorging</h2>
            <p class="form-notice">Je plaatst een demo-bestelling. Je betaalt niets en er wordt niets verzonden.</p>
            <?php if ($form->getErrors() !== []) : ?>
                <p class="form-summary-error" role="alert">Controleer de gemarkeerde velden.</p>
            <?php endif; ?>
            <?= $this->Form->create($form, [
                'url' => ['_name' => 'afrekenen-overzicht'],
                'data-checkout' => true,
                'valueSources' => ['context'],
            ]) ?>
            <?php if ($cart['hasPhysical']) : ?>
                <fieldset>
                    <legend>Hoe wil je je cadeaus ontvangen?</legend>
                    <?= $this->Form->control('delivery_method', [
                        'type' => 'radio', 'label' => false,
                        'options' => ['shipping' => 'Verzenden', 'pickup' => 'Afhalen in de winkel'], 'required' => true,
                    ]) ?>
                </fieldset>
                <fieldset data-shipping-address>
                    <legend>Verzendadres</legend>
                    <?= $this->Form->control('address_name', ['label' => 'Naam ontvanger', 'maxlength' => 120, 'autocomplete' => 'name']) ?>
                    <?= $this->Form->control('street', ['label' => 'Straat en huisnummer', 'maxlength' => 160, 'autocomplete' => 'street-address']) ?>
                    <div class="form-grid">
                        <?= $this->Form->control('postal_code', ['label' => 'Postcode', 'maxlength' => 12, 'autocomplete' => 'postal-code']) ?>
                        <?= $this->Form->control('city', ['label' => 'Plaats', 'maxlength' => 100, 'autocomplete' => 'address-level2']) ?>
                    </div>
                    <?= $this->Form->control('shipping_country', ['type' => 'select', 'label' => 'Land', 'options' => $countries, 'empty' => 'Kies een land', 'autocomplete' => 'country']) ?>
                </fieldset>
                <fieldset>
                    <legend>Cadeauverpakking</legend>
                    <?= $this->Form->control('gift_wrap', ['label' => 'Als cadeau inpakken', 'type' => 'checkbox']) ?>
                    <div data-gift-message>
                        <?= $this->Form->control('gift_message', ['label' => 'Bericht voor op het kaartje (optioneel)', 'type' => 'textarea', 'rows' => 3, 'maxlength' => 240]) ?>
                    </div>
                </fieldset>
            <?php else : ?>
                <p class="digital-delivery">Je vindt de demo-code straks bij Mijn bestellingen. Je hoeft geen verzendadres op te geven.</p>
            <?php endif; ?>
            <?= $this->Form->button('Bekijk bestelling', ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </section>
        <aside class="basket-total checkout-side" aria-labelledby="mandje-kop">
            <h2 id="mandje-kop">Jouw cadeaus</h2>
            <ul class="checkout-items" role="list">
                <?php foreach ($cart['items'] as $item) : ?>
                    <li><span><?= h($item['quantity']) ?> × <?= h($item['product']->name) ?></span><strong><?= h($money($item['total'])) ?></strong></li>
                <?php endforeach; ?>
            </ul>
            <p class="checkout-subtotal"><strong>Subtotaal</strong><span class="price"><?= h($money($cart['subtotal'])) ?></span></p>
            <?= $this->Html->link('Mandje aanpassen', ['_name' => 'winkelmand'], ['class' => 'text-link']) ?>
        </aside>
    </div>
</div>
