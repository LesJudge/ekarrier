<?php
namespace Uniweb\Library\Flash\Interfaces;

interface FlashInterface
{
    /**
     * Megvizsgálja, hogy létezik-e a flash a paraméterül adott azonosítóval.
     * @param string $id A flash azonosítója.
     * @return boolean
     */
    public function hasFlash($id);
    /**
     * Törli a paraméterül adott flash-t.
     * @param string $id A flash azonosítója.
     * @return void
     */
    public function removeFlash($id);
    /**
     * Visszatér a paraméterül adott flash értékével, majd törli azt, ha a $remove paraméter értéke true.
     * @param string $id A flash azonosítója.
     * @param boolean $remove Törölje-e a flash-t.
     * @return mixed
     */
    public function getFlash($id, $remove = true);
    /**
     * Beállít egy flash-t a paraméterül adott értékekkel.
     * @param string $id A flash kulcsa.
     * @param mixed $value A flash értéke.
     * @param boolean $override Írja-e felül a flash értékét, ha az létezik.
     * @return void
     */
    public function setFlash($id, $value, $override = true);
    /**
     * Visszatér az azonosító kulccsal.
     * @return string
     */
    public function getKey();
    /**
     * Beállítja a Flash-eket tároló kulcsot.
     * @param string $key
     */
    public function setKey($key);
}