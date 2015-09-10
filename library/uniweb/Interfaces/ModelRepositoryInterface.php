<?php
namespace Uniweb\Library\Interfaces;

use Uniweb\Library\Interfaces\RepositoryInterface;

interface ModelRepositoryInterface extends RepositoryInterface
{
    public function getModel();
}