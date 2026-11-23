<?php
declare(strict_types=1);

use Cake\Database\Schema\CachedCollection;
use Migrations\BaseMigration;

class AddAdminRole extends BaseMigration
{
    public function up(): void
    {
        $this->table('users')->addColumn('is_admin', 'boolean', ['default' => false])->update();
        $this->clearUsersSchema();
    }

    public function down(): void
    {
        $this->table('users')->removeColumn('is_admin')->update();
        $this->clearUsersSchema();
    }

    private function clearUsersSchema(): void
    {
        $schema = $this->getAdapter()->getConnection()->getSchemaCollection();
        if ($schema instanceof CachedCollection) {
            $schema->getCacher()->delete($schema->cacheKey('users'));
        }
    }
}
