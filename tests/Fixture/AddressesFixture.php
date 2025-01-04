<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AddressesFixture
 */
class AddressesFixture extends TestFixture
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
                'addressable_type' => 'Lorem ipsum dolor sit amet',
                'addressable_id' => 1,
                'street' => 'Lorem ipsum dolor sit amet',
                'city' => 'Lorem ipsum dolor sit amet',
                'state' => 'Lorem ipsum dolor sit amet',
                'postal_code' => 'Lorem ipsum dolor ',
                'country' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-01-03 21:09:29',
                'modified' => '2025-01-03 21:09:29',
            ],
        ];
        parent::init();
    }
}
