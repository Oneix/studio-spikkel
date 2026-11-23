<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Http\Response;

class ProductsController extends AdminController
{
    private const FIELDS = [
        'name', 'slug', 'category', 'summary', 'description', 'price_cents', 'image', 'image_alt', 'position', 'active',
    ];

    /**
     * List products including items that are hidden from the shop.
     */
    public function index(): void
    {
        $products = $this->fetchTable('Products')->find()->orderBy(['position', 'id']);
        $this->set('products', $this->paginate($products, ['limit' => 20]));
    }

    /**
     * Create a physical product or update a catalog entry without touching saved orders.
     */
    public function edit(?string $id = null): ?Response
    {
        $products = $this->fetchTable('Products');
        $form = $id === null ? $products->newEmptyEntity() : $products->get($id);
        if ($form->isNew()) {
            $form->patch(['active' => false, 'position' => 100]);
        }
        $price = $form->price_cents === null ? '' : number_format($form->price_cents / 100, 2, ',', '');
        if ($this->request->is('post')) {
            $data = $this->postedContent();
            if ($form->is_digital) {
                $data['price_cents'] = $form->price_cents;
            } else {
                $price = is_string($data['price_cents'] ?? null) ? $data['price_cents'] : '';
                $data['price_cents'] = $this->toCents($price);
            }
            $response = $this->saveContent($products, $form, $data, self::FIELDS, 'beheer-producten');
            if ($response !== null) {
                return $response;
            }
        }
        $this->showEditor($form, ['price' => $price]);

        return null;
    }

    /**
     * Parse euros using integer arithmetic to keep the stored price exact.
     */
    private function toCents(string $price): int|string
    {
        if (!preg_match('/\A(\d{1,5})(?:[,.](\d{1,2}))?\z/', $price, $parts)) {
            return '';
        }

        return (int)$parts[1] * 100 + (int)str_pad($parts[2] ?? '', 2, '0');
    }
}
