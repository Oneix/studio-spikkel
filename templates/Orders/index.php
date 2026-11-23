<?php $this->assign('title', 'Mijn bestellingen'); ?>
<section class="inner-hero"><div class="wrap"><h1>Mijn bestellingen</h1></div></section>
<div class="wrap basket-page order-history">
    <?php if ($orders->count() === 0) : ?>
        <div class="form-card basket-empty">
            <h2>Je hebt nog geen bestellingen</h2>
            <p>Neem een kijkje bij de cadeaus.</p>
            <?= $this->Html->link('Bekijk de cadeaus', ['_name' => 'cadeaus'], ['class' => 'button']) ?>
        </div>
    <?php else : ?>
        <ul class="order-history-list" role="list">
            <?php foreach ($orders as $order) : ?>
                <li>
                    <a class="order-list-card" href="<?= h($this->Url->build(['_name' => 'bestelling', 'number' => $order->number])) ?>">
                        <div><h2><?= h($order->number) ?></h2>
                            <p><?= h($order->created->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i')) ?> · <?= h($order->delivery_label) ?></p>
                        </div>
                        <div class="order-list-total"><p>Geplaatst</p><span class="price"><?= h(\Cake\I18n\Number::currency($order->total_cents / 100, 'EUR')) ?></span></div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ($this->Paginator->total() > 1) : ?>
            <nav aria-label="Bladzijden met bestellingen" class="order-pages">
                <?= $this->Paginator->prev('← Vorige') ?>
                <?= $this->Paginator->next('Volgende →') ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>
