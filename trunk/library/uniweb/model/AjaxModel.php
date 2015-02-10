<?php
/**
 * AjaxModel. Az elnevezés egyáltalán nem találó, tulajdonképpen sok köze sincs az AJAX-hoz. Azért kapta ezt a nevet, 
 * mert AJAX controllerek esetében használtam azt a két metódust, amit tartalmaz.
 * 
 * Véleményem szerint nagyon elrontja az egész felépítést, de ahogy az lenni szokott, ez is tegnapra kellett...
 * Ebből kifolyólag olyan, amilyen. :)
 * 
 * @property MYSQL_DB $_DB Adatbázis.
 */
class AjaxModel extends Model
{
    //const CACHE_MAX_AGE = 900;
    const CACHE_MAX_AGE = 0;
    
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    /**
     * Fetcheli a lekérdezés eredményét. Csak azért jött létre ez a metódus, hogy legalább ez a model valamennyire 
     * DRY legyen.
     * @param \MYSQL_Query $result Lekérdezés objektum.
     * @param string $indexKey Kulcs index.
     * @param string $indexValue Érték index.
     * @return array
     */
    public function fetchThis(\MYSQL_Query $result, $indexKey, $indexValue)
    {
        $return = array();
        while ($data = $result->query_fetch_array()) {
            if (isset($data[$indexKey]) && isset($data[$indexValue])) {
                $return[$data[$indexKey]] = $data[$indexValue];
            }
        }
        return $return;
    }
    /**
     * Felolvassa cache-ből az eredményhalmazt, ha van érvenyes cache. Ha nincs, akkor végrehajtja a paraméterül 
     * adott Closure-t, amiben a cache-elési eljárást kell definiálni.
     * @param string $key Cache azonosítója.
     * @param int $maxAge Meddig érvényes cache-t használhat.
     * @param Closure $callback Eredményhalmazt lekérdező Closure a cache-eléshez.
     * @return mixed
     */
    protected function theResult($key, $maxAge, Closure $callback)
    {
        $result = Rimo::getCache()->get($key, array('max-age' => $maxAge));
        if (is_null($result)) {
            $result = call_user_func($callback, $this);
            Rimo::getCache()->set($key, serialize($result));
            return $result;
        } else {
            return unserialize($result);
        }
    }
}