<?php
/**
 * A szerző behavior használatával automatikusan frissül a létrehozó és módosító felhasználó azonosítót tároló mező 
 * értéke, vagy valamelyiké a kettő közül. Ez attól függ, hogyan csatoljuk a behavior-t a modelhez. A használni nem 
 * kívánt mező nevét ne állítsuk be konfigba, vagy kapjon null értéket. Ennek hatására figyelmen kívül hagyja a mezőt.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ArAuthorBehavior extends ArBehavior
{
    /**
     * A létrehozó azonosítóját tároló mező neve.
     * @var string
     */
    protected $creatorAttribute = null;
    /**
     * A módosító azonosítóját tároló mező neve.
     * @var string
     */
    protected $modificatoryAttribute = null;
    /**
     * Visszatér a létrehozó azonosítóját tároló mező nevével.
     * @return string
     */
    public function getCreatorAttribute()
    {
        return $this->creatorAttribute;
    }
    /**
     * Visszatér a módosító azonosítóját tároló mező nevével.
     * @return string
     */
    public function getModificatoryAttribute()
    {
        return $this->modificatoryAttribute;
    }
    /**
     * Rekord létrehozása előtt lefutó metódus.
     * @return void
     */
    public function before_create()
    {
        $this->setAuthorId($this->getCreatorAttribute());
        $this->setAuthorId($this->getModificatoryAttribute());
    }
    /**
     * Rekord módosítása előtt lefutó metódus.
     * @return void
     */
    public function before_update()
    {
        $this->setAuthorId($this->getModificatoryAttribute());
    }
    /**
     * Beállítja a paraméterül adott mező értékét, ha az nem null.
     * @param string $attribute
     * @return void
     */
    protected function setAuthorId($attribute)
    {
        if (!is_null($attribute)) {
            $this->owner->assign_attribute($attribute, $this->getUserId());
        }
    }
    /**
     * Visszatér a felhasználó azonosítóval.
     * @return int
     */
    public function getUserId()
    {
        return UserLoginOut_Controller::$_id;
    }
}
