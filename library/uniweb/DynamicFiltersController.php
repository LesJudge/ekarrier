<?php
/**
 * Dinamikus szűrő controller.
 * 
 * @property DynamicFiltersModel $_model Dinamikus szűrő model.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
abstract class DynamicFiltersController extends Admin_List
{
    /**
     * Dinamikus szűrők beállítása.
     * @return void
     */
    abstract protected function setDynamicFilters();
    /**
     * Betölti a modelt.
     * @param string $class_prefix Model neve.
     * @return void
     * @throws RuntimeException
     */
    public function __loadModel($class_prefix = '')
    {
        // Betölti a modelt.
        require 'modul/' . Rimo::$_config->APP_PATH . '/model/' . Rimo::$_config->APP_PATH . $class_prefix . '_Model.php';
        $className = ucfirst(Rimo::$_config->APP_PATH) . $class_prefix . '_Model'; // Model név "Rimosítása".
        //$instance = new $className($this->_name);
        //if ($instance instanceof DynamicFiltersModel) {
        if (is_subclass_of($className, 'DynamicFiltersModel')) { // Megvizsgálja, hogy a DynamicFiltersModel gyermeke-e.
            $this->_model = new $className($this->_name); // Példányosítja.
        } else { // Ha nem, akkor pedig kivételt dob.
            throw new RuntimeException('A modelnek a DynamicFiltersModel-ből kell származnia!');
        }
    }
    /**
     * Szűrő metódus.
     * @return void
     */
    public function onClick_Filter()
    {
        $this->setDynamicFilters();
    }
    /**
     * Kiegészíti az aktív dinamikus filterekkel a nézetet.
     * @return void
     */
    public function __show()
    {
        parent::__show();
        $this->_view->assign('activeDynamicFilters', $this->_model->serializeActiveDynamicFilters());
    }
    /**
     * Beállítja a dinamikus szűrőt.
     * @param string $filter Dinamikus szűrő neve.
     * @param string $condition Dinamikus szűrőhöz tartozó feltétel.
     */
    protected function setDynamicFilter($filter, $condition)
    {
        $this->_model->setDynamicFilter($filter, $condition, $this->_action_type);
    }
    /**
     * Beállítja a dinamikus szűrőt Closure-ön keresztül.
     * @param string $filter Dinamikus szűrő neve.
     * @param Closure $closure Closure, ami tartalmazza a dinamikus szűrő beállítását.
     * @return void
     */
    protected function setDynamicFilterViaClosure($filter, Closure $closure)
    {
        $this->_model->setDynamicFilterViaClosure($filter, $closure, $this->_action_type);
    }
}