<?= $this->element('admin_heading', ['title' => 'Demo-bestellingen']) ?>
<?php if ($orders->count() === 0) : ?>
    <p class="form-card">Er zijn nog geen demo-bestellingen geplaatst.</p>
<?php else : ?>
    <ul class="admin-list" role="list">
        <?php foreach ($orders as $order) : ?>
            <li>
                <a class="admin-row" href="<?= h($this->Url->build(['_name' => 'beheer-bestellingen-bekijken', 'id' => $order->id])) ?>">
                    <div>
                        <h2><?= h($order->number) ?></h2>
                        <p><?= h($order->user->name) ?> · <?= h($order->created->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i')) ?></p>
                        <p><?= h($order->delivery_label) ?></p>
                    </div>
                    <span class="price"><?= h(\Cake\I18n\Number::currency($order->total_cents / 100, 'EUR')) ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?= $this->element('admin_pagination') ?>
<?php endif; ?>
