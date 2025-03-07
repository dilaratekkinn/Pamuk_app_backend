<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    public function getAll();

    public function getById(int $id);

    public function deleteById(int $id);
    public function deactivate(int $id);

    public function createData(array $data);

    public function updateData(int $id, array $data);

}
