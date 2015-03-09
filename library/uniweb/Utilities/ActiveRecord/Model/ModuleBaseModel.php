<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Model;
use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Author;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\NumberOfModifications;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\String;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Timestamp;
use Uniweb\Library\Utilities\ActiveRecord\Validator\IsUnique as UniqueValidator;
/**
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó kapcsolat.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó kapcsolat.
 */
abstract class ModuleBaseModel extends Behaviorable
{
    public static $belongs_to = array(
        // Létrehozó kapcsolat.
        array(
            'creator',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'conditions' => 'user_aktiv = 1 AND user_torolt = 0',
            'foreign_key' => 'letrehozo_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login'
        ),
        // Módosító kapcsolat.
        array(
            'modificatory',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'conditions' => 'user_aktiv = 1 AND user_torolt = 0',
            'foreign_key' => 'modosito_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login'
        )
    );
    
    public function behaviors()
    {
        return array(
            'author' => new Author('letrehozo_id', 'modosito_id'),
            'name' => new String('nev', true, 3, 128, true),
            'modifications' => new NumberOfModifications('modositas_szama'),
            'status' => new RecordStatus('aktiv', 'torolt', 1, 0),
            'timestamp' => new Timestamp('letrehozas_timestamp', 'modositas_timestamp')
        );
    }
    
    public function validate()
    {
        parent::validate();
        /* @var $nameBehavior \Uniweb\Library\Utilities\ActiveRecord\Behavior\String */
        $nameBehavior = $this->in('name');
        $uniqueValidator = new UniqueValidator($this, $nameBehavior->getStringAttribute());
        if (!$uniqueValidator->validate($nameBehavior->get_string())) {
            $this->errors->add($nameBehavior->getStringAttribute(), 'Ez az érték már használatban van!');
        }
    }
    
    public function get_nev()
    {
        return $this->in('name')->get_string();
    }
    
    public function get_letrehozo_id()
    {
        return $this->in('author')->get_letrehozo_id();
    }
    
    public function get_modosito_id()
    {
        return $this->in('author')->get_modosito_id();
    }
    
    public function get_letrehozas_timestamp()
    {
        return $this->in('timestamp')->get_letrehozas_timestamp();
    }
    
    public function get_modositas_timestamp()
    {
        return $this->in('timestamp')->get_modositas_timestamp();
    }
    
    public function get_modositas_szama()
    {
        return $this->in('modifications')->get_modositas_szama();
    }
    
    public function get_aktiv()
    {
        return $this->in('status')->get_aktiv();
    }
    
    public function get_torolt()
    {
        return $this->in('status')->get_torolt();
    }
    
    public function set_nev($nev)
    {
        $this->in('name')->set_string($nev);
    }
    
    public function set_letrehozo_id($letrehozo_id)
    {
        $this->in('author')->set_letrehozo_id($letrehozo_id);
    }
    
    public function set_modosito_id($modosito_id)
    {
        $this->in('author')->set_modosito_id($modosito_id);
    }
    
    public function set_letrehozas_timestamp($letrehozas_timestamp)
    {
        $this->in('timestamp')->set_letrehozas_timestamp($letrehozas_timestamp);
    }
    
    public function set_modositas_timestamp($modositas_timestamp)
    {
        $this->in('timestamp')->set_modositas_timestamp($modositas_timestamp);
    }
    
    public function set_modositas_szama($modositas_szama)
    {
        $this->in('modifications')->set_modositas_szama($modositas_szama);
    }
    
    public function set_aktiv($aktiv)
    {
        $this->in('status')->set_aktiv($aktiv);
    }
    
    public function set_torolt($torolt)
    {
        $this->in('status')->set_torolt($torolt);
    }
}