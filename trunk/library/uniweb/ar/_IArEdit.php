<?php
/**
 * ActiveRecordhoz tartozó "szerkesztő" interface.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
interface IArEdit
{
        
        /**
         * A létrehozó azonosítóját tároló mező nevével kell visszatérjen. <b>(pl. tabla_letrehozo)</b>
         */
        public function get_created_attribute();
        /**
         * A létrehozás idejét tároló mező nevével kell visszatérjen. <b>(pl. tabla_letrehozas_datum)</b>
         */  
        public function get_creator_attribute();
        /**
         * A módosító azonosítóját tároló mező nevével kell visszatérjen. <b>(pl. tabla_modosito)</b>
         */
        public function get_modified_attribute();
        /**
         * A módosítás idejét tároló mező nevével kell visszatérjen. <b>(pl. tabla_modositas_datum)</b>
         */
        public function get_modificatory_attribute();
        /**
         * A módosítás számát tároló mező nevével kell visszatérjen. <b>(pl. tabla_modositas_szama)</b>
         */
        public function get_nom_attribute();
        
}