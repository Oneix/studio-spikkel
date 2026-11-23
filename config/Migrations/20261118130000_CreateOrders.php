<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Migrations\BaseMigration;

class CreateOrders extends BaseMigration
{
    public function change(): void
    {
        $signed = !(bool)Configure::read('Migrations.unsigned_primary_keys');
        $this->table('products')->addColumn('is_digital', 'boolean', ['default' => false])->update();

        $this->table('orders')
            ->addColumn('user_id', 'integer', ['signed' => $signed])
            ->addColumn('number', 'string', ['limit' => 15])
            ->addColumn('checkout_token', 'string', ['limit' => 64])
            ->addColumn('status', 'string', ['limit' => 20, 'default' => 'placed'])
            ->addColumn('delivery_method', 'string', ['limit' => 12])
            ->addColumn('delivery_label', 'string', ['limit' => 80])
            ->addColumn('shipping_country', 'string', ['limit' => 2, 'null' => true])
            ->addColumn('address_name', 'string', ['limit' => 120, 'null' => true])
            ->addColumn('street', 'string', ['limit' => 160, 'null' => true])
            ->addColumn('postal_code', 'string', ['limit' => 12, 'null' => true])
            ->addColumn('city', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('gift_wrap', 'boolean', ['default' => false])
            ->addColumn('gift_message', 'string', ['limit' => 240, 'null' => true])
            ->addColumn('subtotal_cents', 'integer', ['signed' => false])
            ->addColumn('shipping_cents', 'integer', ['signed' => false])
            ->addColumn('total_cents', 'integer', ['signed' => false])
            ->addColumn('created', 'datetime')
            ->addIndex(['number'], ['unique' => true])
            ->addIndex(['checkout_token'], ['unique' => true])
            ->addIndex(['user_id', 'created'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'RESTRICT'])
            ->create();

        // Keep a snapshot of the catalog entry even after the product is changed or removed.
        $this->table('order_items')
            ->addColumn('order_id', 'integer', ['signed' => $signed])
            ->addColumn('product_id', 'integer', ['signed' => $signed])
            ->addColumn('name', 'string', ['limit' => 160])
            ->addColumn('unit_price_cents', 'integer', ['signed' => false])
            ->addColumn('quantity', 'integer', ['signed' => false])
            ->addColumn('total_cents', 'integer', ['signed' => false])
            ->addColumn('is_digital', 'boolean', ['default' => false])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE'])
            ->create();

        $this->table('issued_gift_cards')
            ->addColumn('order_item_id', 'integer', ['signed' => $signed])
            ->addColumn('code', 'string', ['limit' => 22])
            ->addIndex(['code'], ['unique' => true])
            ->addForeignKey('order_item_id', 'order_items', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
