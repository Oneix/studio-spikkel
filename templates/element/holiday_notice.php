<aside class="shop-notice" aria-label="Vakantiesluiting">
    <div class="wrap">
        Studio Spikkel is van <?= h($holiday['label']) ?> gesloten vanwege vakantie.
        <?= $this->Html->link('Openingstijden', ['_name' => 'contact', '#' => 'openingstijden']) ?>
    </div>
</aside>
<dialog class="holiday-dialog" aria-labelledby="vakantie-kop" aria-describedby="vakantie-tekst" data-holiday-key="<?= h($holiday['key']) ?>">
    <img src="<?= h($this->Url->image('spikkel-mark.png')) ?>" width="48" height="48" alt="">
    <h2 id="vakantie-kop">Even met vakantie</h2>
    <p id="vakantie-tekst">De winkel is gesloten van <?= h($holiday['label']) ?>.</p>
    <form method="dialog">
        <button class="button" type="submit" autofocus>Sluiten</button>
    </form>
</dialog>
