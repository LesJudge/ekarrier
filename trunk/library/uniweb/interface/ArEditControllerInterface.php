<?php

interface ArEditControllerInterface
{
    /**
     * Beállítja a validálásért felelős resource subject objektumot.
     * @param \ValidateResourceSubject $vrs Validálásért felelős resource subject objektum.
     * @return void
     */
    public function setValidateResourceSubject(\ValidateResourceSubject $vrs);
    /**
     * Beállítja a mentésért felelő resource subject objektumot.
     * @param \SaveResourceSubject $srs Mentésért felelős resource subject objektum.
     * @return void
     */
    public function setSaveResourceSubject(\SaveResourceSubject $srs);
    /**
     * Beállítja az erőforrás objektumot.
     * @param \ResourceInterface $resource Erőforrás objektum.
     * @return void
     */
    public function setResource(\ResourceInterface $resource);
    /**
     * Előkészíti a controllert.
     * @return void
     */
    public function init();
    /**
     * Controller inicializálása során fellépő hiba kezelése.
     * @return void
     */
    public function initError(\Exception $e);
    /**
     * Ha a mentés sikeres (pl. flash beállítás, átirányítás).
     * @return void
     */
    public function success();
    /**
     * Ha a mentés sikertelen (pl. adatok visszatöltése a formba).
     * @return void
     */
    public function fail();
    /**
     * Visszatér az erőforrás objektummal.
     * @return \ResourceInterface Erőforrás objektum.
     */
    public function getResource();
}