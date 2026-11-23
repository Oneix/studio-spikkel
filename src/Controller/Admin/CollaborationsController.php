<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Table\CollaborationRequestsTable;
use App\Store\PrivateAttachment;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;

class CollaborationsController extends AdminController
{
    /**
     * List maker requests without loading attachment paths into the list.
     */
    public function index(): void
    {
        $requests = $this->fetchTable('CollaborationRequests')->find()
            ->select(['id', 'name', 'email', 'category', 'created'])->orderByDesc('created')->orderByDesc('id');
        $this->set('requests', $this->paginate($requests, ['limit' => 20]));
        $this->set('categories', CollaborationRequestsTable::CATEGORIES);
    }

    /**
     * Show one submission and its download link when it has an attachment.
     */
    public function view(string $id): void
    {
        $submission = $this->fetchTable('CollaborationRequests')->get($id);
        $this->set(compact('submission'));
        $this->set('categories', CollaborationRequestsTable::CATEGORIES);
    }

    /**
     * Serve the private attachment as a download to administrators only.
     */
    public function download(string $id): Response
    {
        $submission = $this->fetchTable('CollaborationRequests')->get($id);
        $path = PrivateAttachment::forCollaborations()->availablePath((string)$submission->attachment_key);
        if ($path === null) {
            throw new NotFoundException('Deze bijlage is niet beschikbaar.');
        }
        $name = 'bijlage-' . $submission->id . '.' . pathinfo($path, PATHINFO_EXTENSION);

        return $this->response->withFile($path, ['download' => true, 'name' => $name])
            ->withHeader('X-Content-Type-Options', 'nosniff');
    }
}
