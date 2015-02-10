<?php
class User_Vegzettseg_SiteList_Model extends Page_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ugyfel_attr_vegzettseg';
    /**
     *
     * @var kiválasztott mezők.
     */
    public $_fields = 'ugyfel_attr_vegzettseg.ugyfel_attr_vegzettseg_id AS pk,
                       ugyfel_attr_vegzettseg.ugyfel_id,
                       ugyfel_attr_vegzettseg.vegzettseg_id,
                       ugyfel_attr_vegzettseg.ugyfel_attr_vegzettseg_iskola AS iskola,
                       ugyfel_attr_vegzettseg.ugyfel_attr_vegzettseg_kezdet AS kezdet,
                       ugyfel_attr_vegzettseg.ugyfel_attr_vegzettseg_veg AS veg,
                       ugyfel_attr_vegzettseg.ugyfel_attr_vegzettseg_szak AS szak,
                       v.vegzettseg_nev AS vegzettseg_nev';
    /**
     * JOIN
     * @var string
     */
    public $_join = 'INNER JOIN user_ugyfel uu ON ugyfel_attr_vegzettseg.ugyfel_id = uu.ugyfel_id 
        INNER JOIN vegzettseg v ON ugyfel_attr_vegzettseg.vegzettseg_id = v.vegzettseg_id';
}