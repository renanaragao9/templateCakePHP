<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AcademyConfigFixture
 */
class AcademyConfigFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'academy_config';
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
                'logo' => 'Lorem ipsum dolor sit amet',
                'motto' => 'Lorem ipsum dolor sit amet',
                'primary_color' => 'Lorem ipsum dolor sit amet',
                'secondary_color' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-12-14 03:22:15',
                'modified' => '2024-12-14 03:22:15',
            ],
        ];
        parent::init();
    }
}
