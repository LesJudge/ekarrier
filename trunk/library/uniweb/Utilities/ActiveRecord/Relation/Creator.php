<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Relation;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Reader;
use ActiveRecord\Model;
use ActiveRecord\AbstractRelationship;
/**
 * Előkészíti az AR model kapcsolódó objektumait a megadott paraméterek alapján. 
 * 
 * Ez az osztály leginkább akkor hasznos, ha egy új objektum kapcsolataira szeretnénk hivatkozni, azok ugyanis ezek 
 * új példány esetében nem léteznek. (Csak abban az esetben inicializálódnak a kapcsolat objektumok, ha find()-dal 
 * hoztuk létre a model objektumot!)
 * 
 * Rendkívül hasznos lehet abban az esetben, ha egyszerre több kapcsolatra van szükségünk, de nem szeretnénk 
 * mindegyiket "kézzel" létrehozni.
 */
class Creator
{
    /**
     * @var \ActiveRecord\Model
     */
    protected $model;
    /**
     * Azok a kapcsolatok az értékeikkel, amelyeket el kell készíteni.
     * @var array
     */
    protected $bePrepared;
    /**
     * @var \Uniweb\Library\Utilities\ActiveRecord\Interfaces\RelationCreatorInterface[]
     */
    protected $creators;
    /**
     * @param Model $model A model, ami alapján elkészülnek a kapcsolódó objektumok.
     * @param array $bePrepared Azokat a kapcsolatokat tartalmazó tömb, amelyeket létre kell hozni.
     * @param \Uniweb\Library\Utilities\ActiveRecord\Interfaces\RelationCreatorInterface[] $creators Kapcsolódó objektum létrehozót tartalmazó tömb.
     */
    public function __construct(Model $model, array $bePrepared, array $creators)
    {
        $this->model = $model;
        $this->bePrepared = $bePrepared;
        $this->creators = $creators;
    }
    /**
     * Elkészíti a kapcsolódó objektumokat.
     * @return \ActiveRecord\Model[]
     */
    public function create()
    {
        $related = array();
        $reader = new Reader($this->model);
        $relations = $reader->read();
        foreach ($relations as $name => $relation) {
            if ($this->mustPrepare($name)) {
                $related[$name] = $this->prepare($relation);
            }
        }
        return $related;
    }
    /**
     * A kapcsolat objektum alapján elkészíti a kapcsolódó objektumot/objektumokat.
     * @param AbstractRelationship $relationship Kapcsolat objektum.
     * @return \ActiveRecord\Model|\ActiveRecord\Model[]
     */
    protected function prepare(AbstractRelationship $relationship)
    {
        $name = $relationship->attribute_name;
        if (isset($this->creators[$name])) {
            $data = $this->bePrepared[$name];
            $related = array();
            if ($relationship->is_poly()) {
                foreach ($data as $item) {
                    $related[] = $this->createModel($relationship, $item);
                }
            } else {
                $related = $this->createModel($relationship, $data);
            }
            return $related;
        }
    }
    /**
     * A kapott kapcsolat objektum és adatok alapján elkészíti a kapcsolódó objektumot.
     * @param AbstractRelationship $relationship Kapcsolat objektum.
     * @param array $data Kapcsolódó objektum attribútum értékei.
     * @return \ActiveRecord\Model
     */
    protected function createModel(AbstractRelationship $relationship, $data)
    {
        $creator = $this->creators[$relationship->attribute_name];
        $creator->setModel(new $relationship->class_name);
        return $creator->create($data);
    }
    /**
     * Megvizsgálja, hogy el kell-e készítenie a kapcsolódó objektumot.
     * @param string $name Kapcsolat neve.
     * @return boolean
     */
    protected function mustPrepare($name)
    {
        return array_key_exists($name, $this->bePrepared);
    }
}