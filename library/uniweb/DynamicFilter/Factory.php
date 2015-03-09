<?php
namespace Uniweb\Library\DynamicFilter;
use Uniweb\Library\DynamicFilter\Interfaces\FactoryInterface;
use Uniweb\Library\DynamicFilter\Exceptions\FactoryException;
use ReflectionClass;
use PDO;

class Factory implements FactoryInterface
{
    /**
     * @var PDO
     */
    protected $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function factory($type, array $settings = array())
    {
        if (class_exists($type)) {
            $reflector = new ReflectionClass($type);
            if ($reflector->implementsInterface('\\Uniweb\\Library\\DynamicFilter\\Interfaces\\FilterInterface')) {
                /* @var $filter \Uniweb\Library\DynamicFilter\Interfaces\FilterInterface */
                $filter = $reflector->newInstanceWithoutConstructor();
                $filter->setPdo($this->pdo);
                foreach ($settings as $key => $value) {
                    $method = 'set' . ucfirst($key);
                    if ($reflector->hasMethod($method)) {
                        $reflector->getMethod($method)->invoke($filter, $value);
                    }
                }
                return $filter;
            } else {
                throw new FactoryException('A szűrő létrehozása sikertelen volt, mert a típusa nem megfelelő!');
            }
        }
        throw new FactoryException('A szűrő létrehozása sikertelen volt!');
    }
    /**
     * Visszatér a PDO objektummal.
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }
    /**
     * Beállítja a PDO objektumot.
     * @param PDO $pdo PDO objektum.
     * @return self
     */
    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }
}