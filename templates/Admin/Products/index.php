<?= $this->element('admin_heading', ['title' => 'Producten', 'newRoute' => 'beheer-producten-nieuw', 'newLabel' => 'Nieuw product']) ?>
<?php if ($products->count() === 0) : ?>
    <p class="form-card">Er staan nog geen producten in het assortiment.</p>
<?php else : ?>
    <ul class="admin-list" role="list">
        <?php foreach ($products as $product) : ?>
            <li>
                <a class="admin-row admin-product-row" href="<?= h($this->Url->build(['_name' => 'beheer-producten-bewerken', 'id' => $product->id])) ?>">
                    <?= $this->Html->image($product->image, ['alt' => '', 'width' => 64, 'height' => 64, 'loading' => 'lazy']) ?>
                    <div>
                        <h2><?= h($product->name) ?></h2>
                        <p><?= h($product->category) ?> · <?= h(\Cake\I18n\Number::currency($product->price_cents / 100, 'EUR')) ?></p>
                    </div>
                    <span class="admin-state<?= $product->active ? ' is-live' : '' ?>"><?= $product->active ? 'In de winkel' : 'Verborgen' ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?= $this->element('admin_pagination') ?>
<?php endif; ?>
