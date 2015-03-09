<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Interfaces;
use ActiveRecord\Model;

interface RelationCreatorInterface
{
    public function create($data);
    
    public function getModel();
    
    public function setModel(Model $model);
}