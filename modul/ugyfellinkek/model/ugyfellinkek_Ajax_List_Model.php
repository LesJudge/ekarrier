<?php
class Ugyfellinkek_Ajax_List_Model extends Model{
    
    public function __construct()
    {
        $this->addDB("MYSQL_DB");
    }        

    public function filterByGroup($category)
    {
        $category = mysql_real_escape_string($category);
        try
        {
            $query = "SELECT ".$category."_id AS ID, ".$category."_nev AS nev
                      FROM ".$category."
                      WHERE ".$category."_aktiv = 1 AND ".$category."_torolt = 0
                    ";
            
            if($category == 'kompetencia'){
                $query.=" AND tipus = 'sajat'";
            }
            
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }
        catch(Exception_MYSQL $e)
        {
            return false;
        }
    }
    
    
}
?>