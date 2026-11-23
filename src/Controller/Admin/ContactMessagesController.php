<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class ContactMessagesController extends AdminController
{
    /**
     * Show the newest contact messages first.
     */
    public function index(): void
    {
        $messages = $this->fetchTable('ContactMessages')->find()
            ->select(['id', 'name', 'email', 'created'])->orderByDesc('created')->orderByDesc('id');
        $this->set('messages', $this->paginate($messages, ['limit' => 20]));
    }

    /**
     * Show one contact submission.
     */
    public function view(string $id): void
    {
        $this->set('message', $this->fetchTable('ContactMessages')->get($id));
    }
}
