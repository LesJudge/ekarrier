<?php
include_once "page/all/model/page.list_model.php";
class Munkakor_Kereso_Model extends Page_List_Model
{
    /**
     * Inicializálja a modelt.
     */
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    
     public function __addForm()
    {
         //parent::__addForm();
     //    $this->addItem('BtnSearch');
    }
    /**
     * Lekérdezi az összes munkakör főkategóriát.
     * @return array
     * @throws Exception_MYSQL
     * @throws Exception_MYSQL_Null_Rows
     */
    public function getCategories()
    {
        $query = "SELECT 
                      mk.munkakor_kategoria_id AS id,
                      mk.kategoria_cim AS menu_nev,
                      mk.kategoria_full_link AS link,
                      mk.kategoria_link,
                      mk.baloldal,
                      mk.jobboldal,
                      (SELECT 
                              COUNT(munkakor_kategoria_id)
                          FROM
                              munkakor_kategoria
                          WHERE
                              baloldal > mk.baloldal
                              AND jobboldal < mk.jobboldal) AS cnt_munkakor
                  FROM
                      munkakor_kategoria mk
                  WHERE
                      mk.szint = 1 
                      AND mk.nyelv_id = " . Rimo::$_config->SITE_NYELV_ID . "
                      AND mk.munkakor_kategoria_aktiv = 1
                      AND mk.munkakor_kategoria_torolt = 0
                  GROUP BY mk.munkakor_kategoria_id
                  ORDER BY mk.kategoria_cim ASC";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    
}