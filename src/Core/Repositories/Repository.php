<?php
namespace Serff\Cms\Core\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 *
 * @package Serff\Cms\Domain\Repositories
 */
abstract class Repository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param int $id
     * @param array $with
     *
     * @return Model
     */
    public function getById($id, $with = [])
    {
        return $this->getFirstBy('id', $id, $with);
    }

    /**
     * @param string $index
     * @param mixed $value
     * @param array $with
     *
     * @return Model
     */
    public function getFirstBy($index, $value, $with)
    {
        return $this->model->where($index, '=', $value)->with($with)->first();
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function updateOrCreate($data)
    {
        return $this->model->firstOrCreate($data);
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool
     */
    public function update($id, $attributes)
    {
        return $this->getById($id)->update($attributes);
    }

    /**
     * @param $attributes
     *
     * @return Model
     */
    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $length
     *
     * @return mixed
     */
    public function getLatestPaginated($length, $with = [])
    {
        return $this->model->with($with)->orderBy('id', 'DESC')->paginate($length);
    }
}