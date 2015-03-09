<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Relation;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Reader;
use Uniweb\Library\Utilities\ActiveRecord\Exceptions\RelationFixerException;
use ActiveRecord\Model;
use ActiveRecord\AbstractRelationship;
/**
 * AR Model kapcsolat fixáló osztály.
 * 
 * A kapott collection alapján "fixálja" az objektum kapcsolódó objektumait.
 */
class Fixer
{
    /**
     * @var \ActiveRecord\Model
     */
    protected $model;
    /**
     * @param Model $model A model, aminek a kapcsolatait fixálni kell.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * Kapcsolatok "fixálása".
     * @param Model[] $fixFrom
     */
    public function fix(array $fixFrom = array())
    {
        $reader = new Reader($this->model);
        $relationships = $reader->read();
        if (!empty($relationships)) {
            foreach ($relationships as $relationship) {
                if ($relationship->is_poly()) {
                    $this->setRelationshipForPoly($relationship, $fixFrom);
                } else {
                    $this->setRelationshipForSingle($relationship, $fixFrom);
                }
            }
        }
    }
    /**
     * Megvizsgálja, hogy az objektum típusa megfelelő-e, hozzá lehet-e rendelni a kapcsolathoz.
     * @param mixed $model Az objektum, ami a kapcsolathoz lesz rendelve.
     * @param AbstractRelationship $relationship Kapcsolat objektum.
     * @return boolean
     */
    protected function checkInstance($model, AbstractRelationship $relationship)
    {
        return is_object($model) && $model instanceof $relationship->class_name;
    }
    /**
     * Hozzárendeli a kapcsolódó objektumokat ahhoz a kapcsolathoz, amelyhez több objektum is társulhat.
     * @param AbstractRelationship $relationship Kapcsolat objektum.
     * @param Model[] $fixFrom A kapcsolódó objektumokat tartalmazó tömb.
     * @throws RelationFixerException
     */
    protected function setRelationshipForPoly(AbstractRelationship $relationship, $fixFrom)
    {
        if (isset($fixFrom[$relationship->attribute_name])) {
            $models = $fixFrom[$relationship->attribute_name];
            if (is_array($models)) {
                foreach ($models as $model) {
                    if ($this->checkInstance($model, $relationship)) {
                        $this->model->set_relationship_from_eager_load($model, $relationship->attribute_name);
                    } else {
                        throw new RelationFixerException('A kapcsolódó objektum típusa nem megfelelő!');
                    }
                }
            } else {
                throw new RelationFixerException('A kapcsolat nem object collection-t kapott értékül!');
            }
        } else {
            $this->model->set_relationship_from_eager_load(null, $relationship->attribute_name);
        }
    }
    /**
     * Hozzárendeli a kapcsolódó objektumot ahhoz a kapcsolathoz, amelyhez csak egy objektum társulhat.
     * @param AbstractRelationship $relationship Kapcsolat objektum.
     * @param Model[] $fixFrom Kapcsolódó objektumokat tartalmazó tömb.
     * @throws RelationFixerException
     */
    protected function setRelationshipForSingle(AbstractRelationship $relationship, $fixFrom)
    {
        if (isset($fixFrom[$relationship->attribute_name])) {
            $model = $fixFrom[$relationship->attribute_name];
            if (!$this->checkInstance($model, $relationship)) {
                throw new RelationFixerException('A kapcsolódó objektum típusa nem megfelelő!');
            }
        } else {
            $model = new $relationship->class_name;
        }
        $this->model->set_relationship_from_eager_load($model, $relationship->attribute_name);
    }
    /**
     * Visszatér a modellel.
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Beállítja a modelt.
     * @param Model $model Model objektum.
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }
}