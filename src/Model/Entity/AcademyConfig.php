<?php
declare (strict_types = 1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class AcademyConfig extends Entity
{
    protected $_accessible = [
        'name' => true,
        'logo' => true,
        'motto' => true,
        'primary_color' => true,
        'secondary_color' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
    ];
}
