<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Lib\Api\ApiPaginator;
use App\Model\Entity\Measurement;
/**
 * Measurements Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Measurement newEmptyEntity()
 * @method \App\Model\Entity\Measurement newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Measurement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Measurement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Measurement findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Measurement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Measurement[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Measurement|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Measurement saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Measurement[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Measurement[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Measurement[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Measurement[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MeasurementsTable extends Table {

    use \App\Lib\Traits\PaginatorTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('measurements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
                ->nonNegativeInteger('id')
                ->allowEmptyString('id', null, 'create');

        $validator
                ->nonNegativeInteger('systolic')
                ->allowEmptyString('systolic');

        $validator
                ->nonNegativeInteger('diastolic')
                ->allowEmptyString('diastolic');

        $validator
                ->nonNegativeInteger('heart_rate')
                ->allowEmptyString('heart_rate');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function exitById($id) {
        $this->exists(['Measurements.id' => $id]);
    }

    public function existsByIdAndUserId($id, $userId) {
        return $this->exists([
                    'Measurements.id' => $id,
                    'Measurements.user_id' => $userId
        ]);
    }

    public function getMeasurementsIndex(ApiPaginator $ApiPaginator, int $userId): array {
        $query = $this->find()
                ->where(['Measurements.user_id' => $userId])
                ->order(['Measurements.created' => 'DESC']);
        return $this->paginator($query, $ApiPaginator);
    }

    public function getMeasurementsDashboard(int $start, int $end, int $userId): array {
        $query = $this->find()
                ->where(
                        [
                            'Measurements.user_id' => $userId,
                            'Measurements.created <=' => $end,
                            'Measurements.created >=' => $start,
                ])
                ->order(['Measurements.created' => 'ASC']);

        return $query->toArray();
    }

    public function getLastMeasurement(int $userId): ? Measurement {
        $query = $this->find()
                ->where(
                        ['Measurements.user_id' => $userId])
                ->order(['Measurements.created' => 'DESC'])
                ->limit(1);

        return $query->first();
    }

}
