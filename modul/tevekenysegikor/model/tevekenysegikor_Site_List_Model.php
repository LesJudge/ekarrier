<?php
class Tevekenysegikor_Site_List_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'munkakor';
    /**
     * Kiválasztott mezők.
     * @var string
     */

     public $_fields = ' munkakor.munkakor_id AS ID,
                        munkakor.munkakor_nev,
                        munkakor.munkakor_link,
                        mk.kategoria_cim AS korCim,
                        mk.munkakor_kategoria_id AS subCatID,
                        mk.kategoria_full_link AS tevkorLink,
                        mk.baloldal AS leftSide,
                        mk.jobboldal AS rightSide,
                        (
                        SELECT mk2.kategoria_cim
                            FROM munkakor_kategoria mk2
                            WHERE mk2.baloldal < leftSide AND mk2.jobboldal > rightSide
                            AND mk2.munkakor_kategoria_aktiv = 1
                            AND mk2.munkakor_kategoria_torolt = 0 AND mk2.szint=1
                        ) AS csoportCim,
                        (
                        SELECT mk3.munkakor_kategoria_ID
                            FROM munkakor_kategoria mk3
                            WHERE mk3.baloldal < leftSide AND mk3.jobboldal > rightSide
                            AND mk3.munkakor_kategoria_aktiv = 1
                            AND mk3.munkakor_kategoria_torolt = 0 AND mk3.szint=1
                        ) AS mainCatID
                      '
            ;
    
    /**
     * MySQL JOIN.
     * @var string
     */
    public $_join = 'INNER JOIN munkakor_attr_kategoria mak ON munkakor.munkakor_id = mak.munkakor_id
                     INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id AND mk.szint = 2
                     LEFT JOIN allashirdetes_attr_munkakor aam ON aam.munkakor_id = munkakor.munkakor_id
                     LEFT JOIN allashirdetes ah ON ah.allashirdetes_id = aam.allashirdetes_id
                     
                        ';
    /**
     * MySQL feltételek.
     * @var array
     */
    public $listWhere = array(
        'active' => 'munkakor_aktiv = 1',
        'notDeleted' => 'munkakor_torolt = 0',
        'x' => 'mk.szint != 0'
        
    );
    

    public function __addForm()
    {   
        
        
        $this->sortBY = "munkakor.munkakor_nev ASC";
        parent::__addForm();
        
        
        $csoport = $this->addItem('FilterCsoport');
        $csoport->_select_value = $this->getSelectValues("munkakor_kategoria", "kategoria_cim", " AND szint = 1 ", "ORDER BY kategoria_cim ASC", false, array("-1"=>"Tevékenységi csoport"));
        
        $kor = $this->addItem('FilterKor');
        $kor->_select_value = $this->getSelectValues("munkakor_kategoria", "kategoria_cim", " AND szint = 2 ", "ORDER BY kategoria_cim ASC", false, array("-1"=>"Tevékenységi kör"));
        
        $szektor = $this->addItem('FilterSzektor');
        $szektor->_select_value = $this->getSelectValues("szektor", "szektor_nev", "", "", false, array(""=>"Szektor"));
        
        $pozicio = $this->addItem('FilterPozicio');
        $pozicio->_select_value = $this->getSelectValues("pozicio", "pozicio_nev", "", "", false, array(""=>"Pozíció"));
        
        $this->addItem('TxtSearchByName');
        
    }
    
}