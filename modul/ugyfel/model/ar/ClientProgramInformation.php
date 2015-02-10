<?php
/**
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $program_informacio_id Program információ azonosító.
 * @property string $egyeb Egyéb érték.
 * @property \ProgramInformation $programinformation Program információ adatai.
 * @property \Client $client Ügyfél adatai.
 */
class ClientProgramInformation extends \SheepItNmArMiscModel
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_program_informacio';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    /**
     * Modelhez tartozó 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'programinformation',
            'class_name' => 'ProgramInformation',
            'foreign_key' => 'program_informacio_id',
            'read_only' => true
        ),
        array(
            'client',
            'class_name' => 'Client',
            'foreign_key' => 'ugyfel_id'
        )
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'program_informacio_id',
            'message' => 'A program információ megadása kötelező!'
        )
    );
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return null;
    }
    /**
     * Visszatér az id mező nevével.
     * @return string
     */
    protected function fieldId()
    {
        return 'program_informacio_id';
    }
    /**
     * Visszatér a név mező nevével.
     * @return string
     */
    protected function fieldName()
    {
        return 'program_informacio_nev';
    }
    /**
     * Visszatér a kapcsolat objektummal.
     * @return \ProgramInformation
     */
    protected function relationObject()
    {
        return $this->programinformation;
    }
}