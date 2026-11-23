<?= $this->element('admin_heading', [
    'title' => 'Bestelling ' . $order->number,
    'backRoute' => 'beheer-bestellingen',
    'backLabel' => 'Demo-bestellingen',
]) ?>
<div class="basket-grid">
    <section class="form-card order-main">
        <dl class="admin-details">
            <dt>Klant</dt><dd><?= h($order->user->name) ?> · <?= h($order->user->email) ?></dd>
            <dt>Geplaatst op</dt><dd><?= h($order->created->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i')) ?></dd>
        </dl>
        <h2>Bestelde cadeaus</h2>
        <?= $this->element('order_saved_items', ['items' => $order->order_items]) ?>
        <div class="order-delivery"><?= $this->element('order_delivery', ['details' => $order]) ?></div>
    </section>
    <aside class="basket-total checkout-side" aria-label="Besteltotaal">
        <?= $this->element('order_totals', ['totals' => $order]) ?>
        <p>Demo-bestelling. Er is niets afgeschreven.</p>
    </aside>
</div>
