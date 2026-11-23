<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\CollaborationRequestsTable;
use App\Store\PrivateAttachment;
use Cake\Http\Response;
use Cake\Log\Log;
use InvalidArgumentException;
use Throwable;

class EnquiriesController extends AppController
{
    /**
     * Show the shop contact form and save valid messages for the staff inbox.
     */
    public function contact(): ?Response
    {
        $messages = $this->fetchTable('ContactMessages');
        $form = $messages->newEmptyEntity();
        if ($this->request->is('post')) {
            $form = $messages->newEntity($this->formData(['name', 'email', 'message']));
            if (!$form->hasErrors()) {
                try {
                    $messages->saveOrFail($form);
                    $this->Flash->success('Bedankt! Je bericht is ontvangen.', ['key' => 'submission']);

                    return $this->redirect(['_name' => 'contact', '#' => 'contactformulier'], 303);
                } catch (Throwable) {
                    $this->submissionFailed();
                }
            } else {
                $this->response = $this->response->withStatus(422);
            }
        }
        $this->set(compact('form'));

        return null;
    }

    /**
     * Save a maker's request and optional privately stored attachment as one operation.
     */
    public function collaborate(): ?Response
    {
        $requests = $this->fetchTable('CollaborationRequests');
        $form = $requests->newEmptyEntity();
        if ($this->request->is('post')) {
            $form = $requests->newEntity($this->formData([
                'name', 'email', 'website', 'idea', 'category', 'sales_channels', 'keep_in_touch', 'preferred_date',
            ]));
            $upload = $this->request->getUploadedFile('attachment');
            $storage = PrivateAttachment::forCollaborations();
            $attachment = null;
            if ($upload !== null && $upload->getError() !== UPLOAD_ERR_NO_FILE) {
                try {
                    $attachment = $storage->inspect($upload);
                } catch (InvalidArgumentException $exception) {
                    $form->setError('attachment', [$exception->getMessage()]);
                }
            }

            if (!$form->hasErrors()) {
                $storedKey = null;
                try {
                    $requests->getConnection()->transactional(function () use (
                        $requests,
                        $form,
                        $attachment,
                        $storage,
                        $upload,
                        &$storedKey,
                    ): void {
                        if ($attachment !== null) {
                            $form->patch($attachment);
                        }
                        $requests->saveOrFail($form, ['atomic' => false]);
                        if ($attachment !== null && $upload !== null) {
                            $storedKey = $attachment['attachment_key'];
                            $storage->store($upload, $storedKey);
                        }
                    });
                    $text = 'Bedankt! Je samenwerkingsaanvraag is ontvangen.';
                    $this->Flash->success($text, ['key' => 'submission']);

                    return $this->redirect(['_name' => 'samenwerken', '#' => 'aanvraag'], 303);
                } catch (Throwable) {
                    if ($storedKey !== null) {
                        try {
                            $storage->discard($storedKey);
                        } catch (Throwable) {
                            Log::error('Studio Spikkel could not clean up an unlinked upload.');
                        }
                    }
                    $this->submissionFailed();
                }
            } else {
                $this->response = $this->response->withStatus(422);
            }
        }
        $this->set(['form' => $form, 'categories' => CollaborationRequestsTable::CATEGORIES]);

        return null;
    }

    /**
     * Limit form submissions to the fields handled by the action.
     */
    private function formData(array $fields): array
    {
        $data = array_intersect_key($this->request->getData(), array_fill_keys($fields, true));

        return array_map(static fn(mixed $value): mixed => is_string($value) ? trim($value) : $value, $data);
    }

    /**
     * Report a temporary failure without logging private submission data.
     */
    private function submissionFailed(): void
    {
        Log::error('Studio Spikkel could not save a form submission.');
        $this->Flash->error('Versturen lukt op dit moment niet. Probeer het straks nog eens.', ['key' => 'submission']);
        $this->response = $this->response->withStatus(503);
    }
}
