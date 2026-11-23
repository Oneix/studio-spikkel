<?php $this->assign('title', 'Over Studio Spikkel'); ?>
<section class="inner-hero">
    <div class="wrap"><h1>Over Studio Spikkel</h1></div>
</section>
<article class="wrap story-page about-page">
    <div class="story-body">
        <p class="story-lead">Welkom bij Studio Spikkel — een klein maar kleurrijk cadeauwinkeltje vol fijne vondsten!</p>
        <p>Bij ons vind je originele, handgemaakte en duurzame cadeaus die nét even anders zijn. Van vrolijke wenskaarten tot geurkaarsen en posters met een knipoog: alles met liefde uitgezocht of gemaakt.</p>
        <p>Studio Spikkel is ontstaan uit een liefde voor mooie dingen en kleine gebaren. We geloven dat een goed gekozen cadeau een glimlach kan brengen — op elk moment van het jaar. Loop gerust eens binnen of blader lekker rond op onze website. Hier is altijd wel iets leuks te vinden voor jezelf of iemand anders.</p>
        <h2>Over de eigenaar</h2>
        <p>Studio Spikkel is opgericht door Emma, een creatieve duizendpoot met een passie voor handgemaakte spullen, typografie en alles wat nét een beetje anders is. Wat begon als een hobby aan de keukentafel, groeide uit tot een eigen winkel vol persoonlijkheid. Emma gelooft in de kracht van kleine dingen — een kaartje, een geur, een vorm — en stopt die aandacht en zorg in elk product dat ze selecteert of zelf maakt.</p>
        <?= $this->Html->link('Neem contact op', ['_name' => 'contact'], ['class' => 'button']) ?>
    </div>
    <?= $this->Html->image('winkel/atelier.webp', ['class' => 'story-image', 'alt' => 'De werktafel met kaarsen, boekjes en lint in de cadeauwinkel.', 'width' => 1200, 'height' => 800, 'loading' => 'lazy']) ?>
</article>
