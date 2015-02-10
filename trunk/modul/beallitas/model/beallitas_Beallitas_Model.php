<?php
class Beallitas_Beallitas_Model extends Model
{
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
        }
        
        /**
         * Megkeresi a modulhoz tartozó feature-öket (listázó).
         * @return mixed (false|array)
         */
        public function findModuleFeatures()
        {
                try
                {
                        $query="SELECT modul_function_azon,
                                                    modul_function_nev
                                       FROM modul_function
                                       WHERE modul_function_torolt=0 AND
                                                    modul_azon='beallitas' AND
                                                    (LENGTH(modul_function_azon)>0 AND modul_function_azon NOT LIKE '%edit')
                                       ORDER BY modul_function_nev ASC";
                        return $this->_DB->prepare($query)->query_select()->query_result_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return false;
                }
        }
        
}