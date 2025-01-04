<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateContacts extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('contacts');
        $table
            ->addColumn(
                'contactable_type',
                'string',
                ['limit' => 255, 'null' => false]
            )
            ->addColumn(
                'contactable_id',
                'integer',
                ['null' => false]
            )
            ->addColumn(
                'contact_type',
                'string',
                ['limit' => 50, 'null' => false]
            )
            ->addColumn(
                'contact_value',
                'string',
                ['limit' => 255, 'null' => false]
            )
            ->addColumn(
                'created',
                'datetime',
                ['default' => 'CURRENT_TIMESTAMP']
            )
            ->addColumn(
                'modified',
                'datetime',
                ['default' => 'CURRENT_TIMESTAMP']
            )
            ->addIndex(['contactable_type', 'contactable_id'])
            ->create();
    }
}
