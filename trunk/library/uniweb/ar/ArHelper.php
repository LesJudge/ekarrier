<?php
/**
 * ActiveRecord helper osztály.
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ArHelper
{
    /**
     * Átalakítja a paraméterül adott eredményhalmazt a paraméterül adott formára.
     * @param array $result Eredményhalmaz.
     * @param array $format Formátum.
     * @return array
     * @throws \UnexpectedValueException
     */
    public static function result2Array(array $result, array $format)
    {
        $results = array();
        foreach ($result as $model) {
            if ($model instanceof \ActiveRecord\Model) {
                $results[] = call_user_func(array($model, 'to_array'), $format);
            } else {
                throw new \UnexpectedValueException('All items must be an instance of \\ActiveRecord\\Model!');
            }
        }
        return $results;
    }
    
    public static function result2Options(array $result, $key, $value)
    {
        $options = array();
        foreach ($result as $r) {
            if (isset($r->{$key}) && isset($r->{$value})) {
                $options[$r->{$key}] = $r->{$value};
            } else {
                throw new \OutOfRangeException('A keresett index (' . $key . ') nem létezik!');
            }
        }
        return $options;
    }
    /**
     * Átalakítja a paraméterül adott eredményhalmazt.
     * @param array $result Eredményhalmaz.
     * @param array $fromTo Melyik index melyik nevet viselje. array('eredeti_nev', 'uj_nev')
     * @return array
     * @throws \OutOfRangeException
     */
    public static function result2Aliases(array $result, array $fromTo)
    {
        $options = array();
        foreach ($result as $r) {
            $r = is_object($r) ? $r : (object)$r;
            $option = array();
            foreach ($fromTo as $v) {
                if (isset($r->{$v[0]})) {
                    $option[$v[1]] = $r->{$v[0]};
                } else {
                    throw new \OutOfRangeException('A keresett index (' . $v[0] . ') nem létezik!');
                }
            }
            $options[] = $option;
        }
        return $options;
    }
    /**
     * Menti a sheepItForm-ot adatbázisba.
     * @param ISheepItAble $model
     * @return boolean
     * @throws ActiveRecord\DatabaseException
     * @throws \PDOException
     */
    public static function saveSheepItForm(\ISheepItAble $model)
    {
        $model->query($model->sheepItSaveQuery(), $model->sheepItSaveValue());
        return true;
    }
    /**
     * Serializálja a paraméterül adott összes modelt. A tömbnek olyan objektumokat kell tartalmaznia, amelyek 
     * implementálják az <b>ISheepItAble</b> interface-t.
     * @param array $models Modeleket tartalmazó tömb.
     * @return string
     * @throws \UnexpectedValueException
     */
    public static function serializeSheepItModels(array $models)
    {
        $serializables = array();
        foreach ($models as $model) {
            /* @var $model ISheepItAble */
            if ($model instanceof ISheepItAble) {
                $serializables[] = $model->sheepIt2Serializable();
            } else {
                throw new \UnexpectedValueException('Nem megfelelő model!');
            }
        }
        return json_encode($serializables);
    }
    /**
     * Serializálja a modelt.
     * @param \ISheepItAble $model
     * @return string
     */
    public static function serializeSheepItModel(\ISheepItAble $model)
    {
        return json_encode($model->sheepIt2Serializable());
    }
}