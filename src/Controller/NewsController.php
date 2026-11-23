<?php
declare(strict_types=1);

namespace App\Controller;

class NewsController extends AppController
{
    /**
     * List published shop news, newest first.
     */
    public function index(): void
    {
        $query = $this->fetchTable('NewsPosts')->find('published');
        $posts = $query->orderByDesc('published_on')->orderByDesc('id')->all();
        $this->set(compact('posts'));
    }

    /**
     * Show a published news item by its public slug.
     */
    public function view(string $slug): void
    {
        $post = $this->fetchTable('NewsPosts')->find('published')->where(['slug' => $slug])->firstOrFail();
        $this->set(compact('post'));
    }
}
