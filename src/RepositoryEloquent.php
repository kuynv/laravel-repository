<?php
namespace Qnv\Repository;

abstract class RepositoryEloquent implements RepositoryInterface{
    /**
     * @return mixed
     */
    abstract public function getModel();

    public function view($id)
    {
        // TODO: Implement view() method.
        return $this->getModel()->find($id);
    }

    public function getOne(array $filters = [])
    {
        // TODO: Implement getOne() method.
        $model = $this->getModel();
        $this->buildFilters($filters,$model);
        return $model->first();
    }

    public function get(array $filters = [],array $with = [])
    {
        // TODO: Implement store() method.
        $model = $this->getModel();
        if(count($with)>0){
            $model = $model->with($with);
        }
        $this->buildFilters($filters,$model);
        if(isset($filters['limit'])){
            return $model->paginate($filters['limit']);
        }
        return $model->get();
    }

    public function store($data = [])
    {
        // TODO: Implement create() method.
        $model = $this->getModel();
        return $model->create($data);
    }

    public function update($filters = [], $data = [])
    {
        // TODO: Implement update() method.
        $model = $this->getModel();
        $this->buildFilters($filters,$model);
        return $model->update($data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        $model = $this->getModel();
        return $model->where('id',$id)->delete();
    }

    abstract public function buildFilters($filters, &$query);
}
