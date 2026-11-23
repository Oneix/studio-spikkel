<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class OrdersController extends AdminController
{
    /**
     * List the saved demo orders with the customer name.
     */
    public function index(): void
    {
        $orders = $this->fetchTable('Orders')->find()
            ->contain(['Users' => ['fields' => ['id', 'name']]])
            ->orderByDesc('Orders.created')->orderByDesc('Orders.id');
        $this->set('orders', $this->paginate($orders, ['limit' => 20]));
    }

    /**
     * Show the original snapshot and customer details for a demo order.
     */
    public function view(string $id): void
    {
        $order = $this->fetchTable('Orders')->get($id, contain: [
            'Users' => ['fields' => ['id', 'name', 'email']],
            'OrderItems.IssuedGiftCards',
        ]);
        $this->set(compact('order'));
    }
}
