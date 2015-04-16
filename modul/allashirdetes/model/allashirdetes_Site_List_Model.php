<?php
/**
 * Álláshirdetés site listázás model.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Allashirdetes_Site_List_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'allashirdetes';
    /**
     * Kiválasztott mezők.
     * @var string
     */
    public $_fields = 'allashirdetes.allashirdetes_id,
                      allashirdetes.link,
                      allashirdetes.megnevezes,
                      allashirdetes.ellenorzott,
                      cv.cim_varos_nev,
                      cm.cim_megye_nev,
                      munkakor.munkakor_nev AS munkakor,
                      mk2.kategoria_cim AS tevKor,
                      mk2.munkakor_kategoria_id AS tevKorID,
                      (
                      SELECT kategoria_cim
                      FROM munkakor_kategoria mkin
                      WHERE mkin.baloldal < mk2.baloldal AND mkin.jobboldal > mk2.jobboldal AND mkin.szint = 1
                      LIMIT 1
                        ) AS tevCsoport,
                      (
                      SELECT munkakor_kategoria_id
                      FROM munkakor_kategoria mkin
                      WHERE mkin.baloldal < mk2.baloldal AND mkin.jobboldal > mk2.jobboldal AND mkin.szint = 1
                      LIMIT 1
                        ) AS tevCsoportID,
                        c.ceg_id AS cegID,
                        c.nev AS cegNev,
                        c.link AS cegLink

                        ';
    /**
     * MySQL JOIN
     * @var string
     */
    public $_join = 'LEFT JOIN cim_varos cv ON allashirdetes.cim_varos_id = cv.cim_varos_id 
                    LEFT JOIN cim_megye cm ON cv.cim_megye_id = cm.cim_megye_id
                    LEFT JOIN allashirdetes_attr_munkakor ON allashirdetes_attr_munkakor.allashirdetes_id = allashirdetes.allashirdetes_id
                    LEFT JOIN munkakor ON munkakor.munkakor_id = allashirdetes_attr_munkakor.munkakor_id
                    LEFT JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = allashirdetes_attr_munkakor.munkakor_id
                    LEFT JOIN munkakor_kategoria mk2 ON mk2.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id AND mk2.szint = 2
                    INNER JOIN ceg c ON c.ceg_id = allashirdetes.ceg_id
                    ';
    /**
     * Szűrési feltételeket tartalmazó tömb.
     * @var array
     */
    public $listWhere = array(
        'allashirdetes_aktiv = 1',
        'allashirdetes_torolt = 0',
    );
    /**
     * Form generálás.
     */
    public function __addForm()
    {
        parent::__addForm();
        // Szektor szűrő elem.
        $this->addItem('FilterSector')->_select_value = $this->getSelectValues(
            'szektor',
            'szektor_nev',
            ' AND szektor_aktiv = 1 AND szektor_torolt = 0',
            ' ORDER BY szektor_nev ASC',
            false,
            array('' => '--Válasszon szektort!--')
        );
        // Pozíció szűrő elem.
        $this->addItem('FilterPosition')->_select_value = $this->getSelectValues(
            'pozicio',
            'pozicio_nev',
            ' AND pozicio_aktiv = 1 AND pozicio_torolt = 0',
            ' ORDER BY pozicio_nev ASC',
            false, 
            array('' => '--Válasszon pozíciót!--')
        );
        // Munkakör szűrő elem.
       /* $this->addItem('FilterJob')->_select_value =  $this->getSelectValues(
            'munkakor',
            'munkakor_nev',
            ' AND munkakor_aktiv = 1 AND munkakor_torolt = 0',
            ' ORDER BY munkakor_nev ASC',
            false,
            array('' => '--Válasszon munkakört!--')
        );*/
        // Megyék lekérdezése.
        try {
            $countyQuery = "SELECT cim_megye_id, cim_megye_nev FROM cim_megye ORDER BY cim_megye_nev ASC";
            $countyResult = $this->_DB->prepare($countyQuery)->query_select();
            $counties = array();
            while ($data = $countyResult->query_fetch_array()) {
                $counties[$data['cim_megye_id']] = $data['cim_megye_nev'];
            }
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            $counties = array();
        }
        // Megye szűrő elem.
        $this->addItem('FilterCounty')->_select_value = array('' => '--Válasszon megyét!--') + $counties;
        // Város szűrő elem.
        $this->addItem('FilterCity');
        $this->addItem('FilterLetter');
        // Ellenőrzött szűrő.
        $fe = $this->addItem('FilterEllenorzott');
        $fe->_select_value = array(
            2 => '--Ellenőrzött',
            0 => 'Nem',
            1 => 'Igen'
        );
        $fe->_value = 2;
        
        //Tevcsoport azűrő
        $this->addItem('FilterTevCsoport')->_select_value = $this->getSelectValues('munkakor_kategoria',
                        'kategoria_cim',
                        ' AND munkakor_kategoria_aktiv = 1 AND munkakor_kategoria_torolt = 0 AND szint = 1',
                        'ORDER BY munkakor_kategoria_id ASC',
                        false,
                        array('-1' => '--Válasszon tevékenységi csoportot!--'));
        
        //Tevkör azűrő
        $this->addItem('FilterTevKor')->_select_value = $this->getSelectValues('munkakor_kategoria',
                        'kategoria_cim',
                        ' AND munkakor_kategoria_aktiv = 1 AND munkakor_kategoria_torolt = 0 AND szint = 2',
                        'ORDER BY munkakor_kategoria_id ASC',
                        false,
                        array('-1' => '--Válasszon tevékenységi kört!--'));
        
    }
    
    
}