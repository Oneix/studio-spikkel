<?php $this->assign('title', 'Cadeaus'); ?>
<section class="inner-hero">
    <div class="wrap">
        <h1>Cadeaus</h1>
        <p>Voor op de kast, in je tas of gewoon voor iemand aan wie je denkt.</p>
        <p class="shipping-offer">Gratis verzending binnen Nederland vanaf <?= h(\Cake\I18n\Number::currency($store['shipping']['NL']['free_from_cents'] / 100, 'EUR', ['precision' => 0])) ?> aan fysieke cadeaus.</p>
    </div>
</section>

<section class="wrap collection" aria-label="Onze cadeaus">
    <?php if ($products->isEmpty()) : ?>
        <p>Op dit moment staan er geen cadeaus in de winkel.</p>
    <?php else : ?>
        <ul class="product-grid">
            <?php foreach ($products as $index => $product) : ?>
                <li>
                    <a class="product-card" href="<?= h($this->Url->build(['_name' => 'cadeaus-detail', 'slug' => $product->slug])) ?>">
                        <?= $this->Html->image($product->image, [
                            'alt' => '',
                            'width' => 960,
                            'height' => 960,
                            'loading' => $index < 4 ? 'eager' : 'lazy',
                            'decoding' => 'async',
                        ]) ?>
                        <div class="product-card-body">
                            <p class="item-category"><?= h($product->category) ?></p>
                            <h2><?= h($product->name) ?></h2>
                            <p><?= h($product->summary) ?></p>
                            <span class="price"><?= h(\Cake\I18n\Number::currency($product->price_cents / 100, 'EUR')) ?></span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if ($giftCard !== null) : ?>
        <a class="gift-card-feature" href="<?= h($this->Url->build(['_name' => 'cadeaubon'])) ?>">
            <?= $this->Html->image($giftCard->image, ['alt' => '', 'width' => 960, 'height' => 960, 'loading' => 'lazy']) ?>
            <div>
                <h2>Digitale cadeaubon</h2>
                <p>Voor iemand die graag zelf iets uitzoekt.</p>
                <p class="price">Vanaf <?= h(\Cake\I18n\Number::currency($giftCard->price_cents / 100, 'EUR')) ?></p>
            </div>
        </a>
    <?php endif; ?>
</section>
