<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

class OrdersController extends AppController
{
    /**
     * List only orders owned by the signed-in account.
     */
    public function index(): ?Response
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            return $this->redirect(['_name' => 'inloggen', '?' => ['verder' => 'bestellingen']]);
        }
        $query = $this->fetchTable('Orders')->find('ownedBy', userId: (int)$identity->getIdentifier());
        $orders = $this->paginate($query->orderByDesc('created')->orderByDesc('id'), ['limit' => 12]);
        $this->set(compact('orders'));

        return null;
    }

    /**
     * Look up the order by its owner as well as its public order number.
     */
    public function view(string $number): ?Response
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            return $this->redirect(['_name' => 'inloggen', '?' => ['verder' => 'bestellingen']]);
        }
        $order = $this->fetchTable('Orders')->find('ownedBy', userId: (int)$identity->getIdentifier())
            ->where(['Orders.number' => $number])->contain(['OrderItems.IssuedGiftCards'])->firstOrFail();
        $this->set(compact('order'));

        return null;
    }
}
