<?php
class Tevekenysegikor_Ajax_List_Model extends Model{
    
    public function __construct()
    {
        $this->addDB("MYSQL_DB");
    }        

    public function filterByGroup($id)
    {
        try
        {
            $query = "SELECT mk.munkakor_kategoria_id AS ID
                      FROM munkakor_kategoria mk
                      WHERE mk.szint = 2 AND mk.baloldal >
                
                        (SELECT mk1.baloldal AS leftside
                      FROM munkakor_kategoria AS mk1
                      WHERE mk1.munkakor_kategoria_id = ".mysql_real_escape_string((int)$id).")
                          
                      AND mk.jobboldal <
                          
                      (SELECT mk1.jobboldal AS rightside
                      FROM munkakor_kategoria AS mk1
                      WHERE mk1.munkakor_kategoria_id = ".mysql_real_escape_string((int)$id).")"
                    ;
            
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }
        catch(Exception_MYSQL $e)
        {
            return false;
        }
    }
    
    public function filterByCircle($id)
    {
        try
        {
            $query = "SELECT munkakor_kategoria_id AS ID
                      FROM munkakor_kategoria 
                      WHERE szint = 1 AND baloldal < 
                            (SELECT mk1.baloldal AS leftside
                            FROM munkakor_kategoria AS mk1
                            WHERE mk1.munkakor_kategoria_id = ".mysql_real_escape_string((int)$id).")

                            AND jobboldal >
                            
                            (SELECT mk1.jobboldal AS rightside
                            FROM munkakor_kategoria AS mk1
                            WHERE mk1.munkakor_kategoria_id = ".mysql_real_escape_string((int)$id).")
                            LIMIT 1
                        "
                    ;
            
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }
        catch(Exception_MYSQL $e)
        {
            //return $e->getMessage();
            return false;
        }
    }
    
    
}
?>