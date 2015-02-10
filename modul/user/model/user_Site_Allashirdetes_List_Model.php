<?php
/**
 * Megjelöl álláshirdetés listázó model.
 * 
 * @property MYSQL_DB $_DB Adatbázis.
 */
class User_Site_Allashirdetes_List_Model extends Page_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ugyfel_attr_allashirdetes_megjelolt';
    /**
     * Kiválasztott mezők.
     * @var string
     */
    public $_fields = 'ugyfel_attr_allashirdetes_megjelolt.allashirdetes_id,
                       a.link,
                       a.megnevezes,
                       a.ellenorzott,
                       cv.cim_varos_nev,
                       cm.cim_megye_nev';
    /**
     * MySQL JOIN.
     * @var string
     */
    public $_join = 'INNER JOIN allashirdetes a ON ugyfel_attr_allashirdetes_megjelolt.allashirdetes_id = a.allashirdetes_id
                    LEFT JOIN cim_varos cv ON a.cim_varos_id = cv.cim_varos_id 
                    LEFT JOIN cim_megye cm ON cv.cim_megye_id = cm.cim_megye_id';
    /**
     * MySQL WHERE feltételek.
     * @var array
     */
    public $listWhere = array(
        'a.allashirdetes_aktiv = 1',
        'a.allashirdetes_torolt = 0'
    );
    
    public function __createWhere()
    {
        $this->listWhere = ' WHERE ' . implode(' AND ', $this->listWhere);
    }
    
    public function __loadList()
    {
        if(!empty($this->sortBY)){
            $order = " ORDER BY {$this->sortBY}";
        } 
        $query =  "SELECT {$this->_fields} 
                   FROM `{$this->_tableName}` 
                   {$this->_join} 
                   {$this->listWhere} GROUP BY `{$this->_tableName}`.allashirdetes_id {$order} {$this->limit}";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }

    public function __loadListCount()
    {
        $this->__createWhere();         
        $query = "SELECT COUNT(DISTINCT(`{$this->_tableName}`.allashirdetes_id)) AS cnt 
                  FROM `{$this->_tableName}` {$this->_join} {$this->listWhere}";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array('cnt');
    }
}