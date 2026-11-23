<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CollaborationRequestsTable extends Table
{
    public const CATEGORIES = [
        'wenskaarten' => 'Wenskaarten',
        'kaarsen' => 'Kaarsen',
        'posters' => 'Posters',
        'sieraden' => 'Sieraden',
        'anders' => 'Anders',
    ];

    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp', ['events' => ['Model.beforeSave' => ['created' => 'new']]]);
    }

    /**
     * @inheritDoc
     */
    public function validationDefault(Validator $validator): Validator
    {
        return $validator
            ->requirePresence('name')->scalar('name')->maxLength('name', 120, 'Gebruik maximaal 120 tekens.')
            ->notEmptyString('name', 'Vul je naam in.')
            ->requirePresence('email')->email('email', false, 'Vul een geldig e-mailadres in.')
            ->maxLength('email', 254, 'Gebruik maximaal 254 tekens.')->notEmptyString('email', 'Vul je e-mailadres in.')
            ->scalar('website')->maxLength('website', 300, 'Gebruik maximaal 300 tekens.')
            ->add('website', 'webAddress', [
                'rule' => static fn(mixed $value): bool => is_string($value)
                    && preg_match('~^https?://~i', $value) === 1
                    && filter_var($value, FILTER_VALIDATE_URL) !== false,
                'message' => 'Vul een webadres in dat begint met https:// of http://.',
                'last' => true,
            ])->allowEmptyString('website')
            ->requirePresence('idea')->scalar('idea')
            ->maxLength('idea', 3000, 'Gebruik maximaal 3000 tekens.')
            ->notEmptyString('idea', 'Omschrijf kort je product of idee.')
            ->requirePresence('category')
            ->inList('category', array_keys(self::CATEGORIES), 'Kies een categorie.')
            ->notEmptyString('category', 'Kies een categorie.')
            ->scalar('sales_channels')->maxLength('sales_channels', 300, 'Gebruik maximaal 300 tekens.')
            ->allowEmptyString('sales_channels')
            ->boolean('keep_in_touch', 'Vink het vakje aan of laat het leeg.')
            ->date('preferred_date', ['ymd'], 'Vul een geldige datum in.')
            ->allowEmptyDate('preferred_date');
    }
}
