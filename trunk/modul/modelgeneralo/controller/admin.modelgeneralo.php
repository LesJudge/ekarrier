<?php
require 'modul/modulgeneralo/controller/admin.modulgeneralo.php';
/**
 * 
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Modelgeneralo_Admin_Controller extends Modulgeneralo_Admin_Controller {
    
    public $_name = 'Modelgeneralo';
    protected $templateDir = 'modul/modelgeneralo/template';

    public function __construct() {
        parent::__construct();
    }
    
    public function onClick_New() {
        try{
            $params = $this->_model->_params;
            $modulnev = $params['TxtModulNev']->_value; // Ez alapján vizsgálja a modul létezését.
            $modelnev = $params['TxtModelNev']->_value; // A modell neve.
            $tablanev = $params['TxtTablaNev']->_value; // A tábla neve.
            $publikusnev = $params['TxtPublikusNev']->_value; // A model publikus neve.
            $function_azon = strtolower($modelnev); // A funkció azonosítója.
            // Megvizsgálja, hogy a modul létezik-e az adatbázisban. Ha igen, Exception_MYSQL kivételt dob.
            if(!$this->_model->moduleExists($modulnev))
                throw new Exception_MYSQL('A modul nem létezik az adatbázisban');
            if($this->_model->functionExists($modulnev, $function_azon))
                throw new Exception_Form_Error('A model már létezik!');
            // Fájlok generálása.
            $this->generateFiles();
            //throw new Exception_MYSQL('Meg akarok állni');
            // Tranzakció indítása.
            $this->_model->_DB->prepare('BEGIN')->query_execute();
            // Tábla generálása.
            $this->_model->createTable($tablanev);
            // Funkciók regisztrálása.
            $functionData = array('modul_azon' => $modulnev, 'modul_function_azon' => $function_azon, 'modul_function_nev' => $publikusnev);
            // Ha a modul funkció nem létezik
            if(!$this->_model->functionExists($modulnev, $function_azon)){
                $functionIDs = array();
                $functionIDs[0] = $this->_model->registerFunctions($functionData);
                $functionIDs[1] = $this->_model->registerFunctions($functionData, false);
                $this->_model->registerRootRight($functionIDs[0]);
                $this->_model->registerRootRight($functionIDs[1]);
                UserLoginOut_Controller::$_rights = $_SESSION['user_rights'] = $this->_model->loadRights(UserLoginOut_Controller::$_id); 
            }
            else
                throw new Exception_MYSQL('Ez a modul funkció már létezik');
            // Commit.
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            // Fájllista generálása.
            $filesList = $this->files2array($this->generatedDirs);
            $filesList .= $this->files2array($this->generatedFiles);
            // Sikeres értesítés megjelenítése.
            $this->message = "A confighoz add hozzá az alábbai sorokat:<br /><br /> '{$function_azon}' => '{$modulnev}/{$function_azon}',<br />'{$function_azon}edit' => '{$modulnev}/{$function_azon}'";
            if($this->_model->nyelvID)
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel);
            else
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel);
        }
        catch(Exception_Module_Create $e){
            $this->rollbackFiles();
            throw new Exception_Form_Error($e->getMessage());
        }
        catch(Exception_MYSQL $e){
            // Rollback.
            $this->rollbackFiles();
            $this->_model->rollbackTable($this->_model->_params['TxtTablaNev']->_value);
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error($e->getMessage());
        }
    }
    
    protected function createReplaceArray(){
        $replace = array();
        $modulNev = $this->_model->_params['TxtModulNev']->_value; // Kisbetűs modulnév
        $modelnev = $this->_model->_params['TxtModelNev']->_value;
        $tablaNev = $this->_model->_params['TxtTablaNev']->_value; // Modulhoz tartozó tábla neve
        $modulnevUpper = ucfirst($modulNev);
        $replace['modulnevUpper'] = $modulnevUpper;
        $replace['modulnev'] = $modulNev;
        $replace['tablanev'] = $tablaNev;
        $replace['modelnev'] = $modelnev;
        $replace['publikusnev'] = $this->_model->_params['TxtPublikusNev']->_value;
        $fproc = $this->_model->getFieldsProcessed($_POST['Fields'], $this->_model->_params['TxtTablaNev']->_value);
        $replace['fields'] = $fproc['fields'];
        $replace['tableHeader'] = $fproc['tableHeader'];
        $replace['addForm'] = $fproc['addForm'];
        $replace['bindArray'] = $fproc['bindArray'];
        $replace['inputHTML'] = $fproc['inputHTML'];
        $replace['scripts'] = $this->_model->getRequiredScripts();
        $replace['columns'] = $fproc['columns'];
        $replace['multilang'] = ((int)$this->_model->_params['ChkNyelvesitett']->_value === 1) ? 'true' : 'false';
        $replace['manual_validation'] = ((int)$this->_model->_params['ChkValidacio']->_value === 1) ? 'true' : 'false';
        return $replace;
    }
    
    protected function generateFilename($currentname, $replace){
        $newname = str_replace('modelgeneralo/', $replace['modulnev'].'/', $currentname);
        $newname = str_replace('template/', '', $newname);
        $newname = str_replace('modulnev', $replace['modulnev'], $newname);
        $newname = str_replace('modelnev', $replace['modelnev'], $newname);
        $newname = $this->setExtension($newname);
        return $newname;
    }


    /**
     * Törli az összes legenerált fájlt hiba esetén.
     */
    protected function rollbackFiles(){
        $files = $this->generatedFiles;
        foreach($files as $file){
            @unlink($file);
        }
    }
    
    public function __show(){
        parent::__show();
        if($this->message)
            $this->_view->assign('info', $this->message);
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/modelgeneralo/view/admin.modelgeneralo.tpl'));
    }
    
}
?>