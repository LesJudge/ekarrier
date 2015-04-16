<?php
namespace Uniweb\Module\Ugyfel\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Filter\FieldFilter;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;
use Uniweb\Library\DynamicFilter\ConditionsEnum;
use Uniweb\Library\Validator\NaturalNumber;

class Education extends FieldFilter
{
    public function filter()
    {
        $naturalNumberValidator = new NaturalNumber();
        if (
            isset($this->data['educationId']) 
            && 
            $naturalNumberValidator->validate((int)$this->data['educationId']) 
            && 
            isset($this->data['denomination']) 
            && 
            isset($this->data['match'])
        ) {
            $query = 'SELECT ugyfel_id FROM ugyfel_attr_vegzettseg WHERE vegzettseg_id = :educationId';
            $statement = null;
            if (strlen($this->data['denomination']) > 0) {
                switch ($this->data['match']) {
                    case ConditionsEnum::MATCH_ANYWHERE:
                        $denomination = '%' . $this->data['denomination'] . '%';
                        break;
                    case ConditionsEnum::MATCH_ENDS_WITH:
                        $denomination = '%' . $this->data['denomination'];
                        break;
                    case ConditionsEnum::MATCH_EQUALS:
                        $denomination = $this->data['denomination'];
                        break;
                    case ConditionsEnum::MATCH_STARTS_WITH:
                        $denomination = $this->data['denomination'] . '%';
                        break;
                    default:
                        throw new FilterException('A szűrés mód paraméter nem megfelelő!');
                }
                $query .= ' AND megnevezes LIKE :denomination';
                $statement = $this->pdo->prepare($query);
                $statement->bindValue('denomination', $denomination);
            }
            $query .= ' AND ugyfel_attr_vegzettseg_torolt = 0';
            if (is_null($statement)) {
                $statement = $this->pdo->prepare($query);
            }
            $statement->bindValue('educationId', $this->data['educationId']);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_COLUMN);
        } else {
            throw new FilterException('Nem megfelelő szűrő paraméterek!');
        }
    }
}