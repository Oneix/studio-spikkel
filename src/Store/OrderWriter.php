<?php
declare(strict_types=1);

namespace App\Store;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;

final class OrderWriter
{
    /**
     * Write the order snapshot and issue test codes within the caller's database transaction.
     */
    public static function save(Table $orders, int $userId, string $token, array $quote): EntityInterface
    {
        $lines = $orders->getAssociation('OrderItems')->getTarget();
        $codes = $lines->getAssociation('IssuedGiftCards')->getTarget();
        $order = $orders->newEntity($quote['order'] + [
            'user_id' => $userId,
            'number' => 'SP-' . strtoupper(bin2hex(random_bytes(6))),
            'checkout_token' => $token,
            'status' => 'placed',
        ]);
        $orders->saveOrFail($order, ['atomic' => false]);
        foreach ($quote['items'] as $item) {
            $line = $lines->newEntity($item + ['order_id' => $order->id]);
            $lines->saveOrFail($line, ['atomic' => false]);
            if (!$item['is_digital']) {
                continue;
            }
            $giftCards = $codes->insertQuery()->insert(['order_item_id', 'code']);
            for ($number = 0; $number < $item['quantity']; $number++) {
                $giftCards->values([
                    'order_item_id' => $line->id,
                    'code' => 'DEMO-' . strtoupper(bin2hex(random_bytes(8))),
                ]);
            }
            $giftCards->execute();
        }

        return $order;
    }
}
