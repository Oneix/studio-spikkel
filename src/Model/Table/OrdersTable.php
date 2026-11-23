<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;

class OrdersTable extends Table
{
    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->belongsTo('Users');
        $this->hasMany('OrderItems')->setSort(['OrderItems.id' => 'ASC']);
        $this->addBehavior('Timestamp', ['events' => ['Model.beforeSave' => ['created' => 'new']]]);
    }

    /**
     * Restrict customer order reads to the signed-in account.
     */
    public function findOwnedBy(SelectQuery $query, int $userId): SelectQuery
    {
        return $query->where(['Orders.user_id' => $userId]);
    }
}
