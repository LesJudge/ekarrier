<?php
/**
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class KnowledgeLevel extends ArEditModel
{
        
        /**
         * Visszatér a rekord létrehozásának idejét tároló mező nevével.
         * @return string
         */
        public function get_created_attribute()
        {
                return 'nyelvtudas_szint_letrehozas_datum';
        }
        /**
         * Visszatér a rekord létrehozójának azonosítóját tároló mező nevével.
         * @return string
         */
        public function get_creator_attribute()
        {
                return 'nyelvtudas_szint_letrehozo';
        }
        /**
         * Visszatér a rekord módosításanak idejét tároló mező nevével.
         * @return string
         */
        public function get_modified_attribute()
        {
                return 'nyelvtudas_szint_modositas_datum';
        }
        /**
         * Visszatér a rekord módosítójának azonosítóját tároló mezővel.
         * @return string
         */
        public function get_modificatory_attribute()
        {
                return 'nyelvtudas_szint_modosito';
        }
        /**
         * Visszatér a rekord módosítójának azonosítóját tároló mezővel.
         * @return string
         */
        public function get_nom_attribute()
        {
                return 'nyelvtudas_szint_modositas_szama';
        }
        
}