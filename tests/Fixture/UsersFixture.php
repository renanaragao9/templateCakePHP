<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'last_login' => '2025-01-03 21:40:27',
                'login_count' => 1,
                'active' => 1,
                'role_id' => 1,
                'created' => '2025-01-03 21:40:27',
                'modified' => '2025-01-03 21:40:27',
            ],
        ];
        parent::init();
    }
}
