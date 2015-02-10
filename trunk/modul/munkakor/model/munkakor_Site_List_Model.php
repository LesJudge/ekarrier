<?php
class Munkakor_Site_List_Model extends Admin_List_Model
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
    public $_fields = 'munkakor.munkakor_nev, munkakor.munkakor_link';
    /**
     * MySQL JOIN.
     * @var string
     */
    public $_join = 'INNER JOIN munkakor_attr_kategoria mak ON munkakor.munkakor_id = mak.munkakor_id';
    /**
     * MySQL feltételek.
     * @var array
     */
    public $listWhere = array(
        'active' => 'munkakor_aktiv = 1',
        'notDeleted' => 'munkakor_torolt = 0'
    );
    /**
     * Munkakör kategória SEO elemei.
     * @var array
     */
    public $seoData = array();
    public $parents;
    public function __addForm()
    {   
        parent::__addForm();
        
        // Lekérdezi a főkategóriát, valamint az abba tartozó alkategóriákat, amivel visszatér.
        $categories = $this->findCategory($_GET['caturl']);
        $this->getSubCategoriesAndParents($categories);
        
        // Leszűri a kategória azonosítókat az $ids tömbbe.
        if (!empty($categories)) {
            $ids = array_map(function($data) {
                return (int)$data['munkakor_kategoria_id'];
            }, $categories);
            $condition = 'mak.munkakor_attr_kategoria_id IN (' . implode(',', $ids) . ')';
        } else {
            $condition = 'mak.munkakor_attr_kategoria_id = NULL'; // NULL sort adó feltétel.
        }
        // Szűri a munkaköröket a főkategóriába tartozó munkakörökre.
        $this->listWhere['FilterKategoriak'] = $condition;
        // Szűrő elkészítése az alkategóriákra.
        
        $subCat = $this->addItem('FilterKategoriak');
        $subCat->_select_value = $categories;
        
        $searchName=$this->addItem('TxtSearchByName');
        
        
    }
    /**
     * Munkakör kategória alapján lekérdezi a munkakör kategóriát, valamint visszatér az ahhoz tartozó munkakörökkel.
     * @param string $link Munkakör kategória link.
     * @return array
     * @throws Exception_MYSQL
     * @throws Exception_404
     */
    protected function findCategory($link)
    {
        try {
            /*$mcQuery = "SELECT 
                          kategoria_cim, kategoria_leiras, kategoria_meta_kulcsszo, baloldal, jobboldal
                      FROM
                          munkakor_kategoria
                      WHERE
                          kategoria_link LIKE '" . mysql_real_escape_string($link) . "'
                              AND munkakor_kategoria_aktiv = 1
                              AND munkakor_kategoria_torolt = 0";*/
            $mcQuery = "SELECT 
                          kategoria_cim, kategoria_leiras, kategoria_meta_kulcsszo, baloldal, jobboldal
                      FROM
                          munkakor_kategoria
                      WHERE
                          munkakor_kategoria_aktiv = 1
                              AND munkakor_kategoria_torolt = 0 AND szint=1";
            
            $main = $this->_DB->prepare($mcQuery)->query_select()->query_fetch_array();
            $this->seoData = $main;
            try {
              /*  $subCatQuery = "SELECT munkakor_kategoria_id, kategoria_cim 
                             FROM munkakor_kategoria 
                             WHERE baloldal > " . $main['baloldal'] . " AND 
                                   jobboldal < " . $main['jobboldal']. " ORDER BY kategoria_cim ASC";*/
                $subCatQuery = "SELECT munkakor_kategoria_id, kategoria_cim, baloldal, jobboldal
                             FROM munkakor_kategoria 
                             WHERE szint=2
                             ORDER BY kategoria_cim ASC";
                $categories = $this->_DB->prepare($subCatQuery)->query_select()->query_result_array();
                return $categories;
            } catch (Exception_MYSQL_Null_Rows $emnr) {
                return array();
            }
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            throw new Exception_404;
        }
    }
    
    public function getSubCategoriesAndParents($arr){
        $obj=array();
        
        foreach ($arr as $key => $value) {
            $result=$this->getParent($value['baloldal'],$value['jobboldal']);
            //echo $result[0]['munkakor_kategoria_id'];
            $obj[$result[0]['munkakor_kategoria_id']]['ids'][]=$value['munkakor_kategoria_id'];
            $obj[$result[0]['munkakor_kategoria_id']]['cim']=$result[0]['kategoria_cim'];
        }
        $this->parents=$obj;
        
    }
    
    public function getParent($left, $right){
        try{
            $query="SELECT munkakor_kategoria_id, kategoria_cim
                    FROM munkakor_kategoria
                    WHERE baloldal < ".$left." AND jobboldal > ".$right."
                    AND munkakor_kategoria_aktiv = 1
                    AND munkakor_kategoria_torolt = 0 AND szint=1"
            ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            throw new Exception_404;
        }
        
    }
}