<?php
namespace Uniweb\Library\Flash;

use Uniweb\Library\Flash\Interfaces\FlashInterface;

/**
 * Flash kezelő osztály.
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Flash implements FlashInterface
{
    /**
     * Flash üzeneteket tároló tömb.
     * @var array 
     */
    private $flashes;
    
    /**
     * Flash üzeneteket tároló tömb kulcsa. (Ha örököltetjük az osztályt, a kulcs felülírásával az üzenetek más index
     * alá kerülhetnek.)
     * @var string
     */
    private $key = 'flashes';
    
    /**
     * Konstruktor.
     * @param array $flashes Flash-eket tároló tömb. (Leginkább $_SESSION szuperglobális. :))
     * @param string $key Kulcs a flash-eket tároló tömbben.
     */
    public function __construct(array &$flashes, $key = null)
    {
        if (is_string($key)) {
            $this->setKey($key);
        }
        if (!isset($flashes[$this->key])) {
            $flashes[$this->key] = array();
        }
        $this->flashes = &$flashes[$this->key];
    }
    
    /**
     * Megvizsgálja, hogy létezik-e a paraméterül adott flash.
     * @param string $id A flash azonosítója.
     * @return boolean
     */
    public function hasFlash($id)
    {
        return isset($this->flashes[$id]);
    }
    
    /**
     * Törli a paraméterül adott flash-t.
     * @param string $id A flash azonosítója.
     */
    public function removeFlash($id)
    {
        if ($this->hasFlash($id)) {
            unset($this->flashes[$id]);
        }
    }
    
    /**
     * Megvizsgálja a flash kulcs értékét. Ha megfelelő, true-val tér vissza, ha nem, akkor pedig kivételt dob.
     * @param string $id A flash kulcsa.
     * @return boolean
     */
    private function validateFlashId($id)
    {
        return is_string($id) && preg_match('/^[a-zA-Z0-9]*$/', $id);
    }
    
    /**
     * Visszatér a paraméterül adott flash értékével, majd törli azt, ha a $remove paraméter értéke true.
     * @param string $id A flash azonosítója.
     * @param boolean $remove Törölje-e a flash-t.
     * @return mixed
     */
    public function getFlash($id, $remove = true)
    {
        if ($this->hasFlash($id)) {
            $flash = $this->flashes[$id];
            if ($remove === true) {
                $this->removeFlash($id);
            }
            return $flash;
        } else {
            return null;
        }
    }
    
    /**
     * Beállít egy flash-t a paraméterül adott értékekkel.
     * @param string $id A flash kulcsa.
     * @param mixed $value A flash értéke.
     * @param boolean $override Írja-e felül a flash értékét, ha az létezik.
     */
    public function setFlash($id, $value, $override = true)
    {
        if ($this->validateFlashId($id)) {
            if (!$this->hasFlash($id) || $override === true) {
                $this->flashes[$id] = $value;
            }
        }
    }
    
    /**
     * Visszatér az azonosító kulccsal.
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
    
    /**
     * Beállítja a Flash-eket tároló kulcsot.
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
}