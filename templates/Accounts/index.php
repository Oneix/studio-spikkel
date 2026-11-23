<?php $this->assign('title', 'Mijn account'); ?>
<section class="wrap account-wrap">
    <div class="form-card">
        <h1>Mijn account</h1>
        <p class="account-intro">Hoi <?= h($identity->get('name')) ?>, je bent ingelogd.</p>
        <dl class="account-details">
            <dt>E-mailadres</dt>
            <dd><?= h($identity->get('email')) ?></dd>
        </dl>
        <div class="account-actions">
            <?php if ($identity->get('is_admin') === true) : ?>
                <?= $this->Html->link('Naar beheer', ['_name' => 'beheer'], ['class' => 'button button-outline']) ?>
            <?php endif; ?>
            <?= $this->Html->link('Mijn bestellingen', ['_name' => 'bestellingen'], ['class' => 'button']) ?>
            <?= $this->Html->link('Naar mijn mandje', ['_name' => 'winkelmand'], ['class' => 'button button-outline']) ?>
            <?= $this->Form->create(null, ['url' => ['_name' => 'uitloggen']]) ?>
            <?= $this->Form->button('Uitloggen', ['class' => 'button button-outline']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>
