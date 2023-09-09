<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 *
 */
abstract class BaseRepository
{
    /**
     * @var Builder
     */
    protected $model;

    /**
     * @return mixed
     */
    abstract public function init();


    /**
     * @param $col
     * @param $sort
     * @return \Illuminate\Support\Collection
     */
    public function getAll($col = ['*'],$sort = null)
    {
        if(empty($sort)) {
            $sort = [
                "field" => "id",
                "direction" => "desc"
            ];
        }
        return $this->model->orderBy($sort['field'],$sort['direction'])->get($col);
    }

    /**
     * @param $id
     * @param $col
     * @return Model|mixed|null
     */
    public function find($id, $col = ['*'])
    {
        return $this->model->find($id, $col) ?? null;
    }

    /**
     * @param $col
     * @param $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listWithPaginate($col = ['*'], $perPage = 15)
    {
        return $this->model->paginate($perPage, $col);
    }

    /**     *
     * @param array $attributes
     * @return |\Illuminate\Database\Eloquent\Model|int
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function insert(array $attributes)
    {
        return $this->model->insert($attributes);
    }

    /**
     * @param array $condition
     * @param array $attributes
     * @return bool
     */
    public function update(array $condition, array $attributes)
    {
        return $this->model->updateOrInsert($condition, $attributes);
    }

    /**
     * @param $id
     * @param array $attributes
     * @return int
     */
    public function updateById($id, array $attributes)
    {
        return $this->model->find($id)->update($attributes);
    }

    /**
     * please dont use that function if use sofe delete on model for completely delete
     * @param $id
     * @param $isForce
     * @return int
     */
    public function delete($id, $isForce)
    {
        return $this->model->find($id)->delete();
    }

    public function findOneBy($condition)
    {
        return $this->model->where($condition)->first();
    }
}
