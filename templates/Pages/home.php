<section class="hero" aria-labelledby="home-title">
    <div class="wrap hero-inner">
        <div class="hero-copy">
            <p class="hero-category">Het cadeauwinkeltje</p>
            <h1 id="home-title">Kleine cadeaus.<br><span>Groot gebaar.</span></h1>
            <p>Van een geurkaars voor zomaar tot een kaartje dat precies zegt wat je bedoelt. Bij Studio Spikkel vind je handgemaakte en duurzame cadeaus met karakter.</p>
            <div class="hero-actions">
                <?= $this->Html->link('Bekijk de cadeaus', ['_name' => 'cadeaus'], ['class' => 'button']) ?>
                <?= $this->Html->link('Samenwerking aanvragen', ['_name' => 'samenwerken'], ['class' => 'button button-outline']) ?>
            </div>
        </div>
        <figure class="hero-photo">
            <picture>
                <source media="(max-width: 650px)" srcset="<?= h($this->Url->image('spikkel-cover-720.webp')) ?>">
                <?= $this->Html->image('spikkel-cover.webp', [
                    'alt' => 'Een brandende kaars, een ingepakt cadeau en een bloemenboekje op een linnen tafel.',
                    'width' => 1120,
                    'height' => 1400,
                    'fetchpriority' => 'high',
                ]) ?>
            </picture>
        </figure>
    </div>
</section>

<section class="wrap explore" aria-labelledby="explore-title">
    <h2 id="explore-title">Kijk eens rond</h2>
    <div class="explore-grid">
        <a class="explore-card explore-lilac" href="<?= h($this->Url->build(['_name' => 'cadeaus'])) ?>">
            <h3>Cadeaus</h3>
            <p>Kaarsen, papierwaren en kleine vondsten.</p>
            <span aria-hidden="true">↗</span>
        </a>
        <a class="explore-card explore-mint" href="<?= h($this->Url->build(['_name' => 'over'])) ?>">
            <h3>Over de winkel</h3>
            <p>Hoe Studio Spikkel aan de keukentafel begon.</p>
            <span aria-hidden="true">↗</span>
        </a>
        <a class="explore-card explore-sand" href="<?= h($this->Url->build(['_name' => 'nieuws'])) ?>">
            <h3>Nieuws</h3>
            <p>Nieuwe vondsten en berichten uit de winkel.</p>
            <span aria-hidden="true">↗</span>
        </a>
    </div>
</section>
