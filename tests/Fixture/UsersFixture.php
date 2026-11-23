<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [[
            'id' => 1, 'name' => 'Mo Test', 'email' => 'mo@example.test',
            'password' => (new DefaultPasswordHasher())->hash('SecretPass123!'),
            'created' => '2026-11-18 10:00:00', 'modified' => '2026-11-18 10:00:00',
        ]];
        parent::init();
    }
}
