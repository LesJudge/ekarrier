<?php
class Kompetenciarajzkereso_Site_List_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'kompetenciarajz';
    /**
     * Kiválasztott mezők.
     * @var string
     */

     public $_fields = 'kompetenciarajz.kompetenciarajz_id AS krID,
                        u.ugyfel_id AS uID,
                        mk.baloldal AS leftSide,
                        mk.jobboldal AS rightSide,
                        uat.tevkor_id,
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
    public $_join = 'INNER JOIN ugyfel u ON u.ugyfel_id = kompetenciarajz.ugyfel_id
                     LEFT JOIN ugyfel_attr_tevkor uat ON uat.kompetenciarajz_id = kompetenciarajz.kompetenciarajz_id
                     LEFT JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = uat.tevkor_id
                     LEFT JOIN munkakor_attr_kategoria mak ON mak.munkakor_attr_kategoria_id = mk.munkakor_kategoria_id
                     LEFT JOIN munkakor m ON m.munkakor_id = mak.munkakor_id
                     /*LEFT JOIN ugyfel u2 ON u2.ugyfel_id = kompetenciarajz.ugyfel_id*/
                     LEFT JOIN ugyfel_attr_allashirdetes_megjelolt uaam ON uaam.kompetenciarajz_id = kompetenciarajz.kompetenciarajz_id
                     LEFT JOIN allashirdetes a ON a.allashirdetes_id = uaam.allashirdetes_id
                     LEFT JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = a.allashirdetes_id
                     LEFT JOIN munkakor m2 ON m2.munkakor_id = aam.munkakor_id
                     LEFT JOIN munkakor_attr_kategoria mak2 ON mak2.munkakor_id = m2.munkakor_id
                     LEFT JOIN munkakor_kategoria mkx ON mkx.munkakor_kategoria_id = mak2.munkakor_attr_kategoria_id
                     
                     
                        ';
    /**
     * MySQL feltételek.
     * @var array
     */
    public $listWhere = array(
        'active' => 'u.ugyfel_aktiv = 1',
        'notDeleted' => 'u.ugyfel_torolt = 0',
        //'x' => 'mk.szint != 0'
        
    );
    

    public function __addForm()
    {   
        
        
       // $this->sortBY = "munkakor.munkakor_nev ASC";
        parent::__addForm();
        
        $munkakor = $this->addItem('FilterMunkakor');
        
        $csoport = $this->addItem('FilterCsoport');
        $csoport->_select_value = $this->getSelectValues("munkakor_kategoria", "kategoria_cim", " AND szint = 1 ", "ORDER BY kategoria_cim ASC", false, array("-1"=>"--Válasszon--"));
        
        $kor = $this->addItem('FilterKor');
        $kor->_select_value = $this->getSelectValues("munkakor_kategoria", "kategoria_cim", " AND szint = 2 ", "ORDER BY kategoria_cim ASC", false, array("-1"=>"--Válasszon--"));
        
        $szektor = $this->addItem('FilterSzektor');
        $szektor->_select_value = $this->getSelectValues("szektor", "szektor_nev", "", "", false, array(""=>"--Válasszon--"));
        
        $pozicio = $this->addItem('FilterPozicio');
        $pozicio->_select_value = $this->getSelectValues("pozicio", "pozicio_nev", "", "", false, array(""=>"--Válasszon--"));
        
        
    }
    
    public function createFolder($companyID, $name)
    {
        $query = "INSERT INTO ceg_attr_mappa SET ceg_id = ".(int)$companyID.", mappa_nev = '".  mysql_real_escape_string($name)."'";
        $this->_DB->prepare($query)->query_insert();
    }
    
    public function checkIfFolderExistsByName($companyID, $name)
       {
           try
           {
            $query = "SELECT mappa_nev FROM ceg_attr_mappa WHERE mappa_nev = '".  mysql_real_escape_string($name)."' AND ceg_id = ".(int)$companyID;
            $this->_DB->prepare($query)->query_select();
            return true;
           } catch (Exception_MYSQL_Null_Rows $e) {
               return false;
           }
       }
       
   public function getFolders($companyID)
   {
      return $this->getSelectValues('ceg_attr_mappa', 
                                          'mappa_nev', 
                                          ' AND ceg_id = '.(int)$companyID.' ', 
                                          '', 
                                          false, 
                                          array('' => '--Válasszon!--'));
        
   }
   
   public function addDrawsToFolder($folderID, $draws)
   {
       foreach ($draws as $key => $value) {
           $query = "INSERT INTO ceg_attr_mappa_kompetenciarajz SET mappa_id = ".(int)$folderID.", kompetenciarajz_id = ".(int)$value." ON DUPLICATE KEY UPDATE kompetenciarajz_id = ".(int)$value;
               $this->_DB->prepare($query)->query_insert();
       }
       
   }
    
}