<?php
namespace Uniweb\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Filter\FieldFilter;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;

class TrueOrFalse extends FieldFilter
{
    const MATCH_TRUE = 'true';
    const MATCH_FALSE = 'false';
    
    public function filter()
    {
        if (isset($this->data['match'])) {
            $statement = $this->pdo->prepare(sprintf('SELECT %s FROM %s WHERE %s = :value',
                $this->select,
                $this->table,
                $this->field
            ));
            switch ($this->data['match']) {
                case static::MATCH_TRUE:
                    $value = 1;
                    break;
                case static::MATCH_FALSE:
                    $value = 0;
                    break;
                default:
                    throw new FilterException('A szűrés mód paraméter nem megfelelő!');
            }
            $statement->bindValue('value', $value);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_COLUMN);
        } else {
            throw new FilterException('A szűrő paraméterei nem megfelelőek!');
        }
    }
}