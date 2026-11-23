<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class OrderItemsTable extends Table
{
    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->hasMany('IssuedGiftCards')->setSort(['IssuedGiftCards.id' => 'ASC']);
    }
}
