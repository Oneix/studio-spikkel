<?php $this->assign('title', 'Inloggen'); ?>
<section class="wrap account-wrap">
    <div class="form-card">
        <h1>Inloggen</h1>
        <?php if ($next === 'afrekenen') : ?>
            <p class="account-intro">Log in om verder te gaan met afrekenen. Je mandje blijft bewaard.</p>
        <?php elseif ($next === 'beheer') : ?>
            <p class="account-intro">Log in met je beheerdersaccount.</p>
        <?php endif; ?>
        <div class="form-feedback" aria-live="polite"><?= $this->Flash->render('account') ?></div>
        <?= $this->Form->create(null, ['url' => ['_name' => 'inloggen', '?' => ['verder' => $next]]]) ?>
        <?= $this->Form->control('email', ['label' => 'E-mailadres', 'type' => 'email', 'required' => true, 'autocomplete' => 'username', 'maxlength' => 254]) ?>
        <?= $this->Form->control('password', ['label' => 'Wachtwoord', 'type' => 'password', 'required' => true, 'autocomplete' => 'current-password', 'value' => '']) ?>
        <?= $this->Form->button('Inloggen', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
        <?php if ($next !== 'beheer') : ?>
            <p class="account-switch">Nieuw bij Studio Spikkel? <?= $this->Html->link('Maak een account', ['_name' => 'registreren', '?' => ['verder' => $next]]) ?>.</p>
        <?php endif; ?>
    </div>
</section>
