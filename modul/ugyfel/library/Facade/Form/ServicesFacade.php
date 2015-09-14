<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;

use ArrayObject;
use Uniweb\Library\Cache\CacheInterface;
use Uniweb\Library\Form\Interfaces\AssignableInterface;
use Uniweb\Module\Szolgaltatas\Model\ActiveRecord\Service;

/**
 * Description of ServicesFacade
 *
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ServicesFacade implements AssignableInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;
    
    /**
     * @var int
     */
    private $cacheLifeTime;
    
    public function __construct(CacheInterface $cache, $cacheLifeTime)
    {
        $this->cache = $cache;
        $this->setCacheLifeTime($cacheLifeTime);
    }
    
    /**
     * {@inheritdoc}
     */
    public function assign(ArrayObject $data)
    {
        $services = $this->cache->remember('szolgaltatasServices', function() {
            return Service::all(array(
                'conditions' => array(
                    'szolgaltatas_torolt' => 0,
                    'szolgaltatas_tipus' => Service::TYPE_CLIENT,
                )
            ));
        }, $this->cacheLifeTime);
        
        $data->offsetSet('szolgaltatasServices', $services);
    }
    
    /**
     * Visszatér a cache objektummal.
     * 
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }
    
    /**
     * Visszatér a cache élettartamával.
     * 
     * @return int
     */
    public function getCacheLifeTime()
    {
        return $this->cacheLifeTime;
    }
    
    /**
     * Beállítja a cache objektumot.
     * 
     * @param CacheInterface $cache Cache objektum.
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
    
    /**
     * Beállítja a cache élettartamát.
     * 
     * @param int $cacheLifeTime A cache élettartama.
     */
    public function setCacheLifeTime($cacheLifeTime)
    {
        $this->cacheLifeTime = (int)$cacheLifeTime;
    }
}
