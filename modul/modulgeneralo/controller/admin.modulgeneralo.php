<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
/**
 * Rimo Modulgeneráló modul - Controller
 * 
 * @property string $_name => A form neve.
 * @property array $generatedDirs => A legenerált könyvtárak neve. Sikeres generálás esetén megjeleníti azokat.
 * @property array $generatedFiles => A legenerált fájlok neve. Sikeres generálás esetén megjeleníti azokat.
 * @property string $templateDir => A template fájlokat tartalmazó könyvtár.
 * 
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Modulgeneralo_Admin_Controller extends Page_Edit {
    
    public $_name = 'Modulgeneralo';
    public $generatedDirs = array();
    public $generatedFiles = array();
    protected $templateDir = 'modul/modulgeneralo/template';
    protected $message = false;

    public function __construct() {
        $this->__loadModel('_Generator');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function onClick_New() {
        try{
            $params = $this->_model->_params;
            $modulnev = $params['TxtModulNev']->_value; // Ez alapján vizsgálja a modul létezését.
            $tablanev = $params['TxtTablaNev']->_value; // Ez tárolja a modulhoz tartozó tábla nevét.
            $publikusnev = $params['TxtPublikusNev']->_value; // Ez tárolja a modul "publikus" nevét.
            //print_r($this->_model->rows2Fields($_POST['Fields']));
            //echo '<br /><br />';
            //print_r($this->_model->rows2addForm($_POST['Fields']));
            //$this->createModuleDirs();
            //$this->generateFiles();
            //exit;
            // Könyvtárak generálása.
            $this->createModuleDirs();
            // Fájlok generálása.
            $this->generateFiles();
            //throw new Exception_MYSQL('Csak meg akarok állni'); // Tesztelés miatt van itt.
            // Tranzakció indítása.
            $this->_model->_DB->prepare('BEGIN')->query_execute();
            // Megvizsgálja, hogy a modul létezik-e az adatbázisban. Ha igen, Exception_MYSQL kivételt dob.
            if($this->_model->moduleExists($modulnev) === true)
                throw new Exception_MYSQL('A modul már létezik az adatbázisban!');
            // Modulhoz tartozó tábla legenerálása.
            $this->_model->createTable($tablanev);
            // Modul regisztrálása.
            $modulRegData = array('modul_azon' => $modulnev, 'modul_nev' => $publikusnev);
            $this->_model->registerModul($modulRegData);
            // Modul funkcióinak regisztrálása.
            $functionIDs = array();
            $functionRegData = array('modul_azon' => $modulnev, 'modul_function_azon' => '', 'modul_function_nev' => $publikusnev);
            $functionIDs[0] = $this->_model->registerFunctions($functionRegData);
            $functionIDs[1] = $this->_model->registerFunctions($functionRegData, false);
            $this->_model->registerRootRight($functionIDs[0]);
            $this->_model->registerRootRight($functionIDs[1]);
            UserLoginOut_Controller::$_rights = $_SESSION['user_rights'] = $this->_model->loadRights(UserLoginOut_Controller::$_id); 
            // Commit.
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            // Fájllista generálása.
            $filesList = $this->files2array($this->generatedDirs);
            $filesList .= $this->files2array($this->generatedFiles);
            // Sikeres értesítés megjelenítése.
            $this->message = 'Sikeresen legeneráltad az alábbi fájlokat:<br />'.$filesList;
            if($this->_model->nyelvID)
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel);
            else
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel);    
        }
        catch(Exception_Module_Create $e){
            // Fájlok törlése.
            $this->rollbackFiles();
            throw new Exception_Form_Error($e->getMessage());
        }
        catch(Exception_MYSQL $e){
            $this->rollbackFiles(); // Fájlok törlése.
            $this->_model->rollbackTable($this->_model->_params['TxtTablaNev']->_value); // Tábla törlése. Alapértelmezett MyISAM miatt.
            $this->_model->_DB->prepare('ROLLBACK')->query_execute(); // Query rollback.
            throw new Exception_Form_Error($e->getMessage());
        }
    }
    
    /**
     * Modulhoz szükséges fájlok legenerálása.
     * @throws Exception
     */
    private function createModuleDirs(){
        // A konfigban tárolt generálandó könyvtárak nevei.
        $dirs = Rimo::$_config->DIRS;
        // A legenerált fájlokat gyűjtő tömb.
        $generatedDirs = array();
        // A generálandó modul neve, könyvtára.
        $parentDir = "modul/{$this->_params['TxtModulNev']->_value}";
        if(mkdir($parentDir, 0755, true) && is_dir($parentDir)){
            foreach($dirs as $dir){
                if(!mkdir($parentDir.'/'.$dir, 0755, true)){
                    throw new Exception_Module_Create("A '{$dir}' könyvtár generálása sikertelen");
                    break;
                }
                else
                    $generatedDirs[] = $dir;
            }
            $this->generatedDirs = $generatedDirs;
        }
        else
            throw new Exception_Module_Create("A '{$this->_params['TxtModulNev']->_value}' könyvtár generálása sikertelen");
    }
    
    /**
     * Hiba esetén törli a már legenerált fájlokat és könyvtárakat.
     */
    protected function rollbackFiles(){
        // A könyvtár neve. Megvizsgálja, hogy dir típusú-e.
        $dir = 'modul/'.$this->_params['TxtModulNev']->_value;
        // Ha igen, akkor teljesen bejárja.
        if(is_dir($dir)){
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST) as $file){
                // Aktuális fájl neve változóban tárolása.
                $pathname = $file->getPathname();
                // Ha az könyvtár, akkor az rmdir függvény fut le, ellenkező esetben pedig az unlink.
                is_dir($pathname) ? rmdir($pathname) : unlink($pathname);
            }
            // Végül törli a "gyökér" könyvtárat is.
            rmdir($dir);
        }
    }
    
    /**
     * Legenerálja a modulhoz tartozó fájlokat.
     * @throws Exception_Module_Create
     */
    protected function generateFiles(){
        $generatedFiles = array(); // Legenerált fájlok neveit tartalmazó tömb.
        $replace = $this->createReplaceArray();
        // A template könyvtár bejárása.
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->templateDir)) as $file){
            $currentname = $file->getPathname(); // Visszatér az elérési úttal.
            $filename = $this->generateFilename($currentname, $replace); // Fájlnevet generál.
            // Ha fájl.
            if(is_file($currentname)){
                // Ha a fájl nevében nem szerepel a "view" string.
                if(strpos($filename, 'view') === false)
                    $output = $this->generateViewfileContent($currentname, $replace);
                else
                    $output = $this->generatePhpfileContent($currentname, $replace);
                // Fájl létrehozása.
                if($fp = fopen($filename, 'w')){
                    fwrite($fp, $output);
                    fclose($fp);
                    $generatedFiles[] = $filename;
                }
                else
                    throw new Exception_Module_Create("A {$filename} generálása sikertelen!");
            }
        }
        $this->generatedFiles = $generatedFiles;
    }
    
    /**
     * Elkészíti a string cserékhez szükséges tömböt.
     * @return array
     */
    protected function createReplaceArray(){
        $replace = array();
        $modulNev = $this->_model->_params['TxtModulNev']->_value; // Kisbetűs modulnév
        $tablaNev = $this->_model->_params['TxtTablaNev']->_value; // Modulhoz tartozó tábla neve
        $modulnevUpper = ucfirst($modulNev);
        $replace['modulnevUpper'] = $modulnevUpper;
        $replace['modulnev'] = $modulNev;
        $replace['tablanev'] = $tablaNev;
        $replace['publikusnev'] = $this->_model->_params['TxtPublikusNev']->_value;
        $fproc = $this->_model->getFieldsProcessed($_POST['Fields'], $this->_model->_params['TxtTablaNev']->_value);
        if($fproc)
        {
            $replace['fields'] = $fproc['fields'];
            $replace['tableHeader'] = $fproc['tableHeader'];
            $replace['addForm'] = $fproc['addForm'];
            $replace['bindArray'] = $fproc['bindArray'];
            $replace['inputHTML'] = $fproc['inputHTML'];
            $replace['scripts'] = $this->_model->getRequiredScripts();
            $replace['columns'] = $fproc['columns'];
            $replace['multilang'] = ((int)$this->_model->_params['ChkNyelvesitett']->_value === 1) ? 'true' : 'false';
            $replace['manual_validation'] = ((int)$this->_model->_params['ChkValidacio']->_value === 1) ? 'true' : 'false';
        }
        return $replace;
    }
    
    /**
     * Legenerálja a fájl nevét.
     * @param string $currentname => A fájl neve.
     * @param array $replace => A cseréket tartalmazó tömb.
     * @return string
     */
    //protected function generateFilename($currentname, $modul_dir, $modul_nev){
    protected function generateFilename($currentname, $replace){
        $newname = str_replace('modulgeneralo/', $replace['modulnev'].'/', $currentname);
        $newname = str_replace('template/', '', $newname);
        $newname = str_replace('modulgeneralo', $replace['modulnev'], $newname);
        $newname = $this->setExtension($newname);
        return $newname;
    }
    
    /**
     * Beállítja a fájl megfelelő kiterjesztését.
     * @param string $filename => A fájlnév, amit át kell alakítania.
     * @return string
     */
    protected function setExtension($filename){
        if(strpos($filename, '.tpl') !== false)
            $filename = str_replace('.tpl', '.php', $filename);
        else
            $filename = str_replace ('.php', '.tpl', $filename);
        return $filename;
    }
    
    /**
     * Legenerálja a view fájl tartalmát.
     * @param string $file => Fájl neve.
     * @param array $replace2 => Értékeket tartalmazó tömb.
     * @return string
     */
    protected function generateViewfileContent($file, $replace2){
        $smarty = $this->_view;
        foreach($replace2 as $key => $value){
            $smarty->assign($key, $value);
        }
        return $smarty->fetch($file);
    }
    
    /**
     * Legenerálja a .php fájl tartalmát.
     * @param string $file => Fájl neve.
     * @param array $replace2 => Értékeket tartalmazó tömb.
     * @return string
     */
    protected function generatePhpfileContent($file, $replace2){
        $output = file_get_contents($file);
        foreach($replace2 as $key => $value){
            $output = str_replace($key, $value, $output);
        }
        return $output;
    }
    
    /**
     * A paraméterül adott fájlnevekből egy listát készít.
     * @param array $files => A fájlneveket tartalmazó tömb.
     * @return string
     */
    public function files2array($files){
        $str = '<ul>';
        foreach($files as $file){
            $str .= "<li>{$file}</li>";
        }
        $str .= '</ul>';
        return $str;
    }
    
    public function __show(){
        parent::__show();   
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/modulgeneralo/view/admin.modulgeneralo.tpl'));
    }
    
}
/**
 * Module Create Exception. A modul-és modelgeneráló használja.
 */
class Exception_Module_Create extends Exception{}
?>