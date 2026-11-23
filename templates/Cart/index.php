<?php
$this->assign('title', 'Winkelmand');
$money = static fn(int $amount): string => \Cake\I18n\Number::currency($amount / 100, 'EUR');
?>
<section class="inner-hero">
    <div class="wrap"><h1>Winkelmand</h1></div>
</section>
<div class="wrap basket-page">
    <div class="basket-feedback" aria-live="polite"><?= $this->Flash->render('cart') ?></div>
    <?php if ($cart['removed']) : ?>
        <p class="form-summary-error" role="status">Een cadeau is niet meer beschikbaar en is uit je mandje gehaald.</p>
    <?php endif; ?>
    <?php if ($cart['items'] === []) : ?>
        <div class="form-card basket-empty">
            <h2>Je winkelmand is leeg</h2>
            <p>Neem een kijkje bij de cadeaus.</p>
            <?= $this->Html->link('Bekijk de cadeaus', ['_name' => 'cadeaus'], ['class' => 'button']) ?>
        </div>
    <?php else : ?>
        <div class="basket-grid">
            <ul role="list" class="basket-items" aria-label="Cadeaus in je mandje">
                <?php foreach ($cart['items'] as $item) : ?>
                    <?php $product = $item['product']; ?>
                    <li class="basket-item">
                        <?= $this->Html->image($product->image, ['alt' => '', 'width' => 96, 'height' => 96]) ?>
                        <div class="basket-item-info">
                            <?php $target = $product->is_digital ? ['_name' => 'cadeaubon'] : ['_name' => 'cadeaus-detail', 'slug' => $product->slug]; ?>
                            <h2><?= $this->Html->link($product->name, $target) ?></h2>
                            <p><?= h($money($product->price_cents)) ?> per stuk</p>
                            <div class="basket-item-actions">
                                <?= $this->Form->create(null, ['url' => ['_name' => 'mandje-aanpassen', 'id' => $product->id], 'class' => 'basket-quantity']) ?>
                                <?= $this->Form->control('quantity', [
                                    'id' => 'aantal-' . $product->id, 'label' => 'Aantal', 'type' => 'number', 'min' => 1,
                                    'max' => \App\Store\Cart::MAX_QUANTITY, 'step' => 1, 'value' => $item['quantity'],
                                    'required' => true, 'aria-label' => 'Aantal voor ' . $product->name,
                                ]) ?>
                                <?= $this->Form->button('Aanpassen', ['class' => 'button button-outline', 'aria-label' => 'Aantal aanpassen voor ' . $product->name]) ?>
                                <?= $this->Form->end() ?>
                                <?= $this->Form->create(null, ['url' => ['_name' => 'mandje-verwijderen', 'id' => $product->id]]) ?>
                                <?= $this->Form->button('Verwijderen', ['class' => 'basket-remove', 'aria-label' => 'Verwijder ' . $product->name]) ?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                        <p class="basket-item-price price"><?= h($money($item['total'])) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <aside class="basket-total" aria-label="Overzicht winkelmand">
                <div><strong>Subtotaal</strong><span class="price"><?= h($money($cart['subtotal'])) ?></span></div>
                <p>Verzendkosten zijn nog niet inbegrepen.</p>
                <?= $this->Html->link('Naar afrekenen', ['_name' => 'afrekenen'], ['class' => 'button']) ?>
                <?= $this->Html->link('Verder winkelen', ['_name' => 'cadeaus'], ['class' => 'text-link']) ?>
            </aside>
        </div>
    <?php endif; ?>
</div>
