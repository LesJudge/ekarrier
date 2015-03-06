<?php
class Ugyfeluzenetek_Show_Model extends Page_Edit_Model {
    public $_totalCompRajzViews;


    public function __construct(){
        $this->addDB("MYSQL_DB");
        
    }
    
    public function __addForm() {
        parent::__addForm();
    }
    
 
   
    
    public function addUzenet($uID, $message)
    {
       
          $query = "INSERT INTO ugyfel_attr_uzenetek
                    SET ugyfel_id =".(int)$uID.", uzenet='". mysql_real_escape_string($message)."', szerzo = 'ugyfel', bekuldes_datum = NOW()
                    " ;

            return $this->_DB->prepare($query)->query_insert();

    }
    
    public function deleteUzenet($uID, $mID)
    {
       
          $query = "UPDATE ugyfel_attr_uzenetek
                    SET ugyfel_attr_uzenetek_aktiv = 0
                    WHERE ugyfel_id = ".(int)$uID." AND ugyfel_attr_uzenetek_id = ".(int)$mID
                    ;

            return $this->_DB->prepare($query)->query_update();

    }
    
   

    
    public function getUzenetek($cID)
    {
        try
        {
            $query = "
                    SELECT ugyfel_attr_uzenetek_id AS ID, uzenet, IF(szerzo = 'ugyfel', 'Én',CONCAT(u.user_vnev,' ',u.user_knev)) AS szerzo, bekuldes_datum AS datum
                    FROM ugyfel_attr_uzenetek
                    LEFT JOIN user u ON u.user_id = ugyfel_attr_uzenetek.szerzo
                    WHERE ugyfel_id = ".(int)$cID."
                    AND ugyfel_attr_uzenetek_torolt = 0
                    AND ugyfel_attr_uzenetek_aktiv = 1"   
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }
        catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {    
        }
    }
     

    
    
}
?>