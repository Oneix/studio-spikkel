<h2>Bezorging en cadeau</h2>
<p class="delivery-choice"><?= h($details['delivery_label']) ?></p>
<?php if ($details['delivery_method'] === 'shipping') : ?>
    <address>
        <?= h($details['address_name']) ?><br>
        <?= h($details['street']) ?><br>
        <?= h($details['postal_code']) ?> <?= h($details['city']) ?>
    </address>
<?php elseif ($details['delivery_method'] === 'pickup') : ?>
    <p><?= $this->Html->link('Bekijk de openingstijden', ['_name' => 'contact', '#' => 'openingstijden']) ?>.</p>
<?php else : ?>
    <p>Voor een digitale cadeaubon is geen adres nodig.</p>
<?php endif; ?>
<?php if ($details['gift_wrap']) : ?>
    <p class="gift-note"><strong>Als cadeau inpakken</strong>
        <?php if ($details['gift_message'] !== null) : ?>
            <br><?= nl2br(h($details['gift_message'])) ?>
        <?php endif; ?>
    </p>
<?php endif; ?>
