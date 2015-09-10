<?php
namespace Uniweb\Library\Mvc\Controller;

use Slim\Slim;

abstract class SlimBasedController
{
    /**
     * @var Slim
     */
    protected $slim;
    
    /**
     * Megállítja az alkalmazást.
     */
    protected function stop()
    {
        $this->slim->hook('slim.after', function() {
            exit;
        });
    }
    
    /**
     * Visszatér a Slim objektummal.
     * @return Slim
     */
    public function getSlim()
    {
        return $this->slim;
    }
    
    /**
     * Beállítja a Slim objektumot.
     * @param Slim $slim Slim objektum.
     * @return self
     */
    public function setSlim(Slim $slim)
    {
        $this->slim = $slim;
        return $this;
    }
}
