<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;

use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Author;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\NumberOfModifications;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Timestamp;
use Uniweb\Library\Utilities\ActiveRecord\Read\DateTime as ReadDateTime;
use Uniweb\Library\Resource\Interfaces\ResourceInterface;

/**
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $ugyfel_munkakor_kategoria_id Munkakör kategória.
 * @property int $ugyfel_munkaba_allas_allapot_id Munkába állás állapot.
 * @property int $vegzettseg_id Végzettség azonosító.
 * @property string $email E-mail cím.
 * @property string $vezeteknev Vezetéknév.
 * @property string $keresztnev Keresztnév.
 * @property string $nem Ügyfél neme.
 * @property string $anyja_neve Anyja neve.
 * @property string $telefonszam_vezetekes Vezetékes telefonszám.
 * @property string $telefonszam_mobil1 Elsődleges mobilszám.
 * @property string $telefonszam_mobil2 Másodlagos mobilszám.
 * @property int $user_hirlevel Hírlevélre feliratkozott-e.
 * @property null|\ActiveRecord\DateTime $kapcsolatfelvetel_ideje Kapcsolatfelvétel ideje.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_aktiv Aktív-e az ügyfél.
 * @property int $ugyfel_torolt Törölt-e az ügyfél.
 * 
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Comment\Activity $commentactivity Ügyfélhez tartozó álláskeresési aktivitás megjegyzés.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Comment\ClientInformation $commentclientinformation Ügyfélhez tartozó ügyfél információ megjegyzés.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Comment\Contact $commentcontact Ügyfélhez tartozó esetnapló megjegyzés.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Comment\Document $commentdocument Ügyfélhez tartozó dokumentum megjegyzés.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $consultant Tanácsadó.
 * 
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\LaborMarket $labormarket Munkaerő piaci helyzet kapcsolat.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\ProjectInformation $projectinformation Projekt információs adatok.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Status $status Státusz adatok.
 * @property \Uniweb\Module\Beallitas\Model\ActiveRecord\Education $highesteducation Legmagasabb iskolai végzettség.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData $birthdata Születési adatok.
 * 
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Address[] $addresses Ügyfélhez tartozó címek.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Document[] $documents Ügyfélhez tartozó dokumentumok dokumentumok.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Contact[] $contacts Ügyfélhez tartozó esetnapló bejegyzések.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Education[] $educations Ügyfélhez tartozó végzettségek.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Knowledge[] $knowledges Ügyfélhez tartozó nyelvtudások.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\ComputerKnowledge[] $computerknowledges Ügyfélhez tartozó számítógépes ismeretek.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested $services Ügyfélhez tartozó szolgáltatások.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\ProgramInformation[] $programinformations Ügyfélhez tartozó program információk.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\WorkSchedule[] $workschedules Ügyfélhez tartozó munkarendek.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Project[] $projects Ügyfélhez tartozó projektek.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Job[] $jobs Ügyfélhez tartozó munkakörök.
 */
