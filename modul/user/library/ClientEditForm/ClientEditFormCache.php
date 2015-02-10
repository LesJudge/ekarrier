<?php
/**
 * Ügyfél form cache.
 */
class ClientEditFormCache
{
    const CLIENT_EDIT_FORM_CACHE_MAX_AGE = 900;
    /**
     * Egyszerű, tömb alapú cachelés.
     * @param string $name Cache neve (kulcsa), amin keresztül majd hivatkozni lehet rá.
     * @param array $model Model.
     * @param array $params Paraméterek.
     * @param array $conditions
     * @return array
     */
    public static function optionCache($name, array $model, array $params, array $conditions = array(
        'max-age' => self::CLIENT_EDIT_FORM_CACHE_MAX_AGE
    )) {
        $value = Rimo::getCache()->get($name, $conditions);
        if (is_null($value)) {
            $data = ArHelper::result2Options(call_user_func($model), $params[0], $params[1]);
            $value = serialize($data);
            Rimo::getCache()->set($name, $value);
            return $data;
        }
        return unserialize($value);
    }
    /**
     * Cache metódus azokhoz az objektumokhoz, amelyek rendelkeznek <b>toAutocomplete()</b> metódussal.
     * @param string $name Cache neve (kulcsa), amin keresztül majd hivatkozni lehet rá.
     * @param string $model Model neve.
     * @return array
     */
    public static function autoCompleteOptionCache($name, $model)
    {
        $data = Rimo::getCache()->get($name);
        if (is_null($data)) {
            $data = call_user_func(
                array($model, 'toAutocomplete'), call_user_func(array($model, 'findAllActiveNotDeleted'))
            );
            Rimo::getCache()->set($name, serialize($data));
            return $data;
        }
        return unserialize($data);
    }
}