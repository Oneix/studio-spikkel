<?= $this->element('admin_heading', ['title' => 'Contactberichten']) ?>
<?php if ($messages->count() === 0) : ?>
    <p class="form-card">Er zijn nog geen contactberichten.</p>
<?php else : ?>
    <ul class="admin-list" role="list">
        <?php foreach ($messages as $message) : ?>
            <li>
                <a class="admin-row" href="<?= h($this->Url->build(['_name' => 'beheer-contact-bekijken', 'id' => $message->id])) ?>">
                    <div><h2><?= h($message->name) ?></h2><p><?= h($message->email) ?></p></div>
                    <span><?= h($message->created->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i')) ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?= $this->element('admin_pagination') ?>
<?php endif; ?>
