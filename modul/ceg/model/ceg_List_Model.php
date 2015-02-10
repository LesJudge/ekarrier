<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Ceg_List_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ceg';
    /**
     * Mezők.
     * @var string
     */
    public $_fields = 'ceg.ceg_id AS ID,
                       ceg.nev AS elso,
                       ceg.letrehozas_timestamp,
                       ceg.modositas_timestamp, 
                       ceg.megtekintve,
                       ceg.modositas_szama,
                       ceg.ceg_aktiv AS Aktiv, 
                       creator.user_id AS creator_id, 
                       creator.user_fnev AS creator_username, 
                       creator.user_vnev AS creator_lastname, 
                       creator.user_knev AS creator_firstname, 
                       modificatory.user_id AS modificatory_id, 
                       modificatory.user_fnev AS modificatory_username, 
                       modificatory.user_vnev AS modificatory_lastname, 
                       modificatory.user_knev AS modificatory_firstname';
    public $_join = 'LEFT JOIN user creator ON creator.user_id = ceg.letrehozo_id
                     LEFT JOIN user modificatory ON modificatory.user_id = ceg.modosito_id';
   
    public function __addForm()
    {
        parent::__addForm();
        $this->tableHeader = array(
            'ceg.nev' => array(
                'label' => 'Név',
                'width' => 30
            ),
            'ceg.letrehozo_id' => array(
                'label' => 'Létrehozó'
            ),
            'ceg.letrehozas_timestamp' => array(
                'label' => 'Létrehozás ideje'
            ),
            'ceg.modosito_id' => array(
                'label' => 'Módosító'
            ),
            'ceg.modositas_timestamp' => array(
                'label' => 'Módosítás ideje'
            ),
            'ceg.megtekintve' => array(
                'label' => 'Megtekintve'
            ),
            'ceg.ceg_aktiv' => array(
                'label' => 'Közzétéve',
                'width' => 8
            )
        );
        $this->_params['TxtSort']->_value = 'ceg.nev__ASC';
        $this->addItem('FilterStatus')->_select_value = Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
    }
}