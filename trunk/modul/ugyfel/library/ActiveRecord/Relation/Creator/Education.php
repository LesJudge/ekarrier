<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;

class Education extends CreateByData
{
    public function create($data)
    {
        /* @var $education \Uniweb\Module\Ugyfel\Model\ActiveRecord\Education */
        $education = parent::create($data);
        $education->ugyfel_attr_vegzettseg_torolt = 0;
        return $education;
    }
}