<?php
declare(strict_types=1);

use function Cake\Core\env;

return [
    'Store' => [
        'email' => 'hallo@studiospikkel.nl',
        'hours' => [
            'Maandag t/m donderdag' => '09.00–17.00 uur',
            'Vrijdag' => '09.00–21.00 uur',
            'Zaterdag' => '10.00–18.00 uur',
            'Zondag' => 'Gesloten',
        ],
        'shipping' => [
            'NL' => ['label' => 'Nederland', 'delivery' => '1–2 werkdagen', 'fee_cents' => 395, 'free_from_cents' => 4000],
            'BE' => ['label' => 'België', 'delivery' => '2–4 werkdagen', 'fee_cents' => 695, 'free_from_cents' => 6000],
            'DE' => ['label' => 'Duitsland', 'delivery' => '2–5 werkdagen', 'fee_cents' => 795, 'free_from_cents' => 7000],
            'pickup' => ['label' => 'Afhalen in de winkel', 'delivery' => 'Direct beschikbaar', 'fee_cents' => 0, 'free_from_cents' => null],
        ],
        'holiday' => [
            'start' => '08-03',
            'end' => '08-18',
            'preview' => filter_var(env('STORE_CLOSURE_PREVIEW', false), FILTER_VALIDATE_BOOLEAN),
        ],
    ],
];
