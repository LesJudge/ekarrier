<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\AbstractBehavior;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;
use Uniweb\Library\Validator\NaturalNumber;
/**
 * Automatikusan frissíti a rekord módosításainak számát.
 * 
 * @property \ActiveRecord\Model $owner Tulajdonos
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class NumberOfModifications extends AbstractBehavior
{
    /**
     * Módosítások számát tároló mező neve.
     * @var string
     */
    protected $nomAttribute;
    
    public function __construct($nomAttribute)
    {
        $this->nomAttribute = $nomAttribute;
    }
    /**
     * Visszatér a módosítás számával.
     * @return int
     */
    public function get_modositas_szama()
    {
        return $this->owner->read_attribute($this->nomAttribute);
    }
    /**
     * Beállítja a módosítás számát.
     * @param int $modositas_szama Módosítás száma
     */
    public function set_modositas_szama($modositas_szama)
    {
        $assign = new WithoutCast;
        $assign->assignAttribute($this->nomAttribute, $modositas_szama, $this->owner);
    }
    /**
     * Új rekord felvitele előtt lefutó metódus.
     * @return void
     */
    public function before_create()
    {
        if (!$this->owner->attribute_is_dirty($this->nomAttribute)) {
            $this->set_modositas_szama(0);
        }
    }
    /**
     * Rekord módosítása előtt lefutó metódus.
     * @return void
     */
    public function before_update()
    {
        if (!$this->owner->attribute_is_dirty($this->nomAttribute)) {
            $this->set_modositas_szama($this->get_modositas_szama() + 1);
        }
    }
    /**
     * Validálja a modelt.
     */
    public function validate()
    {
        $nom = $this->get_modositas_szama();
        $naturalNumber = new NaturalNumber;
        $naturalNumber->setZeroIsNatural(true);
        if (!is_null($nom) && !$naturalNumber->validate($nom)) {
            $this->owner->errors->add($this->nomAttribute, 'A módosítás száma nem megfelelő!');
        }
    }
    /**
     * Visszatér a módosítás számát tároló mező nevével.
     * @return string
     */
    public function getNomAttribute()
    {
        return $this->nomAttribute;
    }
    /**
     * Beállítja a módosítás számát tároló attribútum nevét.
     * @param string $nomAttribute Módosítás számát tároló attribútum neve.
     */
    public function setNomAttribute($nomAttribute)
    {
        $this->nomAttribute = $nomAttribute;
    }
}