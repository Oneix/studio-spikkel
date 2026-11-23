<?php $this->assign('title', 'Digitale cadeaubon'); ?>
<article class="wrap product-detail">
    <div class="back-link"><?= $this->Html->link('← Alle cadeaus', ['_name' => 'cadeaus']) ?></div>
    <?= $this->Html->image($giftCard->image, ['class' => 'product-image', 'alt' => $giftCard->image_alt, 'width' => 960, 'height' => 960, 'fetchpriority' => 'high']) ?>
    <div class="product-detail-copy">
        <h1>Digitale cadeaubon</h1>
        <p>Laat iemand zelf iets leuks uitzoeken. Kies een bedrag. Na het bestellen vind je een demo-code bij Mijn bestellingen.</p>
        <div class="basket-feedback" aria-live="polite"><?= $this->Flash->render('cart') ?></div>
        <div class="gift-amounts" aria-label="Kies een bedrag">
            <?php foreach ($variants as $variant) : ?>
                <?php $amount = \Cake\I18n\Number::currency($variant->price_cents / 100, 'EUR'); ?>
                <?= $this->Form->create(null, ['url' => ['_name' => 'mandje-toevoegen', 'id' => $variant->id]]) ?>
                <?= $this->Form->hidden('quantity', ['value' => 1]) ?>
                <?= $this->Form->button($amount . ' in mijn mandje', ['class' => 'button button-outline']) ?>
                <?= $this->Form->end() ?>
            <?php endforeach; ?>
        </div>
        <p class="form-notice">Dit is een demo-cadeaubon zonder echt tegoed. Er zijn geen verzendkosten voor een digitale bon.</p>
    </div>
</article>
