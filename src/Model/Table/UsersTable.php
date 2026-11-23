<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setDisplayField('email');
        $this->addBehavior('Timestamp');
    }

    /**
     * @inheritDoc
     */
    public function validationDefault(Validator $validator): Validator
    {
        return $validator
            ->requirePresence('name', 'create', 'Vul je naam in.')
            ->scalar('name')->maxLength('name', 120, 'Gebruik maximaal 120 tekens.')
            ->notEmptyString('name', 'Vul je naam in.')
            ->requirePresence('email', 'create', 'Vul je e-mailadres in.')
            ->email('email', false, 'Vul een geldig e-mailadres in.')
            ->maxLength('email', 254)->notEmptyString('email', 'Vul je e-mailadres in.')
            ->requirePresence('password', 'create', 'Kies een wachtwoord.')
            ->notEmptyString('password', 'Kies een wachtwoord.')
            ->scalar('password')->minLength('password', 12, 'Gebruik minimaal 12 tekens.')
            ->add('password', 'bytes', [
                'rule' => static fn(mixed $value): bool => is_string($value) && strlen($value) <= 72
                    && !str_contains($value, "\0"),
                'message' => 'Gebruik een wachtwoord van maximaal 72 bytes, zonder nultekens.',
            ])
            ->requirePresence('password_confirm', 'create', 'Herhaal je wachtwoord.')
            ->notEmptyString('password_confirm', 'Herhaal je wachtwoord.')
            ->sameAs('password_confirm', 'password', 'De wachtwoorden komen niet overeen.');
    }

    /**
     * @inheritDoc
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), [
            'errorField' => 'email',
            'message' => 'Dit e-mailadres is al in gebruik.',
        ]);

        return $rules;
    }
}
