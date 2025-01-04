<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RolesPermissionsFixture
 */
class RolesPermissionsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'role_id' => 1,
                'permission_id' => 1,
                'created' => '2025-01-03 21:08:55',
                'modified' => '2025-01-03 21:08:55',
            ],
        ];
        parent::init();
    }
}
