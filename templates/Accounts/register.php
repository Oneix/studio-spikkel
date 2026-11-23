<?php $this->assign('title', 'Account maken'); ?>
<section class="wrap account-wrap">
    <div class="form-card">
        <h1>Account maken</h1>
        <?php if ($next === 'afrekenen') : ?>
            <p class="account-intro">Je mandje staat voor je klaar als je daarna inlogt.</p>
        <?php endif; ?>
        <?php if ($form->hasErrors()) : ?>
            <p class="form-summary-error" role="alert">Controleer de gemarkeerde velden.</p>
        <?php endif; ?>
        <?= $this->Form->create($form, ['url' => ['_name' => 'registreren', '?' => ['verder' => $next]]]) ?>
        <?= $this->Form->control('name', ['label' => 'Naam', 'required' => true, 'autocomplete' => 'name', 'maxlength' => 120]) ?>
        <?= $this->Form->control('email', ['label' => 'E-mailadres', 'type' => 'email', 'required' => true, 'autocomplete' => 'username', 'maxlength' => 254]) ?>
        <?= $this->Form->control('password', [
            'label' => 'Wachtwoord', 'type' => 'password', 'required' => true, 'minlength' => 12,
            'autocomplete' => 'new-password', 'value' => '', 'aria-describedby' => 'wachtwoord-hulp',
        ]) ?>
        <p class="form-hint" id="wachtwoord-hulp">Gebruik minimaal 12 tekens.</p>
        <?= $this->Form->control('password_confirm', ['label' => 'Herhaal je wachtwoord', 'type' => 'password', 'required' => true, 'autocomplete' => 'new-password', 'value' => '']) ?>
        <?= $this->Form->button('Account maken', ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
        <p class="account-switch">Heb je al een account? <?= $this->Html->link('Log in', ['_name' => 'inloggen', '?' => ['verder' => $next]]) ?>.</p>
    </div>
</section>
