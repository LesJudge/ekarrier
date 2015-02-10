<?php
// Controller
require 'library/uniweb/controller/ActionController.php';
// Exceptions
require 'library/uniweb/exceptions/ArBehaviorException.php';
// JsonHelper
require 'library/uniweb/JsonHelper.php';
// AR Behavior
require 'library/uniweb/ar/ArBehavior.php';
require 'library/uniweb/ar/behavior/ArTimestampBehavior.php';
require 'library/uniweb/ar/behavior/ArAuthorBehavior.php';
require 'library/uniweb/ar/behavior/ArNomBehavior.php';
require 'library/uniweb/ar/behavior/ArLanguageBehavior.php';
// AR
require 'library/uniweb/ar/ISheepItAble.php';
require 'library/uniweb/ar/ArBase.php';
require 'library/uniweb/ar/ArHelper.php';
// Beállítás
require 'modul/beallitas/model/ar/Education.php';
// Nyelvtudás
require 'modul/nyelvtudas/model/ar/KnowledgeLanguage.php';
require 'modul/nyelvtudas/model/ar/KnowledgeLevel.php';
// User
require 'modul/user/model/ar/User.php';
require 'modul/user/model/ar/UserEducation.php';
require 'modul/user/model/ar/LaborMarket.php';
require 'modul/user/model/ar/UserKnowledge.php';
require 'modul/user/model/ar/UCKnowledge.php';
require 'modul/user/model/ar/ProjectInformation.php';
// User cím
require 'modul/user_cim/model/ar/UserAddress.php';
// Képzés
require 'modul/kepzes/model/ar/Training.php';
// Szolgáltatás
require 'modul/szolgaltatas/model/ar/Service.php';

require 'library/uniweb/smarty/ArErrorRenderer.php';
/**
 * @property Smarty $_view Smarty
 */
class UserManage_Admin_Controller extends ActionController
{

    protected $defaultAction = 'actionCreate';

