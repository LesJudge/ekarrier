<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;

use ArrayObject;
use Uniweb\Library\Cache\CacheInterface;
use Uniweb\Library\Form\Interfaces\AssignableInterface;
use Uniweb\Module\User\Model\ActiveRecord\User;

/**
 * Description of ConsultantsFacade
 *
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ConsultantsFacade implements AssignableInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;
    
    /**
     * Cache élettartama.
     * 
     * @var int
     */
    private $cacheLifetime;
    
    public function __construct(CacheInterface $cache, $cacheLifetime = 900)
    {
        $this->cache = $cache;
        $this->setCacheLifetime($cacheLifetime);
    }
    
    public function assign(ArrayObject $data)
    {
        $constultants = User::all(array(
            'user_aktiv' => 1,
            'user_torolt' => 0,
            'tanacsado' => 1
        ));
        
        $data->offsetSet('consultants', $constultants);
    }
    
    public function setCacheLifetime($cacheLifetime)
    {
        $this->cacheLifetime = (int)$cacheLifetime;
    }
}
