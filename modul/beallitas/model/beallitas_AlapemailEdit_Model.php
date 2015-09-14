<?php
class Beallitas_AlapemailEdit_Model extends Admin_Edit_Model
{

        public $_tableName='beallitas_email';
        public $_bindArray=array(
                'beallitas_email_email'=>'TxtEmail',
                'beallitas_email_aktiv'=>'ChkAktiv',
        );

        public function __addForm()
        {
                parent::__addForm();
                // Név
                $email = $this->addItem('TxtEmail');
                $email->_verify['string']=true;
                $email->_verify['email']=true;
        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT 
                                            DATE_FORMAT(beallitas_email_modositas_datum,'%Y-%m-%d %H:%i') AS beallitas_email_modositas_datum, 
                                            u2.user_fnev AS beallitas_email_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u2 ON beallitas_email_modosito=u2.user_id
                               WHERE beallitas_email_id='{$this->modifyID}' AND 
                                            beallitas_email.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(
                        ',beallitas_email_modositas_datum=now()
                        ,beallitas_email_modosito='.UserLoginOut_Controller::$_id
                        
                );
        }

        public function __insert()
        {
                parent::__insert(
                        //',iparag_letrehozo='.UserLoginOut_Controller::$_id
                        );
        }

        public function emailAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Az email nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}