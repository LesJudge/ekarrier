<?php
require 'modul/modulgeneralo/model/modulgeneralo_Generator_Model.php';
/**
 * 
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Modelgeneralo_Generator_Model extends Modulgeneralo_Generator_Model{
    
    public $_bindArray = array(
        'modelgeneralo_modulnev' => 'TxtModulNev',
        'modelgeneralo_tablanev' => 'TxtTablaNev',
        'modelgeneralo_publikusnev' => 'TxtPublikusNev',
    );
    
    public function __addForm(){
        //parent::__addForm();
        // Modul neve
        $modulnev = $this->addItem('TxtModulNev');
        $modulnev->_verify['required'] = true;
        $modulnev->_verify['pattern'] = array(
            'pattern' => self::PATTERN,
            'value' => true,
            'message' => 'A modul név nem illik a megadott mintára!',
        );
        $modulnev->_verify['isDir'] = array(
            'dirRoute' => 'modul/',
            'value' => true,
            'message' => 'A megadott könyvtár nem létezik, ezért nem hozhatod létre a modelt!',
        );
        // Model neve
        $modelnev = $this->addItem('TxtModelNev');
        $modelnev->_verify['string'] = true;
        //$modelnev->_verify['required'] = true;
        //$modelnev->_verify['pattern'] = self::PATTERN;
        // Tábla neve
        $tablanev = $this->addItem('TxtTablaNev');
        $tablanev->_verify['string'] = true;
        //$tablanev->_verify['required'] = true;
        //$tablanev->_verify['pattern'] = self::PATTERN;
        // Publikus név
        $publikusnev = $this->addItem('TxtPublikusNev');
        $publikusnev->_verify['string'] = true;
        // Form elemek inicializálása.
        $this->fieldFormInit();
    }
    
    public function __newData()
    {
        parent::__newData();
    }
    
    /**
     * Megvizsgálja, hogy a paraméterül adott modulhoz tartozik-e hasonló funkciónév, mint ami a 2. paraméterben található.
     *  
     * @param string $modul_azon => A modul azonosítója.
     * @param string $modul_function_azon => A modul funkció azonosítója.
     * @return boolean
     */
    public function functionExists($modul_azon, $modul_function_azon){
        try{
            $query = "SELECT modul_function_azon AS mfa 
                      FROM modul_function 
                      WHERE modul_azon LIKE '".mysql_real_escape_string($modul_azon)."' AND 
                            modul_function_azon LIKE '".mysql_real_escape_string($modul_function_azon)."'";
            $this->_DB->prepare($query)->query_select();
            return true;
        }
        catch(Exception_MYSQL $e){
            return false;
        }
    }

}
?>