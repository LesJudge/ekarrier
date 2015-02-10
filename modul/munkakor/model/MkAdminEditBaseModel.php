<?php
/**
 * A munkakor_Edit_Model és a kompetencia_Edit_Model ősosztálya.
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
abstract class MkAdminEditBaseModel extends Admin_Edit_Model
{
        
        const ACTIVITY_NAME_MIN_LENGTH=3;
        const ACTIVITY_NAME_MAX_LENGTH=128;
        const ACITVITY_SHEEPIT_FORM_ID='sheepItForm';
        
        /**
         * Törli a munkakor_kompetencia táblából a $field, $value feltételnek megfelelő rekordokat.
         * @param string $field => Feltétel mező (munkakor_id || kompetencia_id)
         * @param int $id => Érték
         * @example $this->deleteMkValues('munkakor_id',$this->modifyID)
         * @deprecated
         */
        protected function deleteMkValues($field,$id)
        {
                $query="DELETE FROM munkakor_kompetencia WHERE {$field}=".(int)$id;
                $this->_DB->prepare($query)->query_execute();
        }
        
        /**
         * Kapcsolatok mentéséért felelős metódus.
         * Abstract metódus, minden egyes gyermek osztályban definiálni kell.
         */
        abstract protected function saveMkValues($field,$id,$values);
        
        /**
         * 
         * @param int $jobId => Munkakör azonosító.
         * @param int $compId => Kompetencia azonosító.
         * @return int
         * @throws Exception_MYSQL_Null_Rows
         * @deprecated
         */
        protected function saveMkValue($jobId,$compId)
        {
                $query="INSERT INTO munkakor_kompetencia (munkakor_id,kompetencia_id) VALUES (".(int)$jobId.",".(int)$compId.")";
                return $this->_DB->prepare($query)->query_insert();
        }

        /**
         * Visszatér a munkakörhöz tartozó kompetenciákkal / kompetenciához tartozó munkakörökkel.
         * @param string $selectField => Melyik mezőt választja ki.
         * @param string $whereField => Melyik mező értéke szerint hajtja végre a query-t.
         * @param int $id => A munkakör/kompetencia azonosítója.
         * @return array
         * @deprecated
         */
        public function getSelectedMkValues($selectField,$whereField,$id)
        {
                try
                {
                        //$query="SELECT {$selectField} FROM munkakor_kompetencia WHERE {$whereField}=".(int)$id;
                        $query="SELECT {$selectField} FROM szektor_kompetencia WHERE {$whereField}=".(int)$id;
                        $dataObj=$this->_DB->prepare($query)->query_select();
                        $returnData=array();
                        while($data=$dataObj->query_fetch_array())
                        {
                                $sid=$data[$selectField];
                                $returnData[$sid]=$sid;
                        }
                        return $returnData;
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return array();
                }
        }
        
        /**
         * Lekérdezi a munkakör tevékenységeket.
         * @param int $lId => Nyelv azonosító
         * @param boolean $isJson => JSON encode-olható legyen-e a visszatérési érték.
         * @return mixed (array|false)
         */
        public function findActivities($lId,$isJson=false)
        {
                try
                {
                        $query="SELECT munkakor_tevekenyseg_id,
                                       munkakor_tevekenyseg_nev
                                       FROM munkakor_tevekenyseg
                                       WHERE nyelv_id=".(int)$lId." AND
                                       munkakor_tevekenyseg_aktiv=1 AND
                                       munkakor_tevekenyseg_torolt=0";
                        $obj=$this->_DB->prepare($query)->query_select();
                        $returnArray=array();
                        while($data=$obj->query_fetch_array())
                        {
                                if($isJson)
                                {
                                        $returnArray[]=array(
                                                'label'=>$data['munkakor_tevekenyseg_nev'],
                                                'value'=>$data['munkakor_tevekenyseg_id']
                                        );
                                }
                                else
                                {
                                        $returnArray[$data['munkakor_tevekenyseg_id']]=$data['munkakor_tevekenyseg_nev'];
                                }
                        }
                        return $returnArray;
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return false;
                }
        }
        
        /**
         * Lekérdezi a munkakörhöz tartozó tevékenységeket és az ahhoz tartozó kompetenciát.
         * @param int $jobId => Munkakör azonosító.
         * @param int $lId => Nyelv azonosító.
         * @return mixed (array|false)
         */
        public function findRelatedActivitiesViaCompetence($jobId,$lId)
        {
                try
                {
                        $query="SELECT mhmt.munkakor_id,
                                       mhmt.tevekenyseg_id,
                                       mt.munkakor_tevekenyseg_nev,
                                       mhmt.kompetencia_id,
                                       0 AS is_new_record
                                       FROM munkakor_has_many_tevekenyseg mhmt
                                       INNER JOIN munkakor_tevekenyseg mt ON mhmt.tevekenyseg_id=mt.munkakor_tevekenyseg_id AND mt.nyelv_id=".(int)$lId."
                                       INNER JOIN kompetencia k ON mhmt.kompetencia_id=k.kompetencia_id AND k.nyelv_id=".(int)$lId."
                                       WHERE mhmt.munkakor_id=".(int)$jobId;
                        return $this->_DB->prepare($query)->query_select()->query_result_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return array();
                }
        }
        
        /**
         * Menti a tevékenységet a munkakor_tevekenyseg táblába.
         * @param string $name => A tevékenység neve.
         * @param int $lId => A tevékenység nyelvi azonosítója.
         * @param int $userId => A tevékenység létrehozójának azonosítója.
         * @return int
         */
        protected function saveActivity($name,$lId,$userId)
        {
                $query="INSERT INTO munkakor_tevekenyseg
                               (nyelv_id,munkakor_tevekenyseg_nev,munkakor_tevekenyseg_letrehozo)
                               VALUES
                               (".(int)$lId.",'".mysql_real_escape_string(trim($name))."',".(int)$userId.")";
                $id=$this->_DB->prepare($query)->query_insert();
                return $id;
        }
        
        /**
         * Menti a tevékenységet és az ahhoz tartozó kompetenciát a munkakörhöz.
         * @param int $jobId => Munkakör azonosító.
         * @param int $competenceId => Kompetencia azonosító.
         * @param int $activityId => Tevékenység azonosító.
         */
        protected function saveActivity2Job($jobId,$competenceId,$activityId)
        {
                $query="INSERT INTO munkakor_has_many_tevekenyseg
                               (munkakor_id,kompetencia_id,tevekenyseg_id)
                               VALUES
                               (".(int)$jobId.",".(int)$competenceId.",".(int)$activityId.")";
                $this->_DB->prepare($query)->query_insert();
        }
        
        /**
         * Törli a munkakörhöz tartozó tevékenységeket.
         * @param int $jobId => Munkakör azonosító.
         */
        protected function deleteActivitiesByJobId($jobId)
        {
                $query="DELETE FROM munkakor_has_many_tevekenyseg WHERE munkakor_id=".(int)$jobId;
                $this->_DB->prepare($query)->query_execute();
        }
        
        /**
         * Menti a munkakörhöz tartozó összes tevékenységet és az azokhoz tartozó kompetenciákat.
         * @param int $jobId => Munkakör azonosító.
         * @param array $activities
         * @param int $lId => Nyelv azonosító.
         * @param int $userId => Felhasználó azonosító.
         */
        protected function saveActivities($jobId,array $activities,$lId,$userId)
        {
                try
                {
                        foreach($activities as $activity)
                        {
                                if($this->validateActivity($activity))
                                {
                                        $activityId=(int)$activity['activityId'];
                                        $isNewRecord=(int)$activity['isNewRecord'];
                                        if($activityId===0 && $isNewRecord===1)
                                        {
                                                $activityId=$this->saveActivity($activity['activityName'],$lId,$userId);
                                        }
                                        $this->saveActivity2Job($jobId,$activity['competenceId'],$activityId);
                                }
                        }
                }
                catch(Exception_MYSQL_Null_Affected_Rows $e)
                {
                        throw new Exception_MYSQL('Valamilyen nem várt hiba léeptt fel a művelet során! Kérem, próbálja újra');
                }
                catch(RuntimeException $e)
                {
                        throw new Exception_MYSQL($e->getMessage());
                }
        }
        
        /**
         * Validálja a tevékenységet.
         * @param array $activity
         * @return boolean
         * @throws RuntimeException
         */
        protected function validateActivity(array $activity)
        {
                if(isset($activity['activityName']) && isset($activity['activityId']) && isset($activity['competenceId']) && isset($activity['isNewRecord']))
                {
                        $activityName=trim($activity['activityName']);
                        $activityNameLength=strlen($activityName);
                        $competenceId=(int)$activity['competenceId'];
                        if($activityNameLength < self::ACTIVITY_NAME_MIN_LENGTH && $activityNameLength > self::ACTIVITY_NAME_MAX_LENGTH)
                        {
                                throw new RuntimeException('A tevékenység neve nem megfelelő!');
                        }
                        elseif($competenceId===0)
                        {
                                throw new RuntimeException('Nem választott kompetenciát!');
                        }
                        else
                        {
                                return true;
                        }
                }
                else
                {
                        throw new RuntimeException('Hibás paraméterek!');
                }
        }
        
        
        
        
}