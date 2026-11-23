<?php $this->assign('title', $post->title); ?>
<article class="wrap story-page">
    <div class="back-link">
        <?= $this->Html->link('← Alle berichten', ['_name' => 'nieuws']) ?>
    </div>
    <time datetime="<?= h($post->published_on->format('Y-m-d')) ?>"><?= h($post->published_on->format('d-m-Y')) ?></time>
    <h1><?= h($post->title) ?></h1>
    <p class="story-lead"><?= h($post->summary) ?></p>
    <?= $this->Html->image($post->image, ['class' => 'story-image', 'alt' => $post->image_alt, 'width' => 960, 'height' => 960]) ?>
    <div class="story-body">
        <?= $this->Text->autoParagraph(h($post->body)) ?>
        <?= $this->Html->link('Bekijk de collectie', ['_name' => 'cadeaus'], ['class' => 'text-link']) ?>
    </div>
</article>
