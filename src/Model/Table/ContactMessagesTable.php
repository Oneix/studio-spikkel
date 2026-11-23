<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContactMessagesTable extends Table
{
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
            ->requirePresence('message')->scalar('message')->maxLength('message', 3000, 'Gebruik maximaal 3000 tekens.')
            ->notEmptyString('message', 'Schrijf een bericht.');
    }
}
