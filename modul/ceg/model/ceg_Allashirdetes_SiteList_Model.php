<?php

/**
 * Site álláshirdetés list model
 */
class Ceg_Allashirdetes_SiteList_Model extends Page_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'allashirdetes';
    /**
     * Mezők nevei.
     * @var string
     */
    public $_fields = 'allashirdetes.allashirdetes_id, allashirdetes.megnevezes, allashirdetes.num_megtekintve, 
        sz.szektor_nev, p.pozicio_nev, m.munkarend_nev';
    /**
     * JOIN
     * @var string
     */
    public $_join = 'INNER JOIN szektor sz ON allashirdetes.szektor_id = sz.szektor_id 
        INNER JOIN pozicio p ON allashirdetes.pozicio_id = p.pozicio_id 
        INNER JOIN munkarend m ON allashirdetes.munkarend_id = m.munkarend_id';

    public function __construct()
    {
        parent::__construct();
    }
    public function __addForm()
    {
        parent::__addForm();
    }
}