<?php $this->assign('title', 'Contact'); ?>
<section class="inner-hero">
    <div class="wrap">
        <h1>Contact</h1>
        <p>Een vraag over een cadeau of over de winkel? Stuur ons gerust een bericht.</p>
    </div>
</section>
<div class="wrap contact-grid">
    <section class="form-card" id="contactformulier" aria-labelledby="contact-kop">
        <h2 id="contact-kop">Stuur een bericht</h2>
        <?= $this->element('form_status', compact('form')) ?>
        <?= $this->Form->create($form, ['url' => ['_name' => 'contact']]) ?>
        <div class="form-grid">
            <?= $this->Form->control('name', ['label' => 'Naam', 'required' => true, 'maxlength' => 120, 'autocomplete' => 'name']) ?>
            <?= $this->Form->control('email', ['label' => 'E-mailadres', 'type' => 'email', 'required' => true, 'maxlength' => 254, 'autocomplete' => 'email']) ?>
            <?= $this->Form->control('message', ['label' => 'Bericht', 'type' => 'textarea', 'required' => true, 'maxlength' => 3000, 'rows' => 6]) ?>
        </div>
        <?= $this->Form->button('Verstuur bericht', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
    </section>
    <section class="hours-card" id="openingstijden" aria-labelledby="uren-kop">
        <h2 id="uren-kop">Openingstijden</h2>
        <table>
            <tbody>
                <?php foreach ($store['hours'] as $day => $hours) : ?>
                    <tr><th scope="row"><?= h($day) ?></th><td><?= h($hours) ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="closure-note"><strong>Vakantie</strong><br>Gesloten van <?= h($holiday['label']) ?>.</p>
        <div class="contact-links">
            <p>Mail je liever rechtstreeks? <a href="mailto:<?= h($store['email']) ?>"><?= h($store['email']) ?></a></p>
            <?= $this->Html->link('Samenwerken met Studio Spikkel', ['_name' => 'samenwerken'], ['class' => 'text-link']) ?>
        </div>
    </section>
</div>
