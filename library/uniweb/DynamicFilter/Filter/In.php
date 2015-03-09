<?php
namespace Uniweb\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Filter\FieldFilter;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;

class In extends FieldFilter
{
    public function filter()
    {
        if (isset($this->data['in']) && is_array($this->data['in']) && !empty($this->data['in'])) {
            $in = $this->data['in'] = array_unique($this->data['in']);
            foreach ($in as $item) {
                if (!is_scalar($item)) {
                    throw new FilterException('A szűrő nem megfelelő értéket kapott!');
                }
            }
            $statement = $this->pdo->prepare(sprintf('SELECT %s FROM %s WHERE %s IN (%s)',
                $this->select,
                $this->table,
                $this->field,
                implode(',', $in)
            ));
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_COLUMN);
        } else {
            throw new FilterException('A szűrő paraméterei hiányosak!');
        }
    }
}