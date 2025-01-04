<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateAddresses extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('addresses');
        $table
            ->addColumn(
                'addressable_type',
                'string',
                ['limit' => 255, 'null' => false]
            )
            ->addColumn(
                'addressable_id',
                'integer',
                ['null' => false]
            )
            ->addColumn(
                'street',
                'string',
                ['limit' => 255, 'null' => false]
            )
            ->addColumn(
                'city',
                'string',
                ['limit' => 100, 'null' => false]
            )
            ->addColumn(
                'state',
                'string',
                ['limit' => 100, 'null' => false]
            )
            ->addColumn(
                'postal_code',
                'string',
                ['limit' => 20, 'null' => false]
            )
            ->addColumn(
                'country',
                'string',
                ['limit' => 100, 'null' => false]
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
            ->addIndex(['addressable_type', 'addressable_id'])
            ->create();
    }
}
