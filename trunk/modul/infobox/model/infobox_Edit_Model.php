<?php
class Infobox_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='infobox';
        public $_bindArray=array(
                'infobox_nev'=>'TxtNev',
                'infobox_kulcs'=>'TxtKulcs',
                'infobox_tartalom'=>'TxtTartalom',
                'infobox_aktiv'=>'ChkAktiv',
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
                        'table'=>'infobox',
                        'field'=>'infobox_kulcs',
                        'modify'=>$this->modifyID,
                        'DB'=>$this->_DB
                );
                // Tartalom
                $this->addItem('TxtTartalom')->_verify['string']=true;
        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT infobox_javitas_szama, 
                                            DATE_FORMAT(infobox_create_date,'%Y-%m-%d %H:%i') AS infobox_create_date, 
                                            DATE_FORMAT(infobox_modositas_datum,'%Y-%m-%d %H:%i') AS infobox_modositas_datum, 
                                            u1.user_fnev AS infobox_letrehozo, 
                                            u2.user_fnev AS infobox_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON infobox_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON infobox_modosito=u2.user_id
                               WHERE infobox_id='{$this->modifyID}' AND 
                                            infobox.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',infobox_modositas_datum=now()
                                              ,infobox_javitas_szama=infobox_javitas_szama+1
                                              ,infobox_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',infobox_letrehozo='.UserLoginOut_Controller::$_id);
        }



        public function infoboxAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Az infobox nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}