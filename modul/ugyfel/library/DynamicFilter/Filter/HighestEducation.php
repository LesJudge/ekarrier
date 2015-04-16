<?php
namespace Uniweb\Module\Ugyfel\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Filter\FieldFilter;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;
use Uniweb\Library\Validator\NaturalNumber;

class HighestEducation extends FieldFilter
{
    public function filter()
    {
        $naturalNumberValidator = new NaturalNumber();
        if (
            isset($this->data['educationId']) 
            && 
            $naturalNumberValidator->validate((int)$this->data['educationId'])
        ) {
            $query = 'SELECT ugyfel_id FROM ugyfel WHERE vegzettseg_id = :educationId AND ugyfel_torolt = 0';
            $statement = $this->pdo->prepare($query);
            $statement->bindValue('educationId', $this->data['educationId']);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_COLUMN);
        } else {
            throw new FilterException('Nem megfelelő szűrő paraméterek!');
        }
    }
}