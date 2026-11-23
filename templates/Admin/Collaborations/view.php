<?= $this->element('admin_heading', [
    'title' => 'Aanvraag van ' . $submission->name,
    'backRoute' => 'beheer-samenwerking',
    'backLabel' => 'Samenwerkingsaanvragen',
]) ?>
<section class="form-card admin-editor">
    <dl class="admin-details">
        <dt>E-mailadres</dt><dd><?= h($submission->email) ?></dd>
        <dt>Ontvangen</dt><dd><?= h($submission->created->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i')) ?></dd>
        <dt>Website of portfolio</dt><dd><?= h($submission->website ?: 'Niet opgegeven') ?></dd>
        <dt>Categorie</dt><dd><?= h($categories[$submission->category] ?? $submission->category) ?></dd>
        <dt>Huidige verkoopkanalen</dt><dd><?= h($submission->sales_channels ?: 'Niet opgegeven') ?></dd>
        <dt>Op de hoogte houden</dt><dd><?= $submission->keep_in_touch ? 'Ja' : 'Nee' ?></dd>
        <dt>Voorkeursdatum</dt><dd><?= h($submission->preferred_date?->format('d-m-Y') ?? 'Niet opgegeven') ?></dd>
    </dl>
    <h2>Product of idee</h2>
    <p class="admin-message"><?= h($submission->idea) ?></p>
    <?php if ($submission->attachment_key !== null) : ?>
        <div class="admin-attachment">
            <h2>Bijlage</h2>
            <p><?= h($submission->attachment_name) ?> · <?= h(\Cake\I18n\Number::toReadableSize($submission->attachment_size)) ?></p>
            <?= $this->Html->link(
                'Bijlage downloaden',
                ['_name' => 'beheer-bijlage', 'id' => $submission->id],
                ['class' => 'button button-outline'],
            ) ?>
        </div>
    <?php endif; ?>
</section>
