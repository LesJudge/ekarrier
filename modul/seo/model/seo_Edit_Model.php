<?php
class Seo_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='seo';
        public $_bindArray=array(
                'seo_nev'=>'TxtNev',
                'seo_kulcs'=>'TxtKulcs',
                'seo_leiras'=>'TxtLeiras',
                'seo_meta_kulcsszo'=>'TxtKulcsszo',
                'seo_aktiv'=>'ChkAktiv',
        );

        public function __addForm()
        {
                parent::__addForm();
                // Név
                $this->addItem('TxtNev')->_verify['string']=true;
                // Link
                $link=$this->addItem('TxtKulcs');
                $link->_verify['string']=true;
                $link->_verify['unique']=array(
                        'table'=>'seo',
                        'field'=>'seo_kulcs',
                        'modify'=>$this->modifyID,
                        'DB'=>$this->_DB
                );
                // Leírás
                $this->addItem('TxtLeiras')->_verify['string']=true;
                // Kulcsszó
                $this->addItem('TxtKulcsszo')->_verify['required']=true;
        }

        public function deleteMegtekintes()
        {
                $query="UPDATE {$this->_tableName} SET seo_megtekintve=0
                              WHERE seo_id='{$this->modifyID}' AND 
                                           nyelv_id='{$this->nyelvID}'
                              LIMIT 1";
                $this->_DB->prepare($query)->query_update();
        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT seo_megtekintve,
                                            seo_javitas_szama, 
                                            DATE_FORMAT(seo_create_date,'%Y-%m-%d %H:%i') AS seo_create_date, 
                                            DATE_FORMAT(seo_modositas_datum,'%Y-%m-%d %H:%i') AS seo_modositas_datum, 
                                            u1.user_fnev AS seo_letrehozo, 
                                            u2.user_fnev AS seo_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON seo_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON seo_modosito=u2.user_id
                               WHERE seo_id='{$this->modifyID}' AND 
                                            seo.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',seo_modositas_datum=now()
                                              ,seo_javitas_szama=seo_javitas_szama+1
                                              ,seo_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',seo_letrehozo='.UserLoginOut_Controller::$_id);
        }



        public function seoAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A cég nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}