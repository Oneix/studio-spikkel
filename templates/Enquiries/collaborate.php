<?php $this->assign('title', 'Samenwerken'); ?>
<section class="inner-hero">
    <div class="wrap">
        <h1>Samenwerken</h1>
        <p>Maak je iets dat bij Studio Spikkel past? Vertel ons wat je graag in de winkel zou willen leggen.</p>
    </div>
</section>
<div class="wrap collaboration-page">
    <section class="form-card" id="aanvraag" aria-labelledby="aanvraag-kop">
        <h2 id="aanvraag-kop">Samenwerking aanvragen</h2>
        <p class="form-notice">We streven ernaar om binnen 5 werkdagen contact met je op te nemen. Je gegevens worden vertrouwelijk behandeld.</p>
        <?= $this->element('form_status', compact('form')) ?>
        <p class="form-required">Velden met een * zijn verplicht.</p>
        <?= $this->Form->create($form, ['type' => 'file', 'url' => ['_name' => 'samenwerken']]) ?>
        <fieldset>
            <legend>Jouw gegevens</legend>
            <div class="form-grid">
                <?= $this->Form->control('name', ['label' => 'Naam', 'required' => true, 'maxlength' => 120, 'autocomplete' => 'name']) ?>
                <?= $this->Form->control('email', ['label' => 'E-mailadres', 'type' => 'email', 'required' => true, 'maxlength' => 254, 'autocomplete' => 'email']) ?>
            </div>
            <?= $this->Form->control('website', ['label' => 'Website of portfoliolink', 'type' => 'url', 'maxlength' => 300, 'autocomplete' => 'url', 'placeholder' => 'https://']) ?>
        </fieldset>
        <fieldset>
            <legend>Wat maak je?</legend>
            <?= $this->Form->control('idea', [
                'label' => 'Omschrijf je product of idee',
                'type' => 'textarea', 'required' => true, 'maxlength' => 3000, 'rows' => 5,
                'aria-describedby' => 'idee-hulp',
            ]) ?>
            <p class="form-hint" id="idee-hulp">Vertel in een paar zinnen wat je via Studio Spikkel wilt aanbieden.</p>
            <div class="form-grid">
                <?= $this->Form->control('category', ['label' => 'Productcategorie', 'type' => 'select', 'options' => $categories, 'empty' => 'Kies een categorie', 'required' => true]) ?>
                <?= $this->Form->control('sales_channels', ['label' => 'Waar verkoop je nu?', 'type' => 'text', 'maxlength' => 300, 'placeholder' => 'Bijv. Etsy, markten of je webshop']) ?>
            </div>
            <?= $this->Form->control('attachment', [
                'label' => 'Productfoto of voorstel',
                'type' => 'file',
                'accept' => '.jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf',
                'aria-describedby' => 'bijlage-hulp',
            ]) ?>
            <p class="form-hint" id="bijlage-hulp">Eén JPG, PNG of PDF van maximaal 5 MB.</p>
        </fieldset>
        <fieldset>
            <legend>Contact opnemen</legend>
            <?= $this->Form->control('preferred_date', ['label' => 'Voorkeursdatum voor contact', 'type' => 'date']) ?>
            <?= $this->Form->control('keep_in_touch', ['label' => 'Houd mij op de hoogte van samenwerkingsmogelijkheden', 'type' => 'checkbox']) ?>
        </fieldset>
        <?= $this->Form->button('Verstuur aanvraag', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>
