<?php
namespace Qnv\Repository;

interface RepositoryInterface{
    /**
     * get all rows by filters
     * @param mixed $id
     * @return array
     */
    public function view($id);

    /**
     * get all rows by filters
     * @param array $filters
     * @return array
     */
    public function getOne(array $filters);

    /**
     * get all rows by filters
     * @param array $filters
     * @return array
     */
    public function get(array $filters, array $with);

    /**
     * create new data
     * @param array $data
     * @return array
     */
    public function store($data = []);

    /**
     * update data by filters
     * @param array $filters
     * @param array $data
     * @return array
     */
    public function update($filters = [], $data = []);

    /**
     * delete data by id
     * @param mixed $id
     * @return array
     */
    public function delete($id);
}
