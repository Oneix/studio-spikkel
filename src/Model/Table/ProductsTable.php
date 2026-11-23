<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Store\CatalogValidation;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductsTable extends Table
{
    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setDisplayField('name');
        $this->addBehavior('Timestamp');
    }

    /**
     * Public storefront pages only show active products.
     */
    public function findAvailable(SelectQuery $query): SelectQuery
    {
        return $query->where(['Products.active' => true]);
    }

    /**
     * Validate the catalog fields that staff are allowed to edit.
     */
    public function validationAdmin(Validator $validator): Validator
    {
        return CatalogValidation::publicFields($validator)
            ->notEquals('slug', 'cadeaubon', 'Deze URL-naam is gereserveerd voor de cadeaubonpagina.')
            ->requirePresence('name')->notEmptyString('name', 'Vul een productnaam in.')
            ->scalar('name')->maxLength('name', 160)
            ->requirePresence('category')->notEmptyString('category', 'Vul een categorie in.')
            ->scalar('category')->maxLength('category', 80)
            ->requirePresence('summary')->notEmptyString('summary', 'Schrijf een korte omschrijving.')
            ->scalar('summary')->maxLength('summary', 240)
            ->requirePresence('description')->notEmptyString('description', 'Schrijf een productbeschrijving.')
            ->scalar('description')->maxLength('description', 10000)
            ->requirePresence('price_cents')->notEmptyString('price_cents', 'Vul een bedrag in, bijvoorbeeld 12,95.')
            ->integer('price_cents')->greaterThan('price_cents', 0, 'Vul een bedrag groter dan nul in.')
            ->requirePresence('position')->notEmptyString('position', 'Vul een sorteerpositie in.')
            ->integer('position')->greaterThanOrEqual('position', 0)->lessThanOrEqual('position', 100000)
            ->requirePresence('active', 'create')->boolean('active');
    }

    /**
     * Keep public product URLs unique.
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['slug']), 'uniqueSlug', ['message' => 'Deze URL-naam is al in gebruik.']);

        return $rules;
    }
}
