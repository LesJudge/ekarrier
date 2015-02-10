<?php
/**
 * Automatikusan frissíti a rekord módosításainak számát.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ArNomBehavior extends ArBehavior
{
    /**
     * Módosítások számát tároló mező neve.
     * @var string
     */
    protected $nomAttribute;
    /**
     * Új rekord felvitele előtt lefutó metódus.
     * @return void
     */
    public function before_create()
    {
        if (!is_null($this->getNomAttribute())) {
            $this->owner->assign_attribute($this->getNomAttribute(), 0);
        }
    }
    /**
     * Rekord módosítása előtt lefutó metódus.
     * @return void
     */
    public function before_update()
    {
        if (!is_null($this->getNomAttribute())) {
            $this->owner->assign_attribute($this->getNomAttribute(), $this->getNom() + 1);
        }
    }
    /**
     * Visszatér a rekord módosításának számával.
     * @return mixed
     */
    public function getNom()
    {
        return $this->owner->read_attribute($this->getNomAttribute());
    }
    /**
     * Visszatér a módosítás számát tároló mező nevével.
     * @return string
     */
    public function getNomAttribute()
    {
        return $this->nomAttribute;
    }

}
