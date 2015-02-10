<?php
/**
 * Dinamikus szűrő kezelő model. 
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
abstract class DynamicFiltersModel extends Admin_List_Model
{
    const REMOVE_DF_BOTH = 'both';
    const REMOVE_DF_ITEM = 'item';
    const REMOVE_DF_SESSION = 'session';
    const OP_INT_LESS_THAN = '<';
    const OP_INT_LESS_THAN_OR_EQUAL = '<=';
    const OP_INT_EQUAL = '=';
    const OP_INT_GREATER_THAN = '>';
    const OP_INT_GREATER_THAN_OR_EQUAL = '>=';
    const OP_LIKE_EQUAL = '{value}';
    const OP_LIKE_PRE = '{value}%';
    const OP_LIKE_ANYWHERE = '%{value}%';
    const OP_LIKE_POST = '%{value}';
    const OP_SQL_BETWEEN = 'BETWEEN';
    /** @var string $sessionKey */
    protected $sessionKey = null;
    /** @var array $sessions */
    protected $sessions = null;
    /**
     * Visszatér a modelhez tartozó dinamikus filterek prefixével.
     * @return string
     */
    abstract public function dynamicFiltersPrefix();
    /**
     * Konstruktor.
     * @param string $sessionKey Session kulcs értéke. A controller nevével kell megegyeznie.
     */
    public function __construct($sessionKey)
    {
        parent::__construct();
        $this->setSessionKey($sessionKey);
        $this->setSessions();
    }
    /**
     * Hozzáad egy dinamikus szűrőt a modelhez.
     * @param string $name A dinamikus szűrő neve.
     * @param boolean $override Írja-e felül a már létező dinamikus szűrőt.
     * @return \Item
     * @throws \RuntimeException
     */
    protected function addDynamicFilter($name, $override = false)
    {
        $key = $this->createKey($name);
        if (!$this->hasDynamicFilter($name) || $override === true) {
            return $this->_params[$key] = new Item($key);
        } else {
            throw new RuntimeException('A paraméterül adott dinamikus szűrő (' . $key . ') már létezik!');
        }
    }
    /**
     * Törli a paraméterül adott dinamikus szűrőt.
     * @param string $name Dinamikus szűrő neve.
     * @param string $mode Törlés módja. (DynamicFiltersModel::REMOVE_DF_ITEM)
     * @return void
     * @throws \RuntimeException
     */
    protected function removeDynamicFilter($name, $mode = self::REMOVE_DF_ITEM)
    {
        if ($this->hasDynamicFilter($name) && ($mode === self::REMOVE_DF_ITEM || $mode === self::REMOVE_DF_BOTH)) {
            $this->removeDynamicFilterObject($name);
        }
        if ($this->hasDynamicFilterSession($name) && (
                $mode === self::REMOVE_DF_SESSION
                ||
                $mode === self::REMOVE_DF_BOTH
        )) {
            $this->removeDynamicFilterSession($name, false);
        }
    }
    /**
     * Törli a dinamikus szűrőt a $_params tömbből.
     * @param string $name Dinamikus szűrő neve.
     * @param boolean $validate Vizsgálja-e az elem létezését.
     * @return void
     * @throws \OutOfRangeException
     */
    protected function removeDynamicFilterObject($name, $validate = true)
    {
        if ($this->hasDynamicFilter($name) || $validate === false) {
            unset($this->_params[$this->createKey($name)]);
        } else {
            throw new OutOfRangeException('A (' . $name . ') dinamikus szűrő objektum törlése sikertelen!');
        }
    }
    /**
     * Törli a dinamikus szűrőt a $_SESSION tömbből.
     * @param string $name Dinamikus szűrő neve.
     * @param boolean $validate Vizsgálja-e az elem létezését.
     * @return void
     * @throws \OutOfRangeException
     */
    protected function removeDynamicFilterSession($name, $validate = true)
    {
        if ($this->hasDynamicFilterSession($name) || $validate === false) {
            unset($this->sessions[$this->createKey($name)]);
        } else {
            throw new OutOfRangeException('A (' . $name . ') dinamikus szűrő munkamenet törlése sikertelen!');
        }
    }
    /**
     * Megvizsgálja, hogy a dinamikus szűrő létezik-e.
     * @param string $name A dinamikus szűrő neve.
     * @return boolean
     */
    public function hasDynamicFilter($name)
    {
        return isset($this->_params[$this->createKey($name)]);
    }
    /**
     * Megvizsgálja, hogy a dinamikus szűrő létezik-e a $_SESSION tömbben.
     * @param string $name Dinamikus szűrő neve.
     * @return boolean
     */
    public function hasDynamicFilterSession($name)
    {
        return isset($this->sessions[$this->createKey($name)]);
    }
    /**
     * Visszatér a dinamikus szűrővel.
     * @param string $name A dinamikus szűrő neve.
     * @return \Item
     * @throws \OutOfRangeException
     */
    public function getDynamicFilter($name)
    {
        if ($this->hasDynamicFilter($name)) {
            return $this->_params[$this->createKey($name)];
        } else {
            throw new OutOfRangeException('A paraméterül adott dinamikus szűrő (' . $name . ') nem létezik!');
        }
    }
    /**
     * Visszatér a dinamikus szűrőkkel.
     * @return array
     */
    public function getDynamicFilters()
    {
        $filters = array();
        $params = $this->_params;
        foreach ($params as $item) {
            if ($item instanceof Item && $this->isDynamicFilterObject($item)) {
                $filters[] = $item;
            }
        }
        return $filters;
    }
    /**
     * Megvizsgálja, hogy az Item objektum dinamikus szűrő-e.
     * @param \Item $item Item objektum, amit vizsgálni fog.
     * @return boolean
     */
    public function isDynamicFilterObject(\Item $item)
    {
        return $this->isDynamicFilter($item->_name);
    }
    /**
     * Megvizsgálja, hogy a kulcs dinamikus szűrőhöz tartozik-e.
     * @param string $name Kulcs.
     * @return boolean
     */
    public function isDynamicFilter($name)
    {
        return strpos($name, $this->dynamicFiltersPrefix()) !== false;
    }
    
    public function isActive($filter)
    {
        return isset($this->sessions[$this->createKey($filter)]);
    }
    /**
     * Visszatér az aktív dinamikus szűrők item neveit tartalmazó tömbbel.
     * @return array
     * @throws RuntimeException
     */
    public function getActiveDynamicFilters()
    {
        if (!is_null($this->sessionKey) && !is_null($this->sessions)) {
            $filters = array();
            foreach ($this->sessions as $key => $value) {
                if ($this->isDynamicFilter($key)) {
                    $filters[] = $this->sessionKey . $key;
                }
            }
            return $filters;
        } else {
            throw new RuntimeException('A $sessionKey és $sessions értékének megadása kötelező!');
        }
    }
    /**
     * Beállítja a dinamikus szűrő értékét.
     * @param string $filter Dinamikus szűrő neve.
     * @param string $condition A dinamikus szűrőhöz tartozó feltétel.
     * @param array $request Request értékeket tartalmazó tömb, amelyben megkeresi a szűrő kulcsát.
     */
    public function setDynamicFilter($filter, $condition, array $request)
    {
        $filterItem = $this->getDynamicFilter($filter);
        $escapedValue = mysql_real_escape_string($filterItem->_value);
        if (is_string($condition)) {
            $sqlCondition = str_replace('{value}', $escapedValue, $condition);
        } else {
            $sqlCondition = $condition;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->isActive($filter)) {
                $this->addDynamicFilterCondition($filterItem, $sqlCondition, false);
            }
        } else {
            $requestKey = $this->createKey($filter, true);
            if (isset($request[$requestKey])) {
                $this->addDynamicFilterCondition($filterItem, $sqlCondition);
            } else {
                if ($this->hasDynamicFilterSession($filter)) {
                    $this->removeDynamicFilterSession($filter, false);
                }
            }
        }
    }
    /**
     * Beállítja a dinamikus szűrőt a paraméterül adott Closure-ből. Ha machinálni kell a modellben, akkor érdemes 
     * ezt a metódust használni a <b>setDynamicFilter()</b> metódus helyett.
     * @param string $filter Dinamikus szűrő neve.
     * @param Closure $callback Closure.
     * @param array $request Request értékeket tartalmazó tömb, amelyben megkeresi a szűrő kulcsát.
     */
    public function setDynamicFilterViaClosure($filter, Closure $callback, array $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->hasDynamicFilter($filter) && $this->isActive($filter)) {
                //$callback($this->getDynamicFilter($filter), &$this, false);
                $callback($this->getDynamicFilter($filter), $this, false);
            }
        } else {
            $requestKey = $this->getSessionKey() . $this->createKey($filter);
            if (isset($request[$requestKey]) && $this->hasDynamicFilter($filter)) {
                //$callback($this->getDynamicFilter($filter), &$this);
                $callback($this->getDynamicFilter($filter), $this);
            } else {
                if ($this->hasDynamicFilterSession($filter)) {
                    $this->removeDynamicFilterSession($filter, false);
                }
            }            
        }
    }
    /**
     * Hozzáadja a dinamikus szűrő feltételét a modelhez.
     * @param \Item $filter Dinamikus szűrő Item objektum.
     * @param string $condition Dinamikus szűrőhöz tartozó feltétel.
     * @param boolean $store Tárolja-e a $_SESSION szuperglobális tömbben a dinamikus szűrőt. (Aktív-e)
     */
    public function addDynamicFilterCondition(\Item $filter, $condition, $store = true)
    {
        $this->listWhere[$this->createKey($filter->_name)] = $condition;
        if ($store === true) {
            $this->sessions[$filter->_name] = $filter->_value;
        }
    }
    /**
     * Visszatér a dinamikus szűrőkkel JSON formátumban.
     * @return string
     * @throws RuntimeException
     */
    public function serializeActiveDynamicFilters()
    {
        return json_encode($this->getActiveDynamicFilters());
    }
    /**
     * Készít egy dinamikus szűrő kulcsot a megadott paraméter alapján.
     * @param string $name A kulcs értéke.
     * @param boolean $sessionKey $_SESSION kulcsot generáljon-e.
     * @return string
     * @throws InvalidArgumentException
     */
    protected function createKey($name, $sessionKey = false)
    {
        if ($this->validateKey($name)) {
            $key = $sessionKey === true ? $this->getSessionKey() : '';
            return $key . $this->dynamicFiltersPrefix() . $name;
        }
    }
    /**
     * Megvizsgálja, hogy a kulcs megfelelő-e.
     * @param string $key Dinamikus szűrő kulcs.
     * @return boolean
     */
    protected function isValidKey($key)
    {
        return is_string($key) && isset($key[2]);
    }
    /**
     * Validálja a kulcsot. Ha a kulcs nem megfelelő, akkor InvalidArgumentException-t dob.
     * @param string $key Dinamikus szűrő kulcs.
     * @return boolean
     * @throws InvalidArgumentException
     */
    protected function validateKey($key)
    {
        if ($this->isValidKey($key)) {
            return true;
        } else {
            throw new InvalidArgumentException('A kulcs (' . $key . ') értéke nem megfelelő!');
        }
    }
    /**
     * Visszatér a $sessionKey értékével.
     * @return string
     */
    public function getSessionKey()
    {
        return $this->sessionKey;
    }
    /**
     * Beállítja a $sessionKey értékét.
     * @param string $sessionKey
     * @return void
     * @throws InvalidArgumentException
     */
    protected function setSessionKey($sessionKey)
    {
        if ($this->validateKey($sessionKey)) {
            $this->sessionKey = $sessionKey;
        }
    }
    /**
     * Beállítja a $sessions példányváltozó értékét.
     * @return void
     */
    protected function setSessions()
    {
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = array();
        }
        $this->sessions = &$_SESSION[$this->sessionKey];
    }
    /**
     * Készít egy LIKE feltételt a paraméterek alapján.
     * @param string $value Érték
     * @param string $operator Melyik mintára készül a feltétel.
     * @return string
     */
    public function createLike($value, $operator = self::OP_LIKE_ANYWHERE)
    {
        return str_replace('{value}', $value, $operator);
    }
    /**
     * Visszatér az operátorral. Ez a metódus azért került bele, hogy ne a kérésből származó operátorral állítsa össze 
     * a lekérdezést. Elég valószínű, hogy nincs rá szükség, de az ördög nem alszik, nekünk pedig nem jó az 
     * SQL Injection. :)
     * @param string $operator Operátor
     * @return string
     */
    public function getOperator($operator)
    {
        switch ($operator) {
            case self::OP_INT_EQUAL:
                return self::OP_INT_EQUAL;
            case self::OP_INT_GREATER_THAN:
                return self::OP_INT_GREATER_THAN;
            case self::OP_INT_GREATER_THAN_OR_EQUAL:
                return self::OP_INT_GREATER_THAN_OR_EQUAL;
            case self::OP_INT_LESS_THAN:
                return self::OP_INT_LESS_THAN;
            case self::OP_INT_LESS_THAN_OR_EQUAL:
                return self::OP_INT_LESS_THAN_OR_EQUAL;
            case self::OP_LIKE_ANYWHERE:
                return self::OP_LIKE_ANYWHERE;
            case self::OP_LIKE_EQUAL:
                return self::OP_LIKE_EQUAL;
            case self::OP_LIKE_POST:
                return self::OP_LIKE_POST;
            case self::OP_LIKE_PRE:
                return self::OP_LIKE_PRE;
            case self::OP_SQL_BETWEEN:
                return self::OP_SQL_BETWEEN;
            default:
                return self::OP_INT_EQUAL;
        }
    }
    /**
     * Eldönti, hogy valid egész szám operátor-e a paraméterül adott érték.
     * @param string $operator
     * @return boolean
     */
    protected function isValidIntOperator($operator)
    {
        return $operator === self::OP_INT_EQUAL || $operator === self::OP_INT_GREATER_THAN ||
               $operator === self::OP_INT_GREATER_THAN_OR_EQUAL || $operator === self::OP_INT_LESS_THAN ||
               $operator === self::OP_INT_LESS_THAN_OR_EQUAL;
    }
    /**
     * Eldönti, hogy valid LIKE operátor-e a paraméterül adott érték.
     * @param string $operator
     * @return boolean
     */
    protected function isValidLikeOperator($operator)
    {
        return $operator === self::OP_LIKE_ANYWHERE || $operator === self::OP_LIKE_POST || 
               $operator === self::OP_LIKE_PRE || $operator == self::OP_LIKE_EQUAL;
    }
    /**
     * Megvizsgálja, hogy megfelelő-e a feltétel.
     * @param array $value Item _value indexe.
     * @return boolean
     */
    protected function isValidCondition($value)
    {
        return isset($value['value']) && isset($value['match']);
    }
    /**
     * Megvizsgálja, hogy a LIKE feltétel megfelelő-e.
     * @param array $value
     * @return boolean
     */
    protected function isValidLikeCondition($value)
    {
        return $this->isValidCondition($value) && is_string($value['value']) && 
               $this->isValidLikeOperator($value['match']);
    }
    /**
     * Megvizsgálja, hogy az egész szám feltétel megfelelő-e.
     * @param array $value
     * @return boolean
     */
    protected function isValidIntCondition($value)
    {
        return $this->isValidCondition($value) && $this->isValidIntOperator($value['match']);
    }
    /**
     * Megvizsgálja, hogy a dátum feltétel megfelelő-e.
     * @param array $value
     * @return boolean
     */
    protected function isValidDateCondition($value)
    {
        return $this->isValidCondition($value) && isset($value['value_to']);
    }
    /**
     * Hozzáad egy LIKE feltételt a szűréshez.
     * @param \Item $filter Item objektum.
     * @param string $field Mező neve.
     */
    public function addLikeCondition(\Item $filter, $field)
    {
        $value = $filter->_value;
        if ($this->isValidLikeCondition($value)) {
            $this->addDynamicFilterCondition(
                $filter, $field . ' LIKE \'' . mysql_real_escape_string(
                    $this->createLike($value['value'], $this->getOperator($value['match']))
                ) . '\''
            );
        }
    }
    /**
     * Hozzáad egy egész szám feltételt a szűréshez.
     * @param \Item $filter Item objektum
     * @param string $field Mező neve.
     */
    public function addIntCondition(\Item $filter, $field)
    {
        $value = $filter->_value;
        if ($this->isValidIntCondition($value)) {
            $this->addDynamicFilterCondition(
                $filter, 
                $field . ' ' . $this->getOperator($value['match']) . ' ' . (int)$value['value']
            );
        }
    }
    /**
     * Hozzáad egy dátum feltételt a szűréshez.
     * @param \Item $filter Item objektum.
     * @param string $field Mező neve.
     */
    public function addDateCondition(\Item $filter, $field)
    {
        $value = $filter->_value;
        $escape = function($value) {
            return '\'' . mysql_real_escape_string($value) . '\'';
        };
        $useDp = 1;
        if (!isset($value['use_dp'])) {
            $useDp = 0;
        }
        $filter->_value['use_dp'] = $useDp;
        if ($this->isValidCondition($value)) {
            if ($value['match'] === self::OP_SQL_BETWEEN) {
                $this->addDynamicFilterCondition(
                    $filter, 
                    $field . ' ' . self::OP_SQL_BETWEEN . ' ' . $escape($value['value']) . ' AND ' . $escape($value['value_to'])
                );
            } else {
                $this->addDynamicFilterCondition(
                    $filter, 
                    $field . ' > 0 AND ' . 
                    $field . ' ' . $this->getOperator($value['match']) . ' ' . $escape($value['value'])
                );
            }
        }
    }
}