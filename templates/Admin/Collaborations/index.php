<?= $this->element('admin_heading', ['title' => 'Aanvragen van makers']) ?>
<?php if ($requests->count() === 0) : ?>
    <p class="form-card">Er zijn nog geen samenwerkingsaanvragen.</p>
<?php else : ?>
    <ul class="admin-list" role="list">
        <?php foreach ($requests as $submission) : ?>
            <li>
                <a class="admin-row" href="<?= h($this->Url->build(['_name' => 'beheer-samenwerking-bekijken', 'id' => $submission->id])) ?>">
                    <div>
                        <h2><?= h($submission->name) ?></h2>
                        <p><?= h($categories[$submission->category] ?? $submission->category) ?> · <?= h($submission->email) ?></p>
                    </div>
                    <span><?= h($submission->created->setTimezone('Europe/Amsterdam')->format('d-m-Y H:i')) ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?= $this->element('admin_pagination') ?>
<?php endif; ?>
