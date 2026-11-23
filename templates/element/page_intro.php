<?php $this->assign('title', $title); ?>
<section class="wrap page-intro">
    <h1><?= h($title) ?></h1>
    <p><?= h($intro) ?></p>
    <?php if (isset($link, $route)): ?>
        <?= $this->Html->link($link, ['_name' => $route], ['class' => 'text-link']) ?>
    <?php endif; ?>
</section>
