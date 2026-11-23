<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateCatalogAndNews extends BaseMigration
{
    public function change(): void
    {
        $this->table('products')
            ->addColumn('slug', 'string', ['limit' => 140])
            ->addColumn('name', 'string', ['limit' => 160])
            ->addColumn('category', 'string', ['limit' => 80])
            ->addColumn('summary', 'string', ['limit' => 240])
            ->addColumn('description', 'text')
            ->addColumn('price_cents', 'integer', ['signed' => false])
            ->addColumn('image', 'string', ['limit' => 190])
            ->addColumn('image_alt', 'string', ['limit' => 220])
            ->addColumn('position', 'integer', ['default' => 0])
            ->addColumn('active', 'boolean', ['default' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->addIndex(['slug'], ['unique' => true])
            ->addIndex(['active', 'position'])
            ->create();

        $this->table('news_posts')
            ->addColumn('slug', 'string', ['limit' => 140])
            ->addColumn('title', 'string', ['limit' => 180])
            ->addColumn('summary', 'string', ['limit' => 280])
            ->addColumn('body', 'text')
            ->addColumn('image', 'string', ['limit' => 190])
            ->addColumn('image_alt', 'string', ['limit' => 220])
            ->addColumn('published_on', 'date', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->addIndex(['slug'], ['unique' => true])
            ->addIndex(['published_on'])
            ->create();
    }
}
