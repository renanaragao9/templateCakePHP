<?php
declare (strict_types = 1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AcademyConfigTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('academy_config');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('logo')
            ->maxLength('logo', 255)
            ->requirePresence('logo', 'create')
            ->notEmptyString('logo');

        $validator
            ->scalar('motto')
            ->maxLength('motto', 255)
            ->requirePresence('motto', 'create')
            ->notEmptyString('motto');

        $validator
            ->scalar('primary_color')
            ->maxLength('primary_color', 255)
            ->requirePresence('primary_color', 'create')
            ->notEmptyString('primary_color');

        $validator
            ->scalar('secondary_color')
            ->maxLength('secondary_color', 255)
            ->requirePresence('secondary_color', 'create')
            ->notEmptyString('secondary_color');

        return $validator;
    }
}
