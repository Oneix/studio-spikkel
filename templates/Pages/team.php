<?php $this->assign('title', 'Team'); ?>
<section class="inner-hero">
    <div class="wrap">
        <h1>Team</h1>
        <p>De twee gezichten achter Studio Spikkel.</p>
    </div>
</section>
<section class="wrap team-section" aria-label="Maak kennis met Emma en Noor">
    <?= $this->Html->image('winkel/team.webp', ['class' => 'team-photo', 'alt' => 'Emma en Noor staan naast elkaar aan de toonbank van Studio Spikkel.', 'width' => 1200, 'height' => 800]) ?>
    <div class="team-grid">
        <article class="team-card">
            <h2>Emma</h2>
            <p class="team-role">Eigenaresse &amp; ontwerpster</p>
            <p>Emma zoekt de cadeaus uit en maakt een deel zelf. Ze heeft een zwak voor handgemaakt papier, mooie letters en een kaartje dat precies goed valt.</p>
        </article>
        <article class="team-card">
            <h2>Noor</h2>
            <p class="team-role">Winkelmedewerker &amp; social media</p>
            <p>Noor helpt je een cadeau kiezen en maakt er graag iets moois van. Online laat ze zien wat er nieuw is en wat er achter de toonbank gebeurt.</p>
        </article>
    </div>
</section>
