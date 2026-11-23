<?php $money = static fn(int $cents): string => \Cake\I18n\Number::currency($cents / 100, 'EUR'); ?>
<ul class="checkout-items order-saved-items" role="list">
    <?php foreach ($items as $item) : ?>
        <li>
            <div>
                <p><?= h($item->quantity) ?> × <?= h($item->name) ?></p>
                <small><?= h($money($item->unit_price_cents)) ?> per stuk</small>
                <?php foreach ($item->issued_gift_cards as $card) : ?>
                    <p class="gift-code">Demo-code <code><?= h($card->code) ?></code></p>
                <?php endforeach; ?>
                <?php if ($item->is_digital) : ?>
                    <p><small>Deze code heeft geen echt tegoed.</small></p>
                <?php endif; ?>
            </div>
            <strong><?= h($money($item->total_cents)) ?></strong>
        </li>
    <?php endforeach; ?>
</ul>
