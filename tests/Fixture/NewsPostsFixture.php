<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class NewsPostsFixture extends TestFixture
{
    public array $records = [
        [
            'id' => 1, 'slug' => 'nieuwe-collectie', 'title' => 'Onze nieuwe collectie is binnen!',
            'summary' => 'Geurkaarsen en boekjes.', 'body' => 'Nieuw in Studio Spikkel.',
            'image' => 'collectie/geurkaars.webp', 'image_alt' => 'Een kaars.', 'published_on' => '2020-03-13',
        ],
        [
            'id' => 2, 'slug' => 'afgeschermd-concept', 'title' => 'Afgeschermd concept',
            'summary' => 'Concept.', 'body' => 'Nog niet gepubliceerd.',
            'image' => 'collectie/geurkaars.webp', 'image_alt' => 'Een kaars.', 'published_on' => null,
        ],
        [
            'id' => 3, 'slug' => 'later-bericht', 'title' => 'Later bericht',
            'summary' => 'Concept.', 'body' => 'Gepland voor later.',
            'image' => 'collectie/geurkaars.webp', 'image_alt' => 'Een kaars.', 'published_on' => '2099-01-01',
        ],
    ];
}
