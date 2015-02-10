<?php
class Munkakor_TartKieg_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='munkakor_tartalom_kiegeszites';
        public $_bindArray=array();

        public function __addForm()
        {
                $this->bindArray();
                parent::__addForm();
                // Aktuális tartalom
                $this->addItem('TxtAktTartalom')->_verify['string']=true;
                // Tartalom
                $this->addItem('TxtTartalom')->_verify['string']=true;
                // Feldolgozva
                $processed=$this->addItem('ChkFeldolgozva');
                $processed->_select_value=Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        }

        protected function bindArray()
        {
                $this->_bindArray[$this->_tableName.'_tartalom']='TxtTartalom';
                $this->_bindArray[$this->_tableName.'_aktiv']='ChkAktiv';
                $this->_bindArray[$this->_tableName.'_feldolgozva']='ChkFeldolgozva';
        }

        public function __formValues()
        {
                parent::__formValues();
                $jobData=$this->getActualJobData($this->modifyID,Rimo::$_config->ADMIN_NYELV_ID);
                $this->_params['TxtAktTartalom']->_value=$jobData['tartalom'];
        }

        public function __update()
        {
                $lId=Rimo::$_config->ADMIN_NYELV_ID;
                $jobData=$this->getActualJobData($this->modifyID,$lId);
                $this->saveContent2Job($jobData['munkakor_id'],$lId);
                parent::__update(','.$this->_tableName.'_modositas_datum=now()
                                              ,'.$this->_tableName.'_javitas_szama='.$this->_tableName.'_javitas_szama+1
                                              ,'.$this->_tableName.'_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                throw new Exception_MYSQL('Nem vihet fel új rekordot!');
        }
        
        /**
         * Lekérdezi az aktuális munka adatait.
         * @param int $rowId => Rekord azonosító
         * @param int $lId => Nyelv azonosító
         * @return array
         */
        protected function getActualJobData($rowId,$lId)
        {

                $query="SELECT m.munkakor_id,
                                            m.munkakor_nev,
                                            m.munkakor_tartalom AS tartalom
                               FROM munkakor_tartalom_kiegeszites mtk
                               INNER JOIN munkakor m ON m.munkakor_id=mtk.munkakor_id AND m.nyelv_id=mtk.nyelv_id
                               WHERE mtk.munkakor_tartalom_kiegeszites_id=".(int)$rowId." AND
                                            mtk.nyelv_id=".(int)$lId."
                               LIMIT 1";
                return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        }
        
        /**
         * Menti a tartalmat.
         * @param int $jobId => Munkakör azonosító
         * @param int $lId => Nyelv azonosító
         */
        protected function saveContent2Job($jobId,$lId)
        {
                $query="UPDATE munkakor SET munkakor_tartalom='".mysql_real_escape_string($this->getItemValue('TxtAktTartalom'))."'
                               WHERE munkakor_id=".(int)$jobId." AND
                                            nyelv_id=".(int)$lId."
                               LIMIT 1";
                $this->_DB->prepare($query)->query_update();
        }

}