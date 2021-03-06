<?php

class Munkakor_Ajax_Model extends AjaxModel
{
    const CACHE_KEY_MAIN = 'jobMainCategories';
    const CACHE_KEY_SUB_PREFIX = 'jobSubCategory';
    const CACHE_KEY_JOB_PREFIX = 'jobBySubAutoComplete';
    const CACHE_KEY_JOB_CLIENT = 'jobDataForClient';

    /**
     * Lekérdezi az összes munkakör főkategóriát.
     * @return array
     */
    public function findAllMainCategory()
    {
        try {
            return $this->theResult(self::CACHE_KEY_MAIN, self::CACHE_MAX_AGE, function($model) {
                $query = "SELECT 
                            munkakor_kategoria_id, kategoria_cim
                          FROM munkakor_kategoria
                          WHERE szint = 1
                                AND munkakor_kategoria_aktiv = 1
                                AND munkakor_kategoria_torolt = 0
                                AND nyelv_id = 1";
                return $model->fetchThis(
                    $model->_DB->prepare($query)->query_select(), 'munkakor_kategoria_id', 'kategoria_cim'
                );                
            });
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    /**
     * Főkategória azonosító alapján lekérdezi az alkategóriákat.
     * @param int $mainId Főkategória azonosító.
     * @return array
     */
    public function findByMainId($mainId)
    {
        try {
            $mainId = (int)$mainId;
            $key = self::CACHE_KEY_SUB_PREFIX . $mainId;
            return $this->theResult($key, self::CACHE_MAX_AGE, function($model) use ($mainId) {
                $query = "SELECT 
                            t1.munkakor_kategoria_id, t1.kategoria_cim
                          FROM munkakor_kategoria t1
                          INNER JOIN munkakor_kategoria t2 ON 
                              t2.munkakor_kategoria_id = " . $mainId . " AND t2.szint = 1
                          WHERE t1.baloldal > t2.baloldal AND t1.jobboldal < t2.jobboldal";
                return $model->fetchThis(
                    $model->_DB->prepare($query)->query_select(), 'munkakor_kategoria_id', 'kategoria_cim'
                );                
            });
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    /**
     * Lekérdezi az alkategóriához tartozó munkaköröket.
     * @param int $subId Alkategória azonosító.
     * @return array
     */
    public function findBySubId($subId)
    {
        try {
            $subId = (int)$subId;
            $key = self::CACHE_KEY_JOB_PREFIX . $subId;
            return $this->theResult($key, self::CACHE_MAX_AGE, function($model) use ($subId) {
                $query = "SELECT 
                                mak.munkakor_id,
                                m.munkakor_nev
                          FROM munkakor_attr_kategoria mak
                          INNER JOIN munkakor m ON m.munkakor_id = mak.munkakor_id
                          WHERE mak.munkakor_attr_kategoria_id = " . $subId;
                return ArHelper::result2Aliases(
                    $model->_DB->prepare($query)->query_select()->query_result_array(), array(
                        array('munkakor_id', 'value'), array('munkakor_nev', 'label')
                    )
                );
            });
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    /**
     * Munkakör azonosító alapján lekérdezi a munkakör alapvető adatait. (név, azonosító, kategória nevek, azonosítók)
     * @param int $jobId Munkakör azonosító.
     * @return array
     */
    public function findJobDataWithIds($jobId)
    {
        try {
            $jobId = (int)$jobId;
            $key = self::CACHE_KEY_JOB_CLIENT . $jobId;
            return $this->theResult($key, self::CACHE_MAX_AGE, function($model) use ($jobId) {
                $query = "SELECT * FROM munkakor_view WHERE job_id = " . $jobId . " LIMIT 1";
                return $model->_DB->prepare($query)->query_select()->query_fetch_array();
            });
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    
    public function addNewMunkakor($katID,$name,$uID){
        try{
            $returnArr = array();
            if((int)$katID < 1){
                $returnArr['message'] = "Válasszon kategóriát!";
                return $returnArr;
            }
            if(strlen($name) < 5){
                $returnArr['message'] = "Adja meg a munkakör nevét! (Min. 5 karakter)";
                return $returnArr;
            }
            
            $exists = $this->checkIfMunkakorExistsInCat($name,$katID);

            if($exists === "Hiba"){
                $returnArr['message'] = "Hiba történt!";
                return $returnArr;
            }
            if ($exists === "exists"){
                $returnArr['message'] = "Már létezik ilyen nevű munkakör a kategóriában";
                return $returnArr;
            }else
            if ($exists === "notexists") {
                $query = "INSERT INTO munkakor
                            SET munkakor_nev = '".mysql_real_escape_string($name)."',
                                munkakor_create_date = NOW(),
                                munkakor_letrehozo = ".(int)$uID.", nyelv_id = 1, munkakor_link = '".Create::remove_accents(mysql_real_escape_string($name))."'
                            ";
                $ins = $this->_DB->prepare($query)->query_insert();
                
                $query = "INSERT INTO munkakor_attr_kategoria SET munkakor_id = ".(int)$ins.", munkakor_attr_kategoria_id = ".(int)$katID."";
                $this->_DB->prepare($query)->query_insert();
                
                $returnArr['message'] = "OK";
                $returnArr['ID'] = $ins;
                $returnArr['nev'] = mysql_real_escape_string($name);
                return $returnArr;
            }
            
        }catch(Exception_MYSQL $e){
            $returnArr['message'] = "Hiba történt!";
            return $returnArr;
        }
    }
    
    public function checkIfMunkakorExistsInCat($name,$katID){
        try{
            
            $query = "SELECT m.munkakor_id
                        FROM munkakor m
                        INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = m.munkakor_id
                        WHERE LOWER(m.munkakor_nev) = '".  mysql_real_escape_string(mb_strtolower($name,"UTF-8"))."' AND mak.munkakor_attr_kategoria_id = ".(int)$katID." LIMIT 1
            ";

            $ret = $this->_DB->prepare($query)->query_select()->query_fetch_array(); 
           return "exists";
        }
        catch(Exception_MYSQL_Null_Rows $e){
            return "notexists";
        }
        catch(Exception_MYSQL $e){
            return "Hiba";
        }
    }
}