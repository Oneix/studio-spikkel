<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Store\CatalogValidation;
use Cake\I18n\Date;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class NewsPostsTable extends Table
{
    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setDisplayField('title');
        $this->addBehavior('Timestamp');
    }

    /**
     * A post becomes public on its publication date in the shop's timezone.
     */
    public function findPublished(SelectQuery $query): SelectQuery
    {
        return $query->where(['NewsPosts.published_on <=' => new Date('today', 'Europe/Amsterdam')]);
    }

    /**
     * Check the editorial content and allow a blank publication date for drafts.
     */
    public function validationAdmin(Validator $validator): Validator
    {
        return CatalogValidation::publicFields($validator)
            ->requirePresence('title')->notEmptyString('title', 'Vul een titel in.')
            ->scalar('title')->maxLength('title', 180)
            ->requirePresence('summary')->notEmptyString('summary', 'Schrijf een korte inleiding.')
            ->scalar('summary')->maxLength('summary', 280)
            ->requirePresence('body')->notEmptyString('body', 'Schrijf het nieuwsbericht.')
            ->scalar('body')->maxLength('body', 10000)
            ->allowEmptyDate('published_on')
            ->date('published_on', ['ymd'], 'Kies een geldige publicatiedatum.');
    }

    /**
     * Keep public news URLs unique.
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['slug']), 'uniqueSlug', ['message' => 'Deze URL-naam is al in gebruik.']);

        return $rules;
    }
}
