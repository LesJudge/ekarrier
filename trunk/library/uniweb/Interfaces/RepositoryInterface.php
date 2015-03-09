<?php
namespace Uniweb\Library\Interfaces;

interface RepositoryInterface
{
    public function create($attributes, $validate = true);
    
    public function update($options);
    
    public function find($options = array());
    
    public function findById($id, $options = array());
    
    public function delete($options);
}