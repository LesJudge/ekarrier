<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\AbstractCreator;
use Uniweb\Library\Utilities\ActiveRecord\Exceptions\RelationCreatorException as CreatorException;
/**
 * Általános kapcsolódó objektum létrehozó osztály.
 * 
 * Ha az elsődleges kulcs megtalálható a paraméterül adott adatok között, akkor az alapján példányosítja a kapcsolódó 
 * objektumot, ha nem, akkor egy új példányt hoz létre.
 */
class CreateByData extends AbstractCreator
{
    /**
     * A paraméterül adott adatok alapján felparaméterezi az objektumot, majd visszatér vele.
     * @param mixed $data Adatok, ami szerint fel kell paramétereznie a kapcsolódó objektumot.
     * @return \ActiveRecord\Model
     * @throws CreatorException
     */
    public function create($data)
    {
        $pkName = $this->model->get_primary_key(true);
        if (array_key_exists($pkName, $data)) {
            $pkValue = (int)$data[$pkName];
            $model = $this->model;
            if ($pkValue > 0) {
                try {
                    $model = $this->model->find_by_pk($pkValue, array());
                } catch (\ActiveRecord\RecordNotFound $rnf) {
                    throw new CreatorException(
                        'A kapcsolat létrehozása sikertelen volt, mert a paraméterül adott adatok alapján '
                        . 'a rekord nem található!'
                    );
                }
            }
            foreach ($data as $attribute => $value) {
                $model->{$attribute} = $value;
            }
            return $model;
        } else {
            throw new CreatorException('A kapcsolat létrehozás sikertelen volt, mert hiányzik az elsődleges kulcs!');
        }
    }
}