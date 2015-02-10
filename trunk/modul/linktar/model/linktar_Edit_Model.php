<?php
/**
 * Linktár Edit model.
 */
class Linktar_Edit_Model extends Admin_Edit_Model{
    
    public $_tableName = 'linktar';
    
    public $_bindArray = array(
        'linktar_cim' => 'TxtNev',
        'linktar_link'=>'TxtLink',
        'linktar_aktiv' => 'ChkAktiv',
    );
    
    /**
     * Ez a metódus új elem felvitelénél mindig lefut.
     */
    public function __newData()
    {
        parent::__newData();
    }
    
    /**
     * Ez a metódus módosítás esetén mindig lefut.
     * @return array => Adatokat tartalmazó tömb.
     */
    public function __editData()
    {
        parent::__editData();
    }
    
    /**
     * Elemek hozzáadása a formhoz.
     */
    public function __addForm()
    {
        parent::__addForm();
        $this->addItem('TxtNev')->_verify['string']=true;
        $this->addItem('TxtLink')->_verify['string']=true;
        $kategoria=$this->addItem('SelKategoria');
        $kategoria->_select_value=$this->getKategoriaSelectValues();
        $kategoria->_verify['multiSelect']=true;
    }
    
    /**
     * Az itt megadott form elemeinek beállítja az értékét.
     * Sor betöltés query generálása és végrehajtása. Ezeket az értékeket beállítja a form elemeknek. 
     * 
     * @uses Model::getItemValue()
     * @uses Create::query_load_sets()
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_select()
     * @uses MYSQL_Query::query_fetch_array()
     */
    public function __formValues()
    {
        parent::__formValues();
        $this->_params['SelKategoria']->_value=$this->getSelectAktivValues('linktar_attr_kategoria'); 
    }
    
    public function __insert()
    {
        parent::__insert(",linktar_create_date=NOW() 
                          ,linktar_letrehozo=".(int)UserLoginOut_Admin_Controller::$_id);
        $this->saveCategory($this->insertID);
    }
    
    public function __update()
    {
        parent::__update(",linktar_modositas_datum=NOW() 
                          ,linktar_modosito=".(int)UserLoginOut_Admin_Controller::$_id." 
                          ,linktar_javitas_szama=(linktar_javitas_szama+1)");
        $this->saveCategory($this->modifyID);
    }
    
    private function saveCategory($linktar_id)
    {
        $this->deleteCategory($linktar_id);
        $categories=$this->_params['SelKategoria']->_value;
        if(count($categories)>0)
        {
            $linktar_id=(int)$linktar_id;
            foreach($categories as $category)
            {
                $query="INSERT INTO linktar_attr_kategoria (linktar_id,linktar_attr_kategoria_id) VALUES (".$linktar_id.",".(int)$category.")";
                $this->_DB->prepare($query)->query_insert();
            }
        }
    }
    
    private function deleteCategory($linktar_id)
    {
        $query="DELETE FROM linktar_attr_kategoria WHERE linktar_id=".(int)$linktar_id;
        $this->_DB->prepare($query)->query_execute();
    }
    
    private function getKategoriaSelectValues()
    {
        try
        {
            $query = "SELECT linktar_kategoria_id AS id,   
                             kategoria_cim AS name,    
                             szint AS depth,
                             baloldal as bal,
                             jobboldal AS jobb
                      FROM  linktar_kategoria    
                      WHERE nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID."   
                      GROUP BY linktar_kategoria_id   
                      ORDER BY baloldal";
            $obj = $this->_DB->prepare($query)->query_select();
            while($adat = $obj->query_fetch_array())
            {
                $added = "";
                for ($i = 0; $i < $adat["depth"]; $i++)
                {
                    $added .= "--";
                }
                if($adat["depth"]==0)
                {
                    $list[$adat["id"]] = "<".$adat["name"].">";    
                }
                else
                {
                    $list[$adat["id"]] = $added.$adat["name"];
                }
            }
            return $list;
        }
        catch (Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch (Exception_MYSQL $e)
        {
            return array("0" => "HIBA");
        }
    }

}
?>