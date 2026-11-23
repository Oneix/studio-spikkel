<?php $this->assign('title', $product->name); ?>
<article class="wrap product-detail">
    <div class="back-link">
        <?= $this->Html->link('← Alle cadeaus', ['_name' => 'cadeaus']) ?>
    </div>
    <?= $this->Html->image($product->image, [
        'class' => 'product-image',
        'alt' => $product->image_alt,
        'width' => 960,
        'height' => 960,
        'fetchpriority' => 'high',
    ]) ?>
    <div class="product-detail-copy">
        <p class="item-category"><?= h($product->category) ?></p>
        <h1><?= h($product->name) ?></h1>
        <p class="price"><?= h(\Cake\I18n\Number::currency($product->price_cents / 100, 'EUR')) ?></p>
        <p><?= h($product->description) ?></p>
        <div class="basket-feedback" aria-live="polite"><?= $this->Flash->render('cart') ?></div>
        <?= $this->Form->create(null, ['url' => ['_name' => 'mandje-toevoegen', 'id' => $product->id], 'class' => 'add-to-cart']) ?>
        <?= $this->Form->control('quantity', [
            'label' => 'Aantal', 'type' => 'number', 'min' => 1, 'max' => \App\Store\Cart::MAX_QUANTITY,
            'step' => 1, 'value' => 1, 'required' => true,
        ]) ?>
        <?= $this->Form->button('In mijn mandje', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
        <?= $this->Html->link('Een vraag over dit cadeau?', ['_name' => 'contact'], ['class' => 'text-link']) ?>
    </div>
</article>
