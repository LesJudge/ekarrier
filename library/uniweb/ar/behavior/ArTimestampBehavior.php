<?php
/**
 * Az időbélyeg behavior használatával automatikusan frissül a létrehozás és módosítás idejét tároló mező értéke, 
 * vagy valamelyiké a kettő közül. Ez attól függ, hogyan csatoljuk a behavior-t a modelhez. A használni nem kívánt 
 * mező nevét ne állítsuk be konfigba, vagy kapjon null értéket. Ennek hatására figyelmen kívül hagyja a mezőt.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ArTimestampBehavior extends ArBehavior
{
    /**
     * A létrehozás idejét tároló mező neve.
     * @var string
     */
    protected $createdAttribute = null;
    /**
     * A módosítás idejét tároló mező neve.
     * @var string
     */
    protected $modifiedAttribute = null;
    /**
     * Visszatér a létrehozás idejét tároló mező nevével.
     * @return string
     */
    public function getCreatedAttribute()
    {
        return $this->createdAttribute;
    }
    /**
     * Visszatér a módosítás idejét tároló mező nevével.
     * @return string
     */
    public function getModifiedAttribute()
    {
        return $this->modifiedAttribute;
    }
    /**
     * Új rekord mentése előtt lefutó metódus.
     * @return void
     */
    public function before_create()
    {
        $this->setTimestamp($this->createdAttribute);
    }
    /**
     * Létező rekord módosítása előtt lefutó metódus.
     * @return void
     */
    public function before_update()
    {
        $this->setTimestamp($this->modifiedAttribute);
    }
    /**
     * Beállítja a paraméterül adott mező időbélyegét. (Csak akkor, ha a mező neve nem null!)
     * @param string $property
     * @return void
     */
    protected function setTimestamp($property)
    {
        if (!is_null($property)) {
            $this->owner->assign_attribute($property, date('Y-m-d H:i:s'));
        }
    }
    /**
     * Formázza a paraméterül adott timestamp mező értékét a megadott formátumra. Ha nincs értéke, akkor a paraméterül 
     * adott üzenettel tér vissza.
     * @param string $attribute Az attribútum neve, aminek az értékét formázni akarjuk.
     * @param string $format A formátum, ahogy visszavárjuk az adatot.
     * @param string $message A hibaüzenet, ami NULL érték esetén jelenik meg.
     * @return string
     * @throws ActiveRecord\UndefinedPropertyException
     */
    public function formatTimestamp($attribute, $format, $message = '')
    {
        if (($dt = $this->owner->read_attribute($attribute)) instanceof \ActiveRecord\DateTime) {
            return $dt->format($format);
        }
        return $message;
    }
    /**
     * Formázza a létrehozás timestamp-et tároló mező értékét a paraméterül adott formátumra.
     * @param string $format A formátum, ahogy visszavárjuk az adatot.
     * @param string $message A hibaüzenet, ami NULL érték esetén jelenik meg.
     * @return string
     */
    public function formatCreateTimestamp($format, $message = null)
    {
        return $this->formatTimestamp($this->createdAttribute, $format, $message);
    }
    /**
     * Formázza a módosítás timestamp-et tároló mező értékét a paraméterül adott formátumra.
     * @param string $format A formátum, ahogy visszavárjuk az adatot.
     * @param string $message A hibaüzenet, ami NULL érték esetén jelenik meg.
     * @return string
     */
    public function formatModifiedTimestamp($format, $message)
    {
        return $this->formatTimestamp($this->modifiedAttribute, $format, $message);
    }
}
