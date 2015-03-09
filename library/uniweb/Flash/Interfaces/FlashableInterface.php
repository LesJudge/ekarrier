<?php
namespace Uniweb\Library\Flash\Interfaces;
use Uniweb\Library\Flash\Interfaces\FlashInterface;

interface FlashableInterface
{
    /**
     * Visszatér a flash objektummal.
     * @return \Uniweb\Library\Flash\Interfaces\FlashInterface
     */
    public function getFlash();
    /**
     * Beállítja a Flash-t.
     * @param \Uniweb\Library\Flash\Interfaces\FlashInterface $flash Flash objektum.
     */
    public function setFlash(FlashInterface $flash);
}