<?= $this->element('admin_heading', [
    'title' => $form->isNew() ? 'Nieuw bericht' : 'Nieuwsbericht bewerken',
    'backRoute' => 'beheer-nieuws',
    'backLabel' => 'Nieuws',
]) ?>
<section class="form-card admin-editor">
    <?php if ($form->hasErrors()) : ?>
        <p class="form-summary-error" role="alert">Controleer de gemarkeerde velden.</p>
    <?php endif; ?>
    <?= $this->Form->create($form, ['type' => 'post', 'context' => ['validator' => 'admin']]) ?>
    <?= $this->Form->control('title', ['label' => 'Titel', 'maxlength' => 180]) ?>
    <?= $this->Form->control('slug', ['label' => 'URL-naam', 'maxlength' => 140, 'pattern' => '[a-z0-9]+(-[a-z0-9]+)*', 'aria-describedby' => 'slug-hint']) ?>
    <p class="form-hint" id="slug-hint">Gebruik kleine letters en streepjes, bijvoorbeeld nieuwe-collectie.</p>
    <?= $this->Form->control('summary', ['label' => 'Korte inleiding', 'type' => 'textarea', 'rows' => 2, 'maxlength' => 280]) ?>
    <?= $this->Form->control('body', ['label' => 'Nieuwsbericht', 'type' => 'textarea', 'rows' => 8, 'maxlength' => 10000]) ?>
    <?= $this->Form->control('image', ['label' => 'Afbeelding', 'options' => $images, 'empty' => 'Kies een afbeelding']) ?>
    <?= $this->Form->control('image_alt', ['label' => 'Beschrijving van de afbeelding', 'maxlength' => 220]) ?>
    <?= $this->Form->control('published_on', ['label' => 'Publicatiedatum', 'type' => 'date', 'aria-describedby' => 'datum-hint']) ?>
    <p class="form-hint" id="datum-hint">Laat de datum leeg voor een concept. Kies een datum in de toekomst om het bericht in te plannen.</p>
    <?= $this->Form->button('Bericht opslaan', ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</section>
