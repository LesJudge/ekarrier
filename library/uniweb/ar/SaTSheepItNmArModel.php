<?php
/**
 * @deprecated Ezt is érdemes volt legyártani, mert végül csak egy osztály használja...
 */
abstract class SaTSheepItNmArModel extends \SheepItNmArModel
{
    /**
     * Visszatér a 'resztvett' mező értékével.
     * @return int
     */
    public function get_resztvett()
    {
        return $this->readBitAttribute('resztvett');
    }
    /**
     * Visszatér a 'mikor' mező formázott értékével.
     * @return mixed
     */
    public function get_mikor()
    {
        return $this->readDateTimeAttribute('mikor');
    }
    
    public function set_resztvett($value)
    {
        $this->assignBitAttribute('resztvett', $value);
    }
    /**
     * JSON formátumúvá alakítja a modelt.
     * @return array SheepItForm adatai JSON formátumban.
     */
    public function sheepIt2Serializable()
    {
        $prefix = $this->sheepItPrefix();
        $jsonData = parent::sheepIt2Serializable();
        $relation = $this->relationObject();
        if (is_object($relation)) {
            $errors = $relation->errors;
            if (is_object($errors)) {
                $addError = function($attribute) use ($prefix, $jsonData, $errors) {
                    $error = $errors->on($attribute);
                    $jsonData[$prefix . '_' . $attribute . '_error'] = $error;
                };
                $addError('resztvett');
                $addError('mikor');
            }
        } else {
            $jsonData[$prefix . '_resztvett_error'] = 'Nem megfelelő érték!';
            $jsonData[$prefix . '_mikor_error'] = 'Dátumot (éééé-hh-nn) adjon meg!';
        }
        $jsonData[$prefix . '_resztvett'] = $this->resztvett;
        $jsonData[$prefix . '_mikor'] = $this->mikor;
        return $jsonData;
    }
    /**
     * Visszatér a végrehajtandó SQL Query-vel.
     * @return string
     */
    public function sheepItSaveQuery()
    {
        $t = self::table_name();
        return 'INSERT INTO ' . $t . ' (user_id, ' . $this->fieldId() . ', resztvett, mikor) VALUES (?, ?, ?, ?) 
               ON DUPLICATE KEY UPDATE ' . $this->fieldId() . ' = ?, resztvett = ?, mikor = ?';
    }
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue()
    {
        $fieldId = $this->{$this->fieldId()};
        $resztvett = $this->read_attribute('resztvett');
        $mikor = $this->read_attribute('mikor');
        if ($mikor instanceof \ActiveRecord\DateTime) {
            $mikor = $mikor->format(\ArBase::DEFAULT_DATE_FORMAT);
        } else {
            $mikor = 'NULL';
        }
        return array($this->user_id, $fieldId, $resztvett, $mikor, $fieldId, $resztvett, $mikor);
    }
}