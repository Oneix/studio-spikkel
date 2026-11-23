<?php
$this->assign('title', 'Bestelling ' . $order->number);
?>
<section class="inner-hero">
    <div class="wrap">
        <h1>Bestelling <?= h($order->number) ?></h1>
        <p>Geplaatst op <?= h($order->created->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i')) ?></p>
    </div>
</section>
<div class="wrap basket-page">
    <div class="form-feedback" aria-live="polite"><?= $this->Flash->render('order') ?></div>
    <div class="basket-grid">
        <section class="form-card order-main" aria-labelledby="besteld-kop">
            <h2 id="besteld-kop">Wat je hebt besteld</h2>
            <?= $this->element('order_saved_items', ['items' => $order->order_items]) ?>
            <div class="order-delivery"><?= $this->element('order_delivery', ['details' => $order]) ?></div>
        </section>
        <aside class="basket-total checkout-side" aria-label="Besteltotaal">
            <?= $this->element('order_totals', ['totals' => $order]) ?>
            <p>Demo-bestelling. Er is niets afgeschreven en er wordt niets verzonden.</p>
            <?= $this->Html->link('Mijn bestellingen', ['_name' => 'bestellingen'], ['class' => 'button']) ?>
        </aside>
    </div>
</div>
