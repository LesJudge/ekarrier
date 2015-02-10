<?php
/**
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ClientExporter implements \IteratorAggregate
{
    /**
     * SplObjectStorage objektum.
     * @var \SplObjectStorage
     */
    protected $clients;
    /**
     * Az exportálandó objektumoknak melyik osztályból kell származniuk.
     * @var string
     */
    protected $instanceClass = 'Client';
    /**
     * Tábla.
     * @var \ActiveRecord\Table
     */
    protected $table;
    /**
     * Melyik az a kulcs, amelynél az "alap" objektumot ($instanceClass) kell használnia.
     * @var mixed
     */
    protected $selfKey = 0;
    
    protected $header = array();
    
    public function __construct(array $clients, array $attributes)
    {
        if (class_exists($this->instanceClass)) {
            $this->clients = new \SplObjectStorage;
            foreach ($clients as $client) {
                $this->addClient($client);
            }
            $this->table = call_user_func(array($this->instanceClass, 'table'));
            $this->validateAttributes($attributes);
        } else {
            throw new \ClientExporterException('A/az (' . $this->instanceClass . ') osztály nem létezik!');
        }
    }
    /**
     * Megvizsgálja, hogy az attirúbumok megfelelően meg lettek-e adva.
     * @param array $attributes Attribútumokat tartalmazó tömb.
     * @throws \ClientExporterException
     */
    protected function validateAttributes(array $attributes)
    {
        try {
            $this->checkAttributes(new $this->table->class->name, $attributes);
            echo '<pre>', print_r($this->header, true), '</pre>';
        } catch (\ActiveRecord\RelationshipException $re) {
            throw new \ClientExporterException('Valamelyik kapcsolat nem létezik!');
        } catch (\ActiveRecord\UndefinedPropertyException $upe) {
            throw new \ClientExporterException('Valamelyik attribútum nem létezik!');
        }
    }
    
                //echo '<br />';
                //var_dump($k);
                //echo ' - ';
                //var_dump($v);
                //echo '<br />';
                //var_dump($data->getAttributeLabel($k));
                //var_dump($data);
                //echo '<br /><br />';
                //echo $k, ' - ', $v, '<br />', $data->{$k};    
    
    
    protected function checkAttributes(\ActiveRecord\Model $model, array $attributes)
    {
        foreach ($attributes as $k => $v) {
            $data = $k === $this->selfKey ? $model : $this->checkWhatIsThis($model, $k, $v);
            if (is_array($v)) {
                //$this->header[$k] = array();
                //$this->header[$k][] = array();
                $this->checkAttributes($data, $v);
            } else {
                //$this->header[$k] = 'X';
            }
            
            //$this->header[$k] = 'X';
        }
    }
    /**
     * Eldönti, hogy az adott kulcs érték relációs objektum-e vagy attribútum.
     * @param \ActiveRecord\Model $model
     * @param mixed $key
     * @param mixed $value
     * @return \ActiveRecord\Model
     */
    protected function checkWhatIsThis(\ActiveRecord\Model $model, $key, $value)
    {
        if (is_array($value)) {
            $class = $model->table()->get_relationship($key, true)->class_name;
            //$this->header[$key] = $key;
            return new $class;
        } else {
            $model->read_attribute($key);
            return $model;
        }
    }
    
    protected function getPath($attributes)
    {
        foreach ($attributes as $k => $v) {
            echo $k, '<br />';
            if ($k === 0) {
                $data = &$client;
            } else {
                $data = &$client->{$k};
            }
            if (is_array($v)) {
                $this->getPath($data, $v);
            } else {
                var_dump($data);
                echo '<br />';
                //echo $k, ' - ', $v, '<br />', $data->{$k};
            }
            /*
            if (is_array($v)) {
                echo $k, '->';
                $this->getPath($v);
            } else {
                echo $k, '<br />';
            }
            */
        }
    }
    
    public function export()
    {
        $clients = array();
        //foreach ($this->clients as $client) {
        //    
        //}
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott ügyfél objektum létezik-e az exportálandó ügyfél objektumok között.
     * Nem megfelelő érték esetén <b>ClientExporterException</b>-t dob!
     * @param mixed $client Ügyfél objektum.
     * @return boolean
     * @throws \ClientExporterException
     */
    public function hasClient($client)
    {
        if ($this->isValidClientInstance($client)) {
            return $this->clients->contains($client);
        } else {
            throw new \ClientExporterException('Nem megfelelő ügyfél objektum!');
        }
    }
    /**
     * Hozzáadja az ügyfél objektumot az exportálandó ügyfél objektumokhoz, ha az még nem tartozik hozzá. Ha igen, 
     * akkor <b>ClientExporterException</b>-t dob!
     * @param mixed $client Ügyfél objektum.
     * @throws \ClientExporterException
     */
    public function addClient($client)
    {
        if (!$this->hasClient($client)) {
            $this->clients->attach($client);
        } else {
            throw new \ClientExporterException('Az ügyfél már hozzá lett rendelve az exporthoz!');
        }
    }
    /**
     * Törli az ügyfél objektumot az exportálandó objektumok közül, ha az létezik. Ha nem, akkor kivételt dob.
     * @param mixed $client Ügyfél objektum.
     * @throws \ClientExporterException
     */
    public function removeClient($client)
    {
        if ($this->hasClient($client)) {
            $this->clients->detach($client);
        } else {
            throw new \ClientExporterException('Az ügyfél nem lett hozzárendelve az exporthoz!');
        }
    }
    /**
     * Megvizsgálja, hogy az ügyfél objektum megfelelő-e.
     * @param mixed $client Ügyfél objektum.
     * @return boolean
     */
    protected function isValidClientInstance($client)
    {
        return is_object($client) && is_a($client, $this->instanceClass);
    }
    
    public function getIterator()
    {
        return $this->clients;
    }
}