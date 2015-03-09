<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
use Uniweb\Library\Utilities\Behavior\BehaviorContainer;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Author;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\NumberOfModifications;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Timestamp;
use Uniweb\Library\Utilities\ActiveRecord\Validator\IsUnique;

class JobCategory extends Behaviorable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_munkakor_kategoria';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_munkakor_kategoria_id';
    
    public function resolveDependencies()
    {
        $container = new BehaviorContainer;
        $container->attachBehavior('author', new Author('letrehozo_id', 'modosito_id'));
        $container->attachBehavior('nom', new NumberOfModifications('modositas_szama'));
        $container->attachBehavior(
            'status', new RecordStatus(static::$table_name . '_aktiv', static::$table_name . '_torolt')
        );
        $container->attachBehavior('timestamp', new Timestamp('letrehozas_timestamp', 'modositas_timestamp'));
        $this->setBehaviorContainer($container);
        $this->attachBehaviors();
    }
    
    public function validate()
    {
        parent::validate();
        $isUnique = new IsUnique($this, 'nev');
        if (!$isUnique->validate($this->read_attribute('nev'))) {
            $this->errors->add('nev', 'Ez a név már használatban van!');
        }
    }
}