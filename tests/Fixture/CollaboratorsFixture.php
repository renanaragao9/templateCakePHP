<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CollaboratorsFixture
 */
class CollaboratorsFixture extends TestFixture
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
                'sexo' => 'L',
                'date' => '2025-03-12',
                'color' => 'Lorem ipsum dolor sit amet',
                'active' => 1,
                'user_id' => 1,
                'created' => '2025-03-12 15:52:24',
                'modified' => '2025-03-12 15:52:24',
            ],
        ];
        parent::init();
    }
}
