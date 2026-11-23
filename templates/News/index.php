<?php $this->assign('title', 'Nieuws'); ?>
<section class="inner-hero">
    <div class="wrap">
        <h1>Nieuws</h1>
        <p>Nieuw in de winkel, of gewoon iets leuks om te delen.</p>
    </div>
</section>

<div class="wrap news-list">
    <?php if ($posts->isEmpty()) : ?>
        <p>Er zijn nog geen nieuwsberichten.</p>
    <?php endif; ?>
    <?php foreach ($posts as $post) : ?>
        <article class="news-card">
            <?= $this->Html->image($post->image, ['alt' => '', 'width' => 960, 'height' => 960, 'loading' => 'lazy']) ?>
            <div class="news-card-copy">
                <time datetime="<?= h($post->published_on->format('Y-m-d')) ?>"><?= h($post->published_on->format('d-m-Y')) ?></time>
                <h2><?= $this->Html->link($post->title, ['_name' => 'nieuws-detail', 'slug' => $post->slug]) ?></h2>
                <p><?= h($post->summary) ?></p>
            </div>
        </article>
    <?php endforeach; ?>
</div>
