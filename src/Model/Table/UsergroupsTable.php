<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Lib\Api\ApiPaginator;
/**
 * Usergroups Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Usergroup newEmptyEntity()
 * @method \App\Model\Entity\Usergroup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Usergroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Usergroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\Usergroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Usergroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Usergroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Usergroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usergroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usergroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Usergroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Usergroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Usergroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsergroupsTable extends Table
{
     use \App\Lib\Traits\PaginatorTrait;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('usergroups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Users', [
            'foreignKey' => 'usergroup_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        return $validator;
    }
    
    public function existById($id) {
        return $this->exists(['Usergroups.id' =>$id]);
    }
    
     public function getUsergroupsIndex(ApiPaginator $ApiPaginator): array {
         $query = $this->find()
                 ->order(['Usergroups.id' => 'ASC']);
         
         return $this->paginator($query, $ApiPaginator);
     }
    
}
