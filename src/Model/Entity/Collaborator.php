<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Collaborator Entity
 *
 * @property int $id
 * @property string $name
 * @property string $sexo
 * @property \Cake\I18n\FrozenDate $date
 * @property string $color
 * @property bool $active
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Event[] $events
 */
class Collaborator extends Entity
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
        'name' => true,
        'sexo' => true,
        'date' => true,
        'color' => true,
        'active' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'events' => true,
    ];
}
