<?php
namespace Uniweb\Module\Ugyfel\Library\DynamicFilter\Filter;

use PDO;
use Uniweb\Library\DynamicFilter\ConditionsEnum;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;
use Uniweb\Library\DynamicFilter\Filter\FieldFilter;
use Uniweb\Library\Validator\Date as DateValidator;

class Service extends FieldFilter
{
    public function filter()
    {
        if (
            isset($this->data['serviceId']) 
            && 
            (isset($this->data['want_to_participate']) || isset($this->data['attended'])) 
            && 
            isset($this->data['when']) 
            && 
            isset($this->data['whenMatch']) 
            && 
            isset($this->data['whenBetween'])
        ) {
            $query = 'SELECT ugyfel_id FROM ugyfel_attr_szolgaltatas_erdekelt WHERE ';
            $conditions = array('szolgaltatas_id = ' . $this->data['serviceId']);
            if (isset($this->data['want_to_participate'])) {
                $conditions[] = ' reszt_akar_venni = 1';
            }
            if (isset($this->data['attended'])) {
                $conditions[] = ' reszt_vett = 1';
            }
            if (!empty($this->data['when']) || !empty($this->data['whenBetween'])) {
                $dateValidator = new DateValidator;
                $dateValidator->setFormat('Y-m-d');
                if ($this->data['whenMatch'] === ConditionsEnum::MATCH_BETWEEN) {
                    if (!$dateValidator->validate($this->data['when'])) {
                        throw new FilterException('A dátum nem megfelelő!');
                    }
                    if (!$dateValidator->validate($this->data['whenBetween'])) {
                        throw new FilterException('A szűrő dátum nem megfelelő!');
                    }
                    $conditions[] = ' mikor BETWEEN "' . $this->data['when'] . 
                            '" AND "' . $this->data['whenBetween']. '"';
                } else {
                    switch ($this->data['whenMatch']) {
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
                    $conditions[] = ' mikor ' . $operator . ' "' . $this->data['when'] . '"';
                }
            }
            $query .= implode(' AND ', $conditions);
            //$query .= ' AND ugyfel_attr_szolgaltatas_erdekelt_aktiv = 1 AND '
            //        . 'ugyfel_attr_szolgaltatas_erdekelt_torolt = 0';
            $query .= ' AND ugyfel_attr_szolgaltatas_erdekelt_torolt = 0';
            $statement = $this->pdo->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_COLUMN);
        } else {
            throw new FilterException('A szűrő paraméterei hiányosak!');
        }
    }
}