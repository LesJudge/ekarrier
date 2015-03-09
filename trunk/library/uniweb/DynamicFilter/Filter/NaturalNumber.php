<?php
namespace Uniweb\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Filter\FieldFilter;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;
use Uniweb\Library\DynamicFilter\ConditionsEnum;
use Uniweb\Library\Validator\NaturalNumber;

class NaturalNumber extends FieldFilter
{
    public function filter()
    {
        $validator = new NaturalNumber;
        if (isset($this->data['number']) && isset($this->data['match'])) {
            if (!$validator->validate($this->data['number'])) {
                throw new FilterException('Nem természetes számot adott meg!');
            }
            if (isset($this->data['number2']) && !$validator->validate($this->data['number2'])) {
                throw new FilterException('Az intervallum szám nem megfelelő!');
            }
            if ($this->data['match'] === ConditionsEnum::MATCH_BETWEEN) {
                if (!$this->data['number2']) {
                    throw new FilterException('Nem adott meg intervallum számot!');
                }
                $statement = $this->pdo->prepare(sprintf('SELECT %s FROM %s WHERE %s BETWEEN :number1 AND :number2',
                    $this->select,
                    $this->table,
                    $this->field
                ));
                $statement->bindValue('number1', $this->data['number']);
                $statement->bindValue('number2', $this->data['number2']);
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
                $statement = $this->pdo->prepare(sprintf('SELECT %s FROM %s WHERE %s ' . $operator . ' :number',
                    $this->select,
                    $this->table,
                    $this->field
                ));
                $statement->bindValue('number', $this->data['number']);
            }
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_COLUMN);
        } else {
            throw new FilterException('A szűrő paraméterei hiányosak!');
        }
    }
}