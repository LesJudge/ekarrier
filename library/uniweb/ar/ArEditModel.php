<?php
/**
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
abstract class ArEditModel extends \ActiveRecord\Model implements IArEdit
{
        
        /**
         * Új rekord mentése előtt lefutó metódus.
         */
        public function before_create()
        {
                $this->assign_attribute($this->get_created_attribute(), time());
                $this->assign_attribute($this->get_creator_attribute(), $this->get_user_id());
        }
        /**
         * Létező rekord módosítása előtt lefutó metódus.
         */
        public function before_update()
        {
                $nomAttribute = $this->get_nom_attribute();
                $this->assign_attribute($this->get_modified_attribute(), time());
                $this->assign_attribute($this->get_modificatory_attribute(), $this->get_user_id());
                $this->assign_attribute($nomAttribute, $this->read_attribute($nomAttribute) + 1);
        }
        /**
         * Visszatér a rekord módosításának idejével.
         * @return type
         */
        public function get_created()
        {
                return $this->read_attribute($this->get_created_attribute());
        }
        /**
         * Visszatér a rekord módosítójának azonosítójával.
         * @return int
         */
        public function get_creator()
        {
                return $this->read_attribute($this->get_creator_attribute());
        }
        /**
         * Visszatér a rekord módosításának idejével.
         * @return type
         */
        public function get_modified()
        {
                return $this->read_attribute($this->get_modified_attribute());
        }
        /**
         * Visszatér a rekord módosítójának azonosítójával.
         * @return int
         */
        public function get_modificatory()
        {
                return $this->read_attribute($this->get_modificatory_attribute());
        }
        /**
         * Visszatér a rekord módosításának számával.
         * @return int
         */
        public function get_number_of_modifications()
        {
                return $this->read_attribute($this->get_nom_attribute());
        }
        /**
         * Visszatér az aktuális felhasználó azonosítóval.
         * @return int
         */
        public function get_user_id()
        {
                return UserLoginOut_Controller::$_id;
        }
        
}