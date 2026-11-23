<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsers extends BaseMigration
{
    public function change(): void
    {
        $this->table('users')
            ->addColumn('name', 'string', ['limit' => 120])
            ->addColumn('email', 'string', ['limit' => 254])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}
