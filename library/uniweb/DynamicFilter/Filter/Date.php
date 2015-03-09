<?php
namespace Uniweb\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Filter\FieldFilter;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;
use Uniweb\Library\DynamicFilter\ConditionsEnum;
use Uniweb\Library\Validator\Date as DateValidator;

class Date extends FieldFilter
{
    /**
     * Dátum formátum, ami alapján vizsgálja a kapott értéket/értékeket.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    public function filter()
    {
        $validator = new DateValidator;
        $validator->setFormat($this->dateFormat);
        if (isset($this->data['date']) && isset($this->data['match'])) {
            if (!$validator->validate($this->data['date'])) {
                throw new FilterException('A dátum nem megfelelő!');
            }
            if (isset($this->data['date2']) && !$validator->validate($this->data['date2'])) {
                throw new FilterException('Az intervallum dátum nem megfelelő!');
            }
            if ($this->data['match'] === ConditionsEnum::MATCH_BETWEEN) {
                if (!isset($this->data['date2'])) {
                    throw new FilterException('Nem adott meg intervallum dátumot!');
                }
                $statement = $this->pdo->prepare(sprintf('SELECT %s FROM %s WHERE %s BETWEEN :date1 AND :date2',
                    $this->select,
                    $this->table,
                    $this->field
                ));
                $statement->bindValue('date1', $this->data['date']);
                $statement->bindValue('date2', $this->data['date2']);
            } else {
                switch ($this->data['match']) {
                    case ConditionsEnum::MATCH_EQUALS:
                        $operator = '=';
                        break;
                    case ConditionsEnum::MATCH_GREATER_THAN:
                        $operator = '>';
                        break;
                    case ConditionsEnum::MATCH_GREATER_THAN_OR_EQUALS:
                        $operator = '>=';
                        break;
                    case ConditionsEnum::MATCH_LESS_THAN:
                        $operator = '<';
                        break;
                    case ConditionsEnum::MATCH_LESS_THAN_OR_EQUALS:
                        $operator = '<=';
                        break;
                    default:
                        throw new FilterException('A szűrés mód paraméter nem megfelelő!');
                }
                $statement = $this->pdo->prepare(sprintf('SELECT %s FROM %s WHERE %s ' . $operator . ' :date',
                    $this->select,
                    $this->table,
                    $this->field
                ));
                $statement->bindValue('date', $this->data['date']);
            }
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_COLUMN);
        } else {
            throw new FilterException('A szűrő paraméterei hiányosak!');
        }
    }
    /**
     * Visszatér a dátumformátummal, ami szerint vizsgálja az értéket/értékeket.
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }
    /**
     * Beállítja a dátum formátumot, ami szerint vizsgálja majd az értéket/értékeket.
     * @param string $dateFormat Dátum formátum.
     * @return self
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }
}