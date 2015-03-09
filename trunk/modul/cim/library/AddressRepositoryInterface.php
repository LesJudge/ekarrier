<?php
namespace Uniweb\Module\Cim\Library;

interface AddressRepositoryInterface
{
    public function findAll();
    
    public function findById($id);
}