    public function actionIndex()
    {
        echo __METHOD__;
        exit;
    }
    /**
     * Felhasználó létrehozása action.
     * @return void
     */
    public function actionCreate()
    {
        /* @var $user User */
        $user = new User;
        
        // Test case
        $user->user_vnev = 'Teszt';
        $user->user_knev = 'Felhasználó';
        $user->user_email = 'tesztfelhasznalo@tesztfelhasznalo.hu';
        $user->user_tel = 'Telefonszám';
        $user->user_lakcim = 'Lakcím lakcím lakcím';
        $user->user_szul_hely = 'Születési hely';
        $user->user_szul_date = '1975-05-10';
        
        /* @var $laborMarket LaborMarket */
        $laborMarket = new LaborMarket;
        /* @var $projInfo ProjectInformation */
        $projInfo = new ProjectInformation;
        // Nyelvtudás.
        $knowledges = (isset($_POST['knowledges'])) ? $_POST['knowledges'] : array();
        // Végzettségek.
        $educations = (isset($_POST['educations'])) ? $_POST['educations'] : array();
        // Ha van POST kérés és egyeznek a jelszavak.
        if ($this->isValidEditRequest()) {
            // Értékek beállítása.
            $user->set_attributes($_POST['user']);
            $laborMarket->set_attributes($_POST['laborMarket']);
            $projInfo->set_attributes($_POST['projInfo']);
            // Validáció - Erre itt azért van szükség, hogy minden hibaüzenet megjelenjen a felhasználónak!
            $userValid = $user->is_valid();
            $laborMarket->is_valid();
            $projInfo->is_valid();
            if ($userValid) {
                //var_dump('TRANSACTION BEGIN');
                try {
                    User::transaction(function() use ($user, $laborMarket, $projInfo, &$knowledges, &$educations) {
                        $userTr = $user->save();
                        if ($userTr) {
                            // Munkaerő piaci helyzet mentése.
                            $laborMarket->user_id = $user->user_id;
                            $lmTr = $laborMarket->save();
                            // Project információ mentése.
                            $projInfo->user_id = $user->user_id;
                            $piTr = $projInfo->save();
                            // UserParams
                            $userParams = array(
                                'user_id' => $user->user_id
                            );
                            // Nyelvtudás mentése.
                            $knowTr = is_array($knowledges) ? UserKnowledge::saveSheepItKnowledges(
                                $knowledges, $userParams
                            ) : true;
                            // Végzettség mentése.
                            $eduTr = is_array($educations) ? UserEducation::saveSheepItEducations(
                                $educations, $userParams
                            ) : true;
                        }
                        //var_dump($userTr);
                        //var_dump($lmTr);
                        //var_dump($laborMarket->errors);
                        //var_dump($piTr);
                        //var_dump($projInfo->errors);
                        //var_dump($knowTr);
                        //var_dump($eduTr);
                        
                        // Only for test!
                        //return false;
                        
                        // Ha minden érték true, akkor commit-ol, ha nem, akkor pedig rollback-el.
                        return $userTr && $lmTr && $piTr && $knowTr && $eduTr;
                    });
                } catch (\ActiveRecord\DatabaseException $dbex) { // Ha ismeretlen adatbázis hiba lép fel.
                    echo $dbex->getMessage();
                } catch (\PDOException $pdoex) {
                    echo $pdoex->getMessage();
                }                
            }  
        }
        // Modellek és egyéb értékek átadása a nézetnek.
        $this->_view->assign('edit_mode', 'Új felhasználó');
        $this->_view->assign('user', $user);
        $this->_view->assign('laborMarket', $laborMarket);
        $this->_view->assign('projInfo', $projInfo);
        //var_dump($knowledges);
        //var_dump(ArHelper::serializeSheepItForms($educations));
        //var_dump(ArHelper::serializeSheepItForms($educations));
        $this->_view->assign('knowledges', !$knowledges ? $knowledges : ArHelper::serializeSheepItForms($knowledges));
        $this->_view->assign('educations', !$educations ? $educations : ArHelper::serializeSheepItForms($educations));
        $this->renderForm();
    }
    /**
     * 
     * @param int $id Felhasználó azonosító.
     * @return void
     */
    public function actionUpdate($id)
    {
        try {
            $user = User::find($id);
            $laborMarket = LaborMarket::find($id);
            $projInfo = ProjectInformation::find($id);
            //var_dump($laborMarket->palyakezdo);
        } catch (\ActiveRecord\RecordNotFound $rnf) {
            //echo $rnf->getMessage();
            //exit;
        }
        $this->_view->assign('edit_mode', 'Szerkesztés');
        $this->_view->assign('user', $user);
        $this->_view->assign('laborMarket', $laborMarket);
        $this->_view->assign('projInfo', $projInfo);
        $this->renderForm();
    }
    /**
     * Rendereli a form-ot.
     * @param array $data
     */
    private function renderForm(array $data = array())
    {
        // Ennek majd át kell kerülnie a core-ba!
        $this->_view->addPluginsDir('library/uniweb/smarty/plugins/');
        $this->_view->loadPlugin('Smarty_Function_Ar_Error');
        // Végzettségek.
        $edus = Education::findAllActiveNotDeleted();
        $educationsAc = ArHelper::result2Array($edus, Education::patternIdNamePairs());
        // Nyelvtudás nyelvek.
        $langs = KnowledgeLanguage::findAllActiveNotDeleted();
        $langsAc = ArHelper::result2Array($langs, KnowledgeLanguage::patternIdNamePairs());
        // Nyelvtudás szintek.
        $levels = KnowledgeLevel::findAllActiveNotDeleted();
        $levelsAc = ArHelper::result2Array($levels, KnowledgeLevel::patternIdNamePairs());
        // Select aktív értékek.
        $activeValues = Rimo::$_config->AktivSelectValues[Rimo::$_config->SITE_NYELV_ID];
        // Render
        $this->_view->assign('educationsAc', $educationsAc);
        $this->_view->assign('langsAc', $langsAc);
        $this->_view->assign('levelsAc', $levelsAc);
        $this->_view->assign('tabsFullPath', $this->getTabsPath());
        $this->_view->assign('activeValues', $activeValues);
        $this->_view->assign('languages', array(
                1 => 'Magyar',
                2 => 'Angol'
        ));
        $this->_view->assign('userGroups',
                             array(
                1 => 'Root',
                2 => 'Regisztrált'
        ));
        $this->_view->assign('activeGroups', array(
                //1,
                //2
        ));
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/user/view/admin.user_edit.tpl'));
    }
    /**
     * Megvizsgálja, hogy megfelelő create/update kérés érkezett-e.
     * @return boolean
     */
    private function isValidEditRequest()
    {
        return isset($_POST['user'])
               &&
               isset($_POST['passwordAgain'])
               &&
               isset($_POST['laborMarket'])
               &&
               isset($_POST['projInfo'])
               &&
               $_POST['user']['user_jelszo'] === $_POST['passwordAgain'];
    }
    /**
     * Visszatér a tab nézetek elérési útjával.
     * @return string
     */
    private function getTabsPath()
    {
        $pathinfo = pathinfo(__DIR__);
        $tabsPath = 'view/partial/admin/user_edit/tabs';
        return $pathinfo['dirname'] . '/' . $tabsPath;
    }

}