<?php
class Munkavallalo_Vegzettseg_List_Model extends Page_List_Model
{
        
        public $_tableName='user_attr_vegzettseg';
        public $_fields='user_attr_vegzettseg.user_attr_vegzettseg_id AS pk,
                                  user_attr_vegzettseg.user_id,
                                  user_attr_vegzettseg.vegzettseg_id,
                                  user_attr_vegzettseg.user_attr_vegzettseg_iskola AS iskola,
                                  user_attr_vegzettseg.user_attr_vegzettseg_kezdet AS kezdet,
                                  user_attr_vegzettseg.user_attr_vegzettseg_veg AS veg,
                                  user_attr_vegzettseg.user_attr_vegzettseg_szak AS szak,
                                  user_attr_vegzettseg.user_attr_vegzettseg_aktiv AS aktiv,
                                  v.vegzettseg_nev AS vegzettseg_nev';
        public $_join='INNER JOIN vegzettseg v ON user_attr_vegzettseg.vegzettseg_id=v.vegzettseg_id';
        
        public function __construct()
        {
                parent::__construct();
        }
        
        public function __addForm()
        {
                parent::__addForm();
        }
        
}