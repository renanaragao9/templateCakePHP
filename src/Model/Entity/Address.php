<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Address Entity
 *
 * @property int $id
 * @property string $addressable_type
 * @property int $addressable_id
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $postal_code
 * @property string $country
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Address extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'addressable_type' => true,
        'addressable_id' => true,
        'street' => true,
        'city' => true,
        'state' => true,
        'postal_code' => true,
        'country' => true,
        'created' => true,
        'modified' => true,
    ];
}
