<?php
class User_KapcsolatEdit_Model extends Admin_Edit_Model
{

        public $_tableName = 'user_kapcsolat';
        public $_bindArray=array(
                'user_id' => 'SelUser',
                'felvetel_ideje' => 'DateTimeFelvetel',
                'megjegyzes' => 'TxtMegjegyzes'
        );

        public function __addForm()
        {
                parent::__addForm();
                // SelUser
                $selUser = $this->addItem('SelUser');
                $selUser->_verify['select'] = true;
                $query = "SELECT user_id, user_vnev, user_knev FROM user WHERE user_aktiv = 1 AND user_torolt = 0 ORDER BY user_vnev ASC";
                $users = $this->_DB->prepare($query)->query_select()->query_result_array();
                $label = array('' => '--Kérem, válasszon!--');
                $options = array();
                foreach($users as $user)
                {
                        $options[$user['user_id']] = $user['user_vnev'].' '.$user['user_knev'];
                }
                $selUser->_select_value = $label + $options;
                // DateTimeFelvetel
                $dateTimeFelv = $this->addItem('DateTimeFelvetel');
                $dateTimeFelv->_verify['string'] = true;
                $dateTimeFelv->_verify['datetime'] = true;
                // TxtMegjegyzes
                $this->addItem('TxtMegjegyzes');
        }

        public function __update()
        {
                parent::__update(', 
                        modositas_timestamp = NOW(),
                        modosito_id = '.(int)UserLoginOut_Admin_Controller::$_id.',
                        modositas_szama = modositas_szama +1 
                ');
        }

        public function __insert()
        {
                $userId = (int)UserLoginOut_Admin_Controller::$_id;
                parent::__insert(',
                        letrehozo_id='.$userId.',
                        modosito_id='.$userId
                );
        }

}