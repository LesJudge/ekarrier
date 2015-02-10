<?php
class User_KapcsolatList_Model extends Admin_List_Model
{

        public $_tableName = 'user_kapcsolat';
        public $_fields = 'user_kapcsolat.user_kapcsolat_id AS ID,
                                    user_kapcsolat.user_id,
                                    u.user_vnev,
                                    u.user_knev,
                                    user_kapcsolat.felvetel_ideje,
                                    user_kapcsolat.megjegyzes,
                                    user_kapcsolat.letrehozas_timestamp,
                                    user_kapcsolat.modositas_timestamp,
                                    user_kapcsolat.modositas_szama';
        public $_join = 'INNER JOIN user u ON u.user_id = user_kapcsolat.user_id';
        public $tableHeader = array(
                'u.user_vnev' => array(
                        'label' => 'Vezetéknév'
                ),
                'user_kapcsolat.felvetel_ideje' => array(
                        'label' => 'Felvétel ideje'
                ),
                'user_kapcsolat.megjegyzes' => array(
                        'label' => 'Megjegyzés'
                ),
                'user_kapcsolat.letrehozas_timestamp' => array(
                        'label' => 'Rögzízés ideje'
                ),
                'user_kapcsolat.modositas_timestamp' => array(
                        'label' => 'Módosítás ideje'
                )
        );

        public function __createWhere()
        {
                $felt_array = implode(" AND ", $this->listWhere);
                $this->listWhere = " WHERE {$felt_array}";
        }
        
        public function __addForm()
        {
                parent::__addForm();
                $this->_params['TxtSort']->_value = 'user_kapcsolat.felvetel_ideje__DESC';
                $userLabel = array(
                        '' => '--Válasszon felhasználót--'
                );
                $activeUsers = User::find('all', array(
                        'conditions' => array(
                                'user_aktiv' => 1,
                                'user_torolt' => 0
                        )
                ));
                $users = array();
                if(count($activeUsers) > 0)
                {
                        foreach($activeUsers as $user)
                        {
                                $users[$user->user_id] = $user->user_vnev.' '.$user->user_knev;
                        }
                }
                $this->addItem('FilterUser')->_select_value = $userLabel + $users;
        }

}