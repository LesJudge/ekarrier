<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
require 'modul/munkakor/model/MkAdminEditBaseModel.php';
require 'library/uniweb/JsonHelper.php';
/**
 * @property Beallitas_TevekenysegEdit_Model $_model
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MunkakorEdit_Admin_Controller extends Admin_Edit
{

        public $_name='MunkakormEdit';

        public function __construct()
        {
                $this->__loadModel('_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__addEvent('BtnDeleteMegtekintes','DeleteMegtekintes');
                $this->__run();
        }

        public function __runParams()
        {
                parent::__runParams();
                $this->_model->removeAccentsFromLink();
                $this->_model->removeDelimitterFromKulcsszo();
        }

        public function __show()
        {
                parent::__show();
                $lId=Rimo::$_config->ADMIN_NYELV_ID;
                
                // Partial Views Directory path
                $partialViewsDir=Rimo::$_config->partialViews.DIRECTORY_SEPARATOR.'munkakoredit'.DIRECTORY_SEPARATOR;
                $this->_view->assign('partialViewsDir',$partialViewsDir);
                
                // Tevékenységek lekérdezése és hozzáadása a nézethez.
                $activities=$this->_model->findActivities($lId,true);//$activities=array('Java','PHP','JavaScript');
                $this->_view->assign('tags',json_encode($activities));
                
                // Kompetenciák lekérdezése és hozzáadása a nézethez.
                $competences=$this->_model->getSelectValues(
                        'kompetencia',
                        'kompetencia_nev',
                        ' AND kompetencia_aktiv=1 AND kompetencia_torolt=0',
                        ' ORDER BY kompetencia_nev ASC',
                        true
                );
                $this->_view->assign('competences',$competences);
                
                // Related activities
                $raKVPairs=array(
                        'tevekenyseg_id'=>'sheepItForm_#index#_activityId',
                        'munkakor_tevekenyseg_nev'=>'sheepItForm_#index#_activityName',
                        'kompetencia_id'=>'sheepItForm_#index#_competenceId',
                        'is_new_record'=>'sheepItForm_#index#_isNewRecord'
                );
                
                $relatedActivities=$this->_model->findRelatedActivitiesViaCompetence($this->_model->modifyID,$lId);
                $this->_view->assign('relatedActivities',JsonHelper::process2JSON($relatedActivities,$raKVPairs,true));
                
                // Render
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/munkakor/view/admin.munkakor_edit.tpl'));
        }

        public function onClick_DeleteMegtekintes()
        {
                $this->_model->deleteMegtekintes();
                throw new Exception_Form_Message('Sikeresen törölte a megtekintések számát.');
        }

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                $this->_view->assign('munkakor_allapot',$this->_model->munkakorAllapot());
        }

}