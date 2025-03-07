<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->orderBy('id', 'desc')->get();
    }

    public function getById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function deleteById(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function deactivate($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function createData(array $data)
    {
        $model = $this->model->create($data);
        return $model->fresh();
    }

    public function updateData($id, array $data)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);
        return $model->fresh();
    }


}
