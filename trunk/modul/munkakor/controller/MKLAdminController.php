<?php
/**
 * Munkakör Kiegészítés List Admin Controller
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MKLAdminController extends Admin_List
{
        
        /**
         * onClick_Filter a munkakör kiegészítés admin controllerekhez.
         */
        public function onClick_Filter()
        {
                $nameFilter="munkakor_nev LIKE '%:item%' OR ".$this->_model->_tableName."_tartalom LIKE '%:item%'";
                $this->setWhereInput($nameFilter,'FilterSzuro');
                // Jóváhagyva
                $jfield=$this->_model->_tableName.'_feldolgozva';
                $this->setStatusFilter('FilterFeldolgozva',$jfield);
        }
        
        /**
         * Beállítja egy true or false filter értékét.
         * @param string $filterName => Szűrő neve
         * @param string $fieldName => Mező neve
         */
        protected function setStatusFilter($filterName,$fieldName)
        {
                $value=$this->getItemValue($filterName);
                switch($value)
                {
                        case 1:
                                $this->setWhereInput($fieldName.'=1',$filterName);
                                break;
                        case 2:
                                $this->setWhereInput($fieldName.'=0',$filterName);
                                break;
                        default:
                                unset($_SESSION[$this->_name][$filterName]);
                                break;
                }
        }
        
}