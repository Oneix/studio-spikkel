<?php $this->assign('title', $title); ?>
<div class="admin-heading">
    <div>
        <?php if (isset($backRoute)) : ?>
            <?= $this->Html->link('← ' . $backLabel, ['_name' => $backRoute], ['class' => 'text-link admin-back']) ?>
        <?php endif; ?>
        <h1><?= h($title) ?></h1>
    </div>
    <?php if (isset($newRoute)) : ?>
        <?= $this->Html->link($newLabel, ['_name' => $newRoute], ['class' => 'button']) ?>
    <?php endif; ?>
</div>
