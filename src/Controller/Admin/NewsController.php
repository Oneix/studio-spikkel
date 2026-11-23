<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Http\Response;

class NewsController extends AdminController
{
    private const FIELDS = ['title', 'slug', 'summary', 'body', 'image', 'image_alt', 'published_on'];

    /**
     * Show drafts and scheduled posts alongside published news.
     */
    public function index(): void
    {
        $posts = $this->fetchTable('NewsPosts')->find()->orderByDesc('modified')->orderByDesc('id');
        $this->set('posts', $this->paginate($posts, ['limit' => 20]));
    }

    /**
     * Create or edit a news post with an optional publication date.
     */
    public function edit(?string $id = null): ?Response
    {
        $posts = $this->fetchTable('NewsPosts');
        $form = $id === null ? $posts->newEmptyEntity() : $posts->get($id);
        if ($this->request->is('post')) {
            $response = $this->saveContent($posts, $form, $this->postedContent(), self::FIELDS, 'beheer-nieuws');
            if ($response !== null) {
                return $response;
            }
        }
        $this->showEditor($form);

        return null;
    }
}
