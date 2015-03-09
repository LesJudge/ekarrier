<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\AbstractBehavior;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Validator\ForeignKey;
use UserLoginOut_Controller;
/**
 * A szerző behavior használatával automatikusan frissül a létrehozó és módosító felhasználó azonosítót tároló mező 
 * értéke, vagy valamelyiké a kettő közül. Ez attól függ, hogyan csatoljuk a behavior-t a modelhez. A használni nem 
 * kívánt mező nevét ne állítsuk be konfigba, vagy kapjon null értéket. Ennek hatására figyelmen kívül hagyja a mezőt.
 * 
 * <b>Példa:</b>
 * <code>
 * $author1 = new Author('letrehozo_id', 'modosito_id'); // Mindkét attribútum elérhető.<br />
 * $author2 = new Author('letrehozo_id', null); // Csak a létrehozó attribútum elérhető.<br />
 * $author3 = new Author(null, 'modosito_id'); // Csak a módosító attribútum elérhető.<br />
 * </code>
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Author extends AbstractBehavior
{
    /**
     * A létrehozó azonosítóját tároló mező neve.
     * @var null|string
     */
    protected $creatorAttribute = null;
    /**
     * A módosító azonosítóját tároló mező neve.
     * @var null|string
     */
    protected $modificatoryAttribute = null;
    /**
     * Szerző viselkedés példányosítása. Ha valamelyik attribútumra nincs szükséged, mert pl. a modelben nem található 
     * meg, akkor annak az attribútumnak adj null értéket, ennek hatására figyelmen kívül hagyja azt.
     * 
     * @param null|string $creatorAttribute Létrehozó felhasználó azonosítóját tároló mező neve.
     * @param null|string $modificatoryAttribute Módosító felhasználó azonosítóját tároló mező neve.
     */
    public function __construct($creatorAttribute, $modificatoryAttribute)
    {
        $this->creatorAttribute = $creatorAttribute;
        $this->modificatoryAttribute = $modificatoryAttribute;
    }
    /**
     * Rekord létrehozása előtt lefutó metódus.
     */
    public function before_create()
    {
        if (!is_null($this->creatorAttribute) && !$this->owner->attribute_is_dirty($this->creatorAttribute)) {
            $this->set_letrehozo_id($this->getUserId());
        }
        if (!is_null($this->modificatoryAttribute) && !$this->owner->attribute_is_dirty($this->modificatoryAttribute)) {
            $this->set_modosito_id($this->getUserId());
        }
    }
    /**
     * Rekord módosítása előtt lefutó metódus.
     */
    public function before_update()
    {
        if (!is_null($this->modificatoryAttribute) && !$this->owner->attribute_is_dirty($this->modificatoryAttribute)) {
            $this->set_modosito_id($this->getUserId());
        }
    }
    
    public function validate()
    {
        $fkValidator = new ForeignKey(false);
        if (!is_null($this->creatorAttribute)) {
            $creatorId = $this->get_letrehozo_id();
            if (!is_null($creatorId) && !$fkValidator->validate($creatorId)) {
                $this->owner->errors->add(
                    $this->creatorAttribute, 'A létrehozó felhasználó azonosítója nem megfelelő!'
                );
            }
        }
        if (!is_null($this->modificatoryAttribute)) {
            $modificatoryId = $this->get_modosito_id();
            if (!is_null($modificatoryId) && !$fkValidator->validate($modificatoryId)) {
                $this->owner->errors->add(
                    $this->modificatoryAttribute, 'A módosító felhasználó azonosítója nem megfelelő!'
                );
            }
        }
    }
    /**
     * Visszatér a létrehozó felhasználó attribútum értékével..
     * @return null|int
     */
    public function get_letrehozo_id()
    {
        return $this->getAuthorId($this->creatorAttribute);
    }
    /**
     * Visszatér a módosító felhasználó attribútum értékével.
     * @return null|int
     */
    public function get_modosito_id()
    {
        return $this->getAuthorId($this->modificatoryAttribute);
    }
    /**
     * Kiolvassa a szerző azonosítót.
     * @param null|string $attribute Attribútum neve.
     * @return null|int
     */
    protected function getAuthorId($attribute)
    {
        if (!is_null($attribute)) {
            return $this->owner->read_attribute($attribute);
        }
        throw new \ActiveRecord\UndefinedPropertyException(get_class($this->owner), 'author');
    }
    /**
     * Beállítja a létrehozó felhasználó azonosítóját.
     * @param int $letrehozo_id Létrehozó felhasználó azonosítója.
     */
    public function set_letrehozo_id($letrehozo_id)
    {
        $this->setAuthorId($this->creatorAttribute, $letrehozo_id);
    }
    /**
     * Beállítja a módosító felhasználó azonosítóját.
     * @param int $modosito_id Módosító felhasználó azonosítója.
     */
    public function set_modosito_id($modosito_id)
    {
        $this->setAuthorId($this->modificatoryAttribute, $modosito_id);
    }
    /**
     * Beállítja a szerző azonosítót.
     * @param null|string $attribute Attribútum neve.
     * @param int $authorId Felhasználó azonosító.
     * @throws \ActiveRecord\UndefinedPropertyException
     */
    protected function setAuthorId($attribute, $authorId)
    {
        if (!is_null($attribute)) {
            $assign = new WithoutCast;
            $assign->assignAttribute($attribute, $authorId, $this->owner);
        } else {
            throw new \ActiveRecord\UndefinedPropertyException(get_class($this->owner), 'author');
        }
    }
    /**
     * Visszatér a létrehozó azonosítóját tároló mező nevével.
     * @return null|string
     */
    public function getCreatorAttribute()
    {
        return $this->creatorAttribute;
    }
    /**
     * Visszatér a módosító azonosítóját tároló mező nevével.
     * @return null|string
     */
    public function getModificatoryAttribute()
    {
        return $this->modificatoryAttribute;
    }
    /**
     * Visszatér a felhasználó azonosítóval.
     * @return int
     */
    public function getUserId()
    {
        return UserLoginOut_Controller::$_id;
    }
    /**
     * Beállítja a létrehozó felhasználó azonosítóját tároló mező nevét.
     * @param string $creatorAttribute Mező neve.
     */
    public function setCreatorAttribute($creatorAttribute)
    {
        $this->creatorAttribute = $creatorAttribute;
    }
    /**
     * Beállítja a módosító felhasználó azonosítóját tároló mező nevét.
     * @param string $modificatoryAttribute Mező neve.
     */
    public function setModificatoryAttribute($modificatoryAttribute)
    {
        $this->modificatoryAttribute = $modificatoryAttribute;
    }
}