class Client extends Behaviorable implements ResourceInterface
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel';
    
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    
    public static $has_one = array(
        array(
            'commentactivity',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\Activity',
            'conditions' => 'ugyfel_tab_id = 7',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentclientinformation',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\ClientInformation',
            'conditions' => 'ugyfel_tab_id = 1',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentcontact',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\Contact',
            'conditions' => 'ugyfel_tab_id = 9',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentdocument',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\Document',
            'conditions' => 'ugyfel_tab_id = 10',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commenteducation',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\Education',
            'conditions' => 'ugyfel_tab_id = 6',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentjob',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\Job',
            'conditions' => 'ugyfel_tab_id = 5',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentlabormarket',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\LaborMarket',
            'conditions' => 'ugyfel_tab_id = 3',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentlogin',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\Login',
            'conditions' => 'ugyfel_tab_id = 11',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentpersonaldata',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\PersonalData',
            'conditions' => 'ugyfel_tab_id = 2',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentproject',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\Project',
            'conditions' => 'ugyfel_tab_id = 8',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentprojectinformation',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Comment\\ProjectInformation',
            'conditions' => 'ugyfel_tab_id = 4',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'employmentstatus',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\EmploymentStatus',
            'foreign_key' => 'ugyfel_munkaba_allas_allapot_id',
            'primary_key' => 'ugyfel_munkaba_allas_allapot_id',
            'read_only' => true
        ),
        array(
            'jobcategory',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\JobCategory',
            'foreign_key' => 'ugyfel_munkakor_kategoria_id',
            'primary_key' => 'ugyfel_munkakor_kategoria_id',
            'read_only' => true
        ),
        array(
            'highesteducation',
            'class_name' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\Education',
            'foreign_key' => 'vegzettseg_id',
            'primary_key' => 'vegzettseg_id',
            'read_only' => true
        ),
        array(
            'consultant',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'foreign_key' => 'user_id',
            'primary_key' => 'tanacsado_id',
            'read_only' => true
        )
    );
    
    /**
     * Modelhez tartozó 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'labormarket',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\LaborMarket',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'projectinformation',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\ProjectInformation',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'status',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Status',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'birthdata',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\BirthData',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        )
    );
    
    /**
     * Modelhez tartozó 1:n kapcsolatok.
     * @var array
     */
    public static $has_many = array(
        array(
            'addresses',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Address',
            'conditions' => 'ugyfel_attr_cim_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó dokumentumok.
        array(
            'documents',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Document',
            'conditions' => 'ugyfel_attr_dokumentum_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó esetnapló bejegyzések.
        array(
            'contacts',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Contact',
            'conditions' => 'ugyfel_attr_esetnaplo_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó iskolai végzettségek.
        array(
            'educations',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Education',
            'conditions' => 'ugyfel_attr_vegzettseg_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó nyelvtudások.
        array(
            'knowledges',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Knowledge',
            'conditions' => 'ugyfel_attr_nyelvtudas_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó számítógépes ismeretek.
        array(
            'computerknowledges',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\ComputerKnowledge',
            'conditions' => 'ugyfel_attr_szamitogepes_ismeret_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó szolgáltatások.
        array(
            'services',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\ServiceInterested',
            'conditions' => 'ugyfel_attr_szolgaltatas_erdekelt_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó program információk.
        array(
            'programinformations',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\ProgramInformation',
            'conditions' => 'ugyfel_attr_program_informacio_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó munkarendek.
        array(
            'workschedules',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\WorkSchedule',
            'conditions' => 'ugyfel_attr_munkarend_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó projektek.
        array(
            'projects',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Project',
            'conditions' => 'ugyfel_attr_projekt_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Ügyfélhez tartozó munkakörök.
        array(
            'jobs',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Job',
            'conditions' => 'ugyfel_attr_munkakor_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        )
    );
    
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'keresztnev',
            'message' => 'A keresztnév megadása kötelező!'
        ),
        array(
            'vezeteknev',
            'message' => 'A vezetéknév megadása kötelező!'
        )
    );
    
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array(
        array(
            'email',
            'allow_blank' => true,
            'within' => array(8, 255),
            'too_short' => 'Az e-mail címnek legalább 8 karakter hosszúnak kell lennie!',
            'too_long' => 'Az e-mail cím legfeljebb 255 karakter hosszú lehet!'
        ),
        array(
            'keresztnev',
            'within' => array(3, 128),
            'too_short' => 'A keresztnévnek legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'A keresztnév legfeljebb 128 karakter hosszú lehet!'
        ),
        array(
            'vezeteknev',
            'within' => array(3, 128),
            'too_short' => 'A vezetéknévnek legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'A vezetéknév legfeljebb 128 karakter hosszú lehet!'
        ),
        array(
            'telefonszam_vezetekes',
            'allow_blank' => true,
            'within' => array(10, 11),
            'too_short' => 'A telefonszámnak legalább 10 karakter hosszúnak kell lennie!',
            'too_long' => 'A telefonszám legfeljebb 11 karakter hosszú lehet!'
        ),
        array(
            'telefonszam_mobil1',
            'allow_blank' => true,
            'within' => array(10, 11),
            'too_short' => 'A mobiltelefonszámnak legalább 10 karakter hosszúnak kell lennie!',
            'too_long' => 'A mobiltelefonszámnak legfeljebb 11 karakter hosszú lehet!'
        ),
        array(
            'telefonszam_mobil2',
            'allow_blank' => true,
            'within' => array(10, 11),
            'too_short' => 'A mobiltelefonszámnak legalább 10 karakter hosszúnak kell lennie!',
            'too_long' => 'A mobiltelefonszámnak legfeljebb 11 karakter hosszú lehet!'
        )
    );
    
    /**
     * Mezők által felvehető értékek validációs szabályok.
     * @var array
     */
    public static $validates_inclusion_of = array(
        array(
            'user_hirlevel',
            'in' => array(0, 1),
            'message' => 'A hírlevél értéke csak igen-nem lehet!'
        ),
        array(
            'ugyfel_aktiv',
            'in' => array(0, 1),
            'message' => 'Az aktív értéke csak igen-nem lehet!'
        )
    );
    
    /**
     * Mezők értékeinek "formájára" vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_format_of = array(
        array(
            'telefonszam_vezetekes',
            'allow_blank' => true,
            'with' => '/^36[0-9]{8,9}$/',
            'message' => 'A telefonszám nem megfelelő! (pl. 3650123456)'
        ),
        array(
            'telefonszam_mobil1',
            'allow_blank' => true,
            'with' => '/^36[0-9]{8,9}$/',
            'message' => 'A telefonszám nem megfelelő! (pl. 36501234567)'
        ),
        array(
            'telefonszam_mobil2',
            'allow_blank' => true,
            'with' => '/^36[0-9]{8,9}$/',
            'message' => 'A telefonszám nem megfelelő! (pl. 36501234567)'
        )
    );
    
    public function behaviors()
    {
        return array(
            'author' => new Author('letrehozo_id', 'modosito_id'),
            'modifications' => new NumberOfModifications('modositas_szama'),
            'status' => new RecordStatus('ugyfel_aktiv', 'ugyfel_torolt'),
            'timestamp' => new Timestamp('letrehozas_timestamp', 'modositas_timestamp')
        );
    }
    
    /**
     * Visszatér az ügyfél azonosítóval.
     * @return scalar
     */
    public function getResourceId()
    {
        return $this->ugyfel_id;
    }
    
    public function set_ugyfel_munkakor_kategoria_id($ugyfel_munkakor_kategoria_id)
    {
        $assign = new AssignWithoutCast;
        if (empty($ugyfel_munkakor_kategoria_id)) {
            $ugyfel_munkakor_kategoria_id = null;
        }
        $assign->assignAttribute('ugyfel_munkakor_kategoria_id', $ugyfel_munkakor_kategoria_id, $this);
    }
    
    public function set_ugyfel_munkaba_allas_allapot_id($ugyfel_munkaba_allas_allapot_id)
    {
        $assign = new AssignWithoutCast;
        if (empty($ugyfel_munkaba_allas_allapot_id)) {
            $ugyfel_munkaba_allas_allapot_id = null;
        }
        $assign->assignAttribute('ugyfel_munkaba_allas_allapot_id', $ugyfel_munkaba_allas_allapot_id, $this);
    }
    
    public function set_tanacsado_id($tanacsado_id)
    {
        $assign = new AssignWithoutCast;
        if (empty($tanacsado_id)) {
            $tanacsado_id = null;
        }
        $assign->assignAttribute('tanacsado_id', $tanacsado_id, $this);
    }
    
    public function set_vegzettseg_id($vegzettseg_id)
    {
        $assign = new AssignWithoutCast;
        if (empty($vegzettseg_id)) {
            $vegzettseg_id = null;
        }
        $assign->assignAttribute('vegzettseg_id', $vegzettseg_id, $this);
    }
    
    public function get_kapcsolatfelvetel_ideje($format = 'Y-m-d')
    {
        $readDateTime = new ReadDateTime($format);
        return $readDateTime->readAttribute('kapcsolatfelvetel_ideje', $this);
    }
}