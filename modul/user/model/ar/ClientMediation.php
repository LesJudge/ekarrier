<?php
class ClientMediation extends \ArBase implements \ISheepItAble, \IClientSave
{
    public static $table_name = 'ugyfel_attr_kozvetites';
    
    public static $primary_key = 'ugyfel_id';
    
    /**
     * Visszatér a 'mikor' mező formázott értékével.
     * @return mixed
     */
    public function get_mikor()
    {
        return $this->readDateTimeAttribute('mikor');
    }
    
    public static function findOptions()
    {
        $return = array();
        $options = self::find('all');
        if (!empty($options)) {
            foreach ($options as $option) {
                $return[] = $option->kozvetites;
            }
        }
        return array_unique($return);
    }
    
    public function canDeleteBeforeUpdate()
    {
        return true;
    }

    public function sheepIt2Serializable()
    {
        $prefix = $this->sheepItPrefix();
        $errors = $this->errors;
        $data = array();
        $data[$prefix . '_kozvetites'] = $this->kozvetites;
        $data[$prefix . '_mikor'] = $this->mikor;
        if (is_object($errors) && $errors->on('kozvetites')) {
            $data[$prefix . '_kozvetites_error'] = $errors->on('kozvetites');
        } else {
            $data[$prefix . '_kozvetites_error'] = null;
        }
        if (is_object($errors) && $errors->on('mikor')) {
            $data[$prefix . '_mikor_error'] = $errors->on('mikor');
        } else {
            $data[$prefix . '_mikor_error'] = null;
        }
        return $data;
    }

    public function sheepItDelete()
    {
        $query = 'DELETE FROM ' . self::$table_name . ' WHERE ugyfel_id = ?';
        self::query($query, array($this->ugyfel_id));
    }

    public static function sheepItPrefix()
    {
        return 'mediationForm_#index#';
    }

    public function sheepItSaveQuery()
    {
        return 'INSERT INTO ' . self::$table_name . ' (ugyfel_id, kozvetites, mikor) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE kozvetites = ?, mikor = ?';
    }

    public function sheepItSaveValue()
    {
        return array(
            $this->ugyfel_id,
            $this->kozvetites,
            $this->mikor,
            $this->kozvetites,
            $this->mikor
        );
    }

    public static function model($param = null)
    {
        $class = get_called_class();
        return new $class;
    }

    public function setUpClientSave(\Client $client)
    {
        $this->ugyfel_id = $client->ugyfel_id;
        return $this;
    }
}