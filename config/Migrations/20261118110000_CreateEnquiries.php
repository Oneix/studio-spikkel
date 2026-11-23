<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateEnquiries extends BaseMigration
{
    public function change(): void
    {
        $this->table('contact_messages')
            ->addColumn('name', 'string', ['limit' => 120])
            ->addColumn('email', 'string', ['limit' => 254])
            ->addColumn('message', 'text')
            ->addColumn('created', 'datetime')
            ->create();

        $this->table('collaboration_requests')
            ->addColumn('name', 'string', ['limit' => 120])
            ->addColumn('email', 'string', ['limit' => 254])
            ->addColumn('website', 'string', ['limit' => 300, 'null' => true])
            ->addColumn('idea', 'text')
            ->addColumn('category', 'string', ['limit' => 24])
            ->addColumn('sales_channels', 'string', ['limit' => 300, 'null' => true])
            ->addColumn('keep_in_touch', 'boolean', ['default' => false])
            ->addColumn('preferred_date', 'date', ['null' => true])
            ->addColumn('attachment_key', 'string', ['limit' => 48, 'null' => true])
            ->addColumn('attachment_name', 'string', ['limit' => 160, 'null' => true])
            ->addColumn('attachment_type', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('attachment_size', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('created', 'datetime')
            ->addIndex(['attachment_key'], ['unique' => true])
            ->create();
    }
}
