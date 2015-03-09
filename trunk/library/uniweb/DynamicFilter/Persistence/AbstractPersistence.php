<?php
namespace Uniweb\Library\DynamicFilter\Persistence;
use Uniweb\Library\DynamicFilter\Interfaces\PersistenceInterface;

abstract class AbstractPersistence implements PersistenceInterface
{
    /**
     * Session
     * @var array
     */
    protected $session;
    
    public function __construct(array &$session)
    {
        $this->session = &$session;
    }
    
    public function getSession()
    {
        return $this->session;
    }
}