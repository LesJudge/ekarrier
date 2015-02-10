<?php
class Beallitas_TevekenysegEdit_Model extends Admin_Edit_Model
{

        public $_tableName='munkakor_tevekenyseg';
        public $_bindArray=array(
                'munkakor_tevekenyseg_nev'=>'TxtNev',
                'munkakor_tevekenyseg_aktiv'=>'ChkAktiv',
        );

        public function __addForm()
        {
                parent::__addForm();
                // Név
                $this->addItem('TxtNev')->_verify['string']=true;
        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT munkakor_tevekenyseg_modositas_szama, 
                                            DATE_FORMAT(munkakor_tevekenyseg_letrehozas_datum,'%Y-%m-%d %H:%i') AS munkakor_tevekenyseg_create_date, 
                                            DATE_FORMAT(munkakor_tevekenyseg_modositas_datum,'%Y-%m-%d %H:%i') AS munkakor_tevekenyseg_modositas_datum, 
                                            u1.user_fnev AS munkakor_tevekenyseg_letrehozo, 
                                            u2.user_fnev AS munkakor_tevekenyseg_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON munkakor_tevekenyseg_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON munkakor_tevekenyseg_modosito=u2.user_id
                               WHERE munkakor_tevekenyseg_id='{$this->modifyID}' AND 
                                            munkakor_tevekenyseg.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',munkakor_tevekenyseg_modositas_datum=now()
                                              ,munkakor_tevekenyseg_modositas_szama=munkakor_tevekenyseg_modositas_szama+1
                                              ,munkakor_tevekenyseg_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',munkakor_tevekenyseg_letrehozo='.UserLoginOut_Controller::$_id);
        }


        public function tevekenysegAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Nem jelenik meg!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}