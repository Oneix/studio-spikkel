<?= $this->element('admin_heading', [
    'title' => $form->isNew() ? 'Nieuw product' : 'Product bewerken',
    'backRoute' => 'beheer-producten',
    'backLabel' => 'Producten',
]) ?>
<section class="form-card admin-editor">
    <?php if ($form->hasErrors()) : ?>
        <p class="form-summary-error" role="alert">Controleer de gemarkeerde velden.</p>
    <?php endif; ?>
    <?= $this->Form->create($form, ['type' => 'post', 'context' => ['validator' => 'admin']]) ?>
    <?= $this->Form->control('name', ['label' => 'Productnaam', 'maxlength' => 160]) ?>
    <div class="form-grid">
        <?= $this->Form->control('slug', ['label' => 'URL-naam', 'maxlength' => 140, 'pattern' => '[a-z0-9]+(-[a-z0-9]+)*', 'aria-describedby' => 'slug-hint']) ?>
        <?= $this->Form->control('category', ['label' => 'Categorie', 'maxlength' => 80]) ?>
    </div>
    <p class="form-hint" id="slug-hint">Gebruik kleine letters en streepjes, bijvoorbeeld bloemen-notitieboekje.</p>
    <?= $this->Form->control('summary', ['label' => 'Korte omschrijving', 'type' => 'textarea', 'rows' => 2, 'maxlength' => 240]) ?>
    <?= $this->Form->control('description', ['label' => 'Beschrijving', 'rows' => 6, 'maxlength' => 10000]) ?>
    <div class="form-grid">
        <?php if ($form->is_digital) : ?>
            <p class="admin-fixed-price"><strong>Waarde cadeaubon</strong><br><?= h(\Cake\I18n\Number::currency($form->price_cents / 100, 'EUR')) ?></p>
        <?php else : ?>
            <?= $this->Form->control('price_cents', ['label' => 'Prijs in euro', 'type' => 'text', 'inputmode' => 'decimal', 'maxlength' => 8, 'value' => $price]) ?>
        <?php endif; ?>
        <?= $this->Form->control('position', ['label' => 'Sorteerpositie', 'min' => 0, 'max' => 100000, 'step' => 1]) ?>
    </div>
    <?= $this->Form->control('image', ['label' => 'Afbeelding', 'options' => $images, 'empty' => 'Kies een afbeelding']) ?>
    <?= $this->Form->control('image_alt', ['label' => 'Beschrijving van de afbeelding', 'maxlength' => 220]) ?>
    <?= $this->Form->control('active', ['label' => 'Tonen in de winkel', 'type' => 'checkbox']) ?>
    <?= $this->Form->button('Product opslaan', ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</section>
