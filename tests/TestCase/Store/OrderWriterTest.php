<?php
declare(strict_types=1);

namespace App\Test\TestCase\Store;

use App\Store\OrderWriter;
use Cake\TestSuite\TestCase;

class OrderWriterTest extends TestCase
{
    protected array $fixtures = ['app.Users'];

    /**
     * Store one distinct code for each unit of a digital line in the same transaction.
     */
    public function testDigitalUnitsEachGetACode(): void
    {
        $orders = $this->getTableLocator()->get('Orders');
        $connection = $orders->getConnection();
        $connection->begin();
        try {
            $order = OrderWriter::save($orders, 1, str_repeat('a', 64), [
                'order' => [
                    'delivery_method' => 'digital',
                    'delivery_label' => 'Digitaal',
                    'subtotal_cents' => 5000,
                    'shipping_cents' => 0,
                    'total_cents' => 5000,
                ],
                'items' => [[
                    'product_id' => 1,
                    'name' => 'Digitale cadeaubon',
                    'unit_price_cents' => 2500,
                    'quantity' => 2,
                    'total_cents' => 5000,
                    'is_digital' => true,
                ]],
            ]);
            $saved = $orders->get($order->id, contain: ['OrderItems.IssuedGiftCards']);
            $this->assertSame(5000, $saved->total_cents);
            $this->assertCount(1, $saved->order_items);
            $line = $saved->order_items[0];
            $this->assertSame(2, $line->quantity);
            $this->assertCount(2, $line->issued_gift_cards);
            $codes = array_map(static fn($card): string => $card->code, $line->issued_gift_cards);
            $this->assertCount(2, array_unique($codes));
            foreach ($codes as $code) {
                $this->assertMatchesRegularExpression('/\ADEMO-[0-9A-F]{16}\z/', $code);
            }
        } finally {
            $connection->rollback();
        }
    }
}
