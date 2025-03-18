<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\SessionsTable&\Cake\ORM\Association\HasMany $Sessions
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Sessions', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255, 'O nome não pode ter mais de 255 caracteres.')
            ->requirePresence('name', 'create', 'O nome é obrigatório.')
            ->notEmptyString('name', 'O nome não pode estar vazio.');

        $validator
            ->email('email', false, 'Por favor, forneça um endereço de e-mail válido.')
            ->requirePresence('email', 'create', 'O e-mail é obrigatório.')
            ->notEmptyString('email', 'O e-mail não pode estar vazio.')
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Este e-mail já está em uso.'
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255, 'A senha não pode ter mais de 255 caracteres.')
            ->requirePresence('password', 'create', 'A senha é obrigatória.')
            ->notEmptyString('password', 'A senha não pode estar vazia.');

        $validator
            ->dateTime('last_login')
            ->allowEmptyDateTime('last_login');

        $validator
            ->integer('login_count')
            ->allowEmptyString('login_count');

        $validator
            ->boolean('active')
            ->notEmptyString('active', 'O campo ativo não pode estar vazio.');

        $validator
            ->integer('role_id')
            ->notEmptyString('role_id', 'O campo role_id não pode estar vazio.');

        return $validator;
    }

    public function validationPassword(Validator $validator): Validator
    {
        $validator
            ->add('password', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'A senha deve ter pelo menos 6 caracteres.',
                ],
            ])
            ->add('confirm_password', 'compareWith', [
                'rule' => ['compareWith', 'password'],
                'message' => 'As senhas não coincidem.',
            ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn('role_id', 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
