<?= $this->element('admin_heading', [
    'title' => 'Bericht van ' . $message->name,
    'backRoute' => 'beheer-contact',
    'backLabel' => 'Contactberichten',
]) ?>
<section class="form-card admin-editor">
    <dl class="admin-details">
        <dt>E-mailadres</dt><dd><?= h($message->email) ?></dd>
        <dt>Ontvangen</dt><dd><?= h($message->created->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i')) ?></dd>
    </dl>
    <h2>Bericht</h2>
    <p class="admin-message"><?= h($message->message) ?></p>
</section>
