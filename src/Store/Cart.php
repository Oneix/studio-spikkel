<?php
declare(strict_types=1);

namespace App\Store;

use Cake\Database\Driver\Mysql;
use Cake\Http\Session;
use Cake\ORM\Table;

final class Cart
{
    public const MAX_QUANTITY = 99;
    public const SESSION_KEY = 'Cart.items';

    /**
     * Save quantities in the session and read current product details from the catalog.
     */
    public function __construct(private readonly Session $session, private readonly Table $products)
    {
    }

    /**
     * Fetch the current quantities, indexed by product ID.
     *
     * @return array<int, int>
     */
    public function quantities(): array
    {
        return $this->session->read(self::SESSION_KEY, []);
    }

    /**
     * Set the quantity of a product. Zero removes the item internally.
     */
    public function setQuantity(int $id, int $quantity): void
    {
        $items = $this->quantities();
        if ($quantity === 0) {
            unset($items[$id]);
        } else {
            $items[$id] = $quantity;
        }
        $this->session->write(self::SESSION_KEY, $items);
    }

    /**
     * Use catalog prices and leave unavailable items out of the total.
     *
     * @return array{items: array, subtotal: int, physicalSubtotal: int, hasPhysical: bool, removed: bool}
     */
    public function summary(bool $lockProducts = false): array
    {
        $quantities = $this->quantities();
        $summary = [
            'items' => [],
            'subtotal' => 0,
            'physicalSubtotal' => 0,
            'hasPhysical' => false,
            'removed' => false,
        ];
        if ($quantities === []) {
            return $summary;
        }

        $query = $this->products->find('available')->where(['id IN' => array_keys($quantities)]);
        if ($lockProducts && $this->products->getConnection()->getDriver() instanceof Mysql) {
            $query->epilog('FOR UPDATE');
        }
        $available = $query->all()->indexBy('id')->toArray();
        foreach ($quantities as $id => $quantity) {
            $product = $available[$id] ?? null;
            if ($product === null) {
                unset($quantities[$id]);
                $summary['removed'] = true;
                continue;
            }
            $total = $product->price_cents * $quantity;
            $summary['items'][] = ['product' => $product, 'quantity' => $quantity, 'total' => $total];
            $summary['subtotal'] += $total;
            if (!$product->is_digital) {
                $summary['physicalSubtotal'] += $total;
                $summary['hasPhysical'] = true;
            }
        }
        if ($summary['removed']) {
            $this->session->write(self::SESSION_KEY, $quantities);
        }

        return $summary;
    }
}
