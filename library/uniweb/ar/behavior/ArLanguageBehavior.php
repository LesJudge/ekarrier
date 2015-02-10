<?php
/**
 * Mentés során beállítja az éppen aktuális nyelv azonosítót. 
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ArLanguageBehavior extends ArBehavior
{
    /**
     * Nyelv azonosítót tároló mező neve.
     * @var string
     */
    protected $langIdAttribute;
    /**
     * Mentés előtt lefutó metódus.
     * @return void
     */
    public function before_save()
    {
        $this->owner->assign_attribute($this->getLangIdAttribute(), $this->getLangId());
    }
    /**
     * Visszatér az aktuális nyelv azonosítóval.
     * @return mixed
     */
    public function getLangId()
    {
        return Rimo::getConfig()->getItem('SITE_NYELV_ID');
    }
    /**
     * Visszatér a nyelv azonosítót tároló mező nevével.
     * @return string
     */
    public function getLangIdAttribute()
    {
        return $this->langIdAttribute;
    }
}
