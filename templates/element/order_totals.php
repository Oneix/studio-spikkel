<?php $money = static fn(int $cents): string => \Cake\I18n\Number::currency($cents / 100, 'EUR'); ?>
<dl class="order-totals">
    <div><dt>Subtotaal</dt><dd><?= h($money($totals['subtotal_cents'])) ?></dd></div>
    <div><dt>Verzendkosten</dt><dd><?= $totals['shipping_cents'] === 0 ? 'Gratis' : h($money($totals['shipping_cents'])) ?></dd></div>
    <div class="order-total"><dt>Totaal</dt><dd class="price"><?= h($money($totals['total_cents'])) ?></dd></div>
</dl>
