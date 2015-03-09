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
                       ugyfel_attr_vegzettseg.iskola AS iskola,
                       ugyfel_attr_vegzettseg.kezdet AS kezdet,
                       ugyfel_attr_vegzettseg.veg AS veg,
                       ugyfel_attr_vegzettseg.szak AS szak,
                       v.nev AS nev';
    /**
     * JOIN
     * @var string
     */
    public $_join = 'INNER JOIN user_ugyfel uu ON ugyfel_attr_vegzettseg.ugyfel_id = uu.ugyfel_id 
        INNER JOIN vegzettseg v ON ugyfel_attr_vegzettseg.vegzettseg_id = v.vegzettseg_id';
}