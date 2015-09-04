<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';

class UgyfellinkekEdit_Admin_Controller extends Admin_Edit
{

        public $_name='UgyfellinkekEdit';

        public function __construct()
        {
                $this->__loadModel('_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                
                if($this->_model->modifyID && $this->_model->_params['TxtTipus']->_value == 'ugyfel'){
                    $this->_view->assign('tipus','ugyfel');
                }elseif($this->_model->modifyID && $this->_model->_params['TxtTipus']->_value == 'sajat'){
                    $this->_view->assign('tipus','sajat');
                }
                
                if(!$this->_model->modifyID){
                    $this->_view->assign('mode','new');
                }else{
                    $content = $this->getContent($this->_model->modifyID, $this->_model->_params['SelKat']->_value);
                    $this->_view->assign('content',$content);
                    $this->_view->assign('mode','modify');
                }
                
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/ugyfellinkek/view/admin.ugyfellinkek_edit.tpl'));
        }

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                $this->_view->assign('ugyfellinkek_allapot',$this->_model->linkAllapot());
        }
        
        public function getContent($id,$cat){
            try{
                $field = "";
                
                switch ($cat){
                    case 'kompetencia':
                        $field = 'kompetencia_tartalom';
                        break;
                    case 'pozicio':
                        $field = 'pozicio_leiras';
                        break;
                    case 'szektor':
                        $field = 'szektor_leiras';
                        break;
                }
                
                
                $query = "SELECT ".mysql_real_escape_string($field)." AS leiras, ".mysql_real_escape_string($cat)."_nev AS nev
                            FROM ".mysql_real_escape_string($cat)."
                          INNER JOIN ugyfel_attr_linkek ual ON ual.id_in_category = ".mysql_real_escape_string($cat)."_id
                          WHERE ual.ugyfel_attr_linkek_id = ".(int)$id."
                          LIMIT 1";
                
                return $this->_model->_DB->prepare($query)->query_select()->query_fetch_array();
                
            }catch(Exception_MYSQL_Null_Rows $e){
                
            }catch(Exception_MYSQL $e){
                
            }
        }

}