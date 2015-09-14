<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;

use ArrayObject;
use Uniweb\Library\Cache\CacheInterface;
use Uniweb\Library\Form\Interfaces\AssignableInterface;

class OptionsFacade implements AssignableInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;
    
    private $ttl = 900;
    
    public function __construct(CacheInterface $cache, $ttl = 900)
    {
        $this->cache = $cache;
        $this->setTtl($ttl);
    }
    
    public function assign(ArrayObject $data)
    {
        $models = array(
            'beallitasHovaErkezett' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\CameTo',
            'beallitasEducations' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\Education',
            'beallitasProgramInformation' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\ProgramInformation',
            'beallitasWorkSchedule' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\WorkSchedule',
            'beallitasClientStatus' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\ClientStatus',
            'nyelvtudasLanguages' => '\\Uniweb\\Module\\Nyelvtudas\\Model\\ActiveRecord\\Language',
            'nyelvtudasLevels' => '\\Uniweb\\Module\\Nyelvtudas\\Model\\ActiveRecord\\Level',
            'ugyfelAddressTypes' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\AddressType',
            'ugyfelEmploymentStatus' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\EmploymentStatus',
            'ugyfelJobCategory' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\JobCategory'
        );
        
        foreach ($models as $key => $model) {
            // Tábla neve.
            $tableName = call_user_func(array($model, 'table_name'));
            // Feltétel.
            $conditions = array('conditions' => array($tableName . '_aktiv' => 1, $tableName . '_torolt' => 0));
            // Tárolás cache-ben, hozzáadás az adatokhoz.
            $data->offsetSet($key, $this->cache->remember($key, function() use ($model, $conditions) {
                return call_user_func_array(array($model, 'find'), array('all', $conditions));
            }, $this->ttl));
        }
    }
    
    public function getCache()
    {
        return $this->cache;
    }
    
    public function getTtl()
    {
        return $this->ttl;
    }
    
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
    
    public function setTtl($ttl)
    {
        $this->ttl = (int)$ttl;
    }
}