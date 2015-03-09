<?php
namespace Uniweb\Module\Cim\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ReadOnly;
use Uniweb\Module\Cim\Library\AddressFinderInteface;
use ReflectionProperty;

class AddressView extends ReadOnly implements AddressFinderInteface
{
    public static $table_name = 'cim_view';
    
    public function findAddress(array $fields, array $extra = array())
    {
        $finderOptions = array();
        $finderOptions['select'] = implode(',', $fields);        
        /* @var $data self */
        $data = $this->find('all', array_merge($finderOptions, $extra));
        if (!empty($data)) {
            foreach ($data as $index => $item) {
                $data[$index] = $item->to_array(array('only' => $fields));
            }
        }
        return $data;
    }
}