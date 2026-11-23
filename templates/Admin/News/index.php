<?= $this->element('admin_heading', ['title' => 'Nieuws', 'newRoute' => 'beheer-nieuws-nieuw', 'newLabel' => 'Nieuw bericht']) ?>
<?php if ($posts->count() === 0) : ?>
    <p class="form-card">Er staan nog geen nieuwsberichten.</p>
<?php else : ?>
    <?php $today = new \Cake\I18n\Date('today', 'Europe/Amsterdam'); ?>
    <ul class="admin-list" role="list">
        <?php foreach ($posts as $post) : ?>
            <?php
            $published = $post->published_on;
            $isLive = $published !== null && $published <= $today;
            $state = $published === null ? 'Concept' : ($isLive ? 'Gepubliceerd' : 'Gepland');
            ?>
            <li>
                <a class="admin-row" href="<?= h($this->Url->build(['_name' => 'beheer-nieuws-bewerken', 'id' => $post->id])) ?>">
                    <div><h2><?= h($post->title) ?></h2><?php if ($published !== null) : ?><p><?= h($published->format('d-m-Y')) ?></p><?php endif; ?></div>
                    <span class="admin-state<?= $isLive ? ' is-live' : '' ?>"><?= h($state) ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?= $this->element('admin_pagination') ?>
<?php endif; ?>
