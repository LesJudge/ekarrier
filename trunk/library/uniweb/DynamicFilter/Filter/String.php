<?php
namespace Uniweb\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Filter\FieldFilter;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;
use Uniweb\Library\DynamicFilter\ConditionsEnum;

class String extends FieldFilter
{
    public function filter()
    {
        if (isset($this->data['text']) && isset($this->data['match']) && is_string($this->data['text'])) {
            if (!is_string($this->data['text'])) {
                throw new FilterException('Nem megfelelő érték!');
            }
            if (empty($this->data['text'])) {
                throw new FilterException('Üres szöveget adott meg!');
            }
            $statement = $this->pdo->prepare(sprintf('SELECT %s FROM %s WHERE %s LIKE :text',
                $this->select,
                $this->table,
                $this->field
            ));
            switch ($this->data['match']) {
                case ConditionsEnum::MATCH_ANYWHERE:
                    $text = '%' . $this->data['text'] . '%';
                    break;
                case ConditionsEnum::MATCH_ENDS_WITH:
                    $text = '%' . $this->data['text'];
                    break;
                case ConditionsEnum::MATCH_EQUALS:
                    $text = $this->data['text'];
                    break;
                case ConditionsEnum::MATCH_STARTS_WITH:
                    $text = $this->data['text'] . '%';
                    break;
                default:
                    throw new FilterException('A szűrés mód paraméter nem megfelelő!');
            }
            $statement->bindValue('text', $text);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_COLUMN);
        } else {
            throw new FilterException('A szűrő paraméterei nem megfelelőek!');
        }
    }
}