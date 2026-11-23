<?php
declare(strict_types=1);

use function Cake\Core\env;

return [
    'Security' => [
        'salt' => trim(file_get_contents(ROOT . '/storage/security-salt')),
    ],
    'Datasources' => [
        'default' => [
            'host' => 'db',
            'username' => 'spikkel',
            'password' => env('SPICKEL_DB_PASSWORD'),
            'database' => 'studio_spikkel',
        ],
    ],
];
