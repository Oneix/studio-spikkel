<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ProductsFixture extends TestFixture
{
    public array $records = [
        [
            'id' => 1, 'slug' => 'notitieboekje', 'name' => 'Bloemenboekje', 'category' => 'Papierwaren',
            'summary' => 'Boekje met bloemen.', 'description' => 'Een linnen boekje met bloemen en een lint.',
            'price_cents' => 1295, 'image' => 'collectie/notitieboekje.webp', 'image_alt' => 'Een linnen boekje.',
            'position' => 10, 'active' => true,
        ],
        [
            'id' => 2, 'slug' => 'verborgen-kaars', 'name' => 'Verborgen kaars', 'category' => 'Kaarsen',
            'summary' => 'Nog niet in de winkel.', 'description' => 'Verborgen artikel.',
            'price_cents' => 999, 'image' => 'collectie/geurkaars.webp', 'image_alt' => 'Een kaars.',
            'position' => 20, 'active' => false,
        ],
    ];
}
