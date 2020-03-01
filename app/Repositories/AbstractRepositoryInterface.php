<?php

namespace App\Repositories;

interface  AbstractRepositoryInterface
{

    public function all($param);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function show($id);

    public function find($id);

    public function search($fieldName, $param);

    public function with(array $relations);

    public function getModel();

    public function setModel($model);
}
