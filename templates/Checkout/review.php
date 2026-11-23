<?php
$this->assign('title', 'Controleer je bestelling');
$money = static fn(int $cents): string => \Cake\I18n\Number::currency($cents / 100, 'EUR');
?>
<section class="inner-hero"><div class="wrap"><h1>Controleer je bestelling</h1></div></section>
<div class="wrap basket-page">
    <div class="form-feedback" aria-live="polite"><?= $this->Flash->render('checkout') ?></div>
    <div class="basket-grid">
        <section class="form-card order-main" aria-labelledby="cadeaus-kop">
            <h2 id="cadeaus-kop">Jouw cadeaus</h2>
            <ul class="checkout-items" role="list">
                <?php foreach ($quote['items'] as $item) : ?>
                    <li><span><?= h($item['quantity']) ?> × <?= h($item['name']) ?></span><strong><?= h($money($item['total_cents'])) ?></strong></li>
                <?php endforeach; ?>
            </ul>
            <div class="order-delivery">
                <?= $this->element('order_delivery', ['details' => $quote['order']]) ?>
            </div>
            <?= $this->Html->link('Gegevens wijzigen', ['_name' => 'afrekenen'], ['class' => 'text-link']) ?>
        </section>
        <aside class="basket-total checkout-side" aria-label="Besteltotaal">
            <?= $this->element('order_totals', ['totals' => $quote['order']]) ?>
            <p>Demo-bestelling. Er wordt niets afgeschreven.</p>
            <?= $this->Form->create(null, ['url' => ['_name' => 'afrekenen-plaatsen']]) ?>
            <?= $this->Form->hidden('token', ['value' => $token]) ?>
            <?= $this->Form->button('Plaats demo-bestelling', ['class' => 'button place-order']) ?>
            <?= $this->Form->end() ?>
        </aside>
    </div>
</div>
