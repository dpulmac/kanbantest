<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tarjetas Model
 *
 * @method \App\Model\Entity\Tarjeta newEmptyEntity()
 * @method \App\Model\Entity\Tarjeta newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Tarjeta> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tarjeta get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Tarjeta findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Tarjeta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Tarjeta> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tarjeta|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Tarjeta saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Tarjeta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tarjeta>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tarjeta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tarjeta> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tarjeta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tarjeta>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tarjeta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tarjeta> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TarjetasTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tarjetas');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');
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
            ->scalar('nombre')
            ->maxLength('nombre', 255)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre');

        $validator
            ->dateTime('fecha_creacion')
            ->allowEmptyDateTime('fecha_creacion');

        $validator
            ->scalar('estado')
            ->maxLength('estado', 50)
            ->allowEmptyString('estado');

        $validator
            ->scalar('miembros')
            ->maxLength('miembros', 255)
            ->allowEmptyString('miembros');

        $validator
            ->scalar('descripcion')
            ->allowEmptyString('descripcion');

        $validator
            ->scalar('comentarios')
            ->allowEmptyString('comentarios');

        $validator
            ->date('fecha_fin')
            ->allowEmptyDate('fecha_fin');

        return $validator;
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName(): string
    {
        return 'kanban';
    }
}
