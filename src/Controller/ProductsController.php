<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;

class ProductsController extends AppController
{
    /**
     * Show the current selection in shop order.
     */
    public function index(): void
    {
        $catalog = $this->fetchTable('Products');
        $products = $catalog->find('available')->where(['is_digital' => false])->orderBy(['position', 'id'])->all();
        $giftCard = $catalog->find('available')->where(['is_digital' => true])->orderByAsc('price_cents')->first();
        $this->set(compact('products', 'giftCard'));
    }

    /**
     * Show one product by its public slug.
     */
    public function view(string $slug): ?Response
    {
        $product = $this->fetchTable('Products')->find('available')->where(['slug' => $slug])->firstOrFail();
        if ($product->is_digital) {
            return $this->redirect(['_name' => 'cadeaubon']);
        }
        $this->set(compact('product'));

        return null;
    }

    /**
     * Offer all active amounts on one gift card page.
     */
    public function giftCard(): void
    {
        $query = $this->fetchTable('Products')->find('available')->where(['is_digital' => true]);
        $variants = $query->orderByAsc('price_cents')->all()->toList();
        if ($variants === []) {
            throw new NotFoundException();
        }
        $this->set(['variants' => $variants, 'giftCard' => $variants[0]]);
    }
}
