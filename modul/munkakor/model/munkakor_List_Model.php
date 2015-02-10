<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Munkakor_List_Model extends Admin_List_Model
{

        public $_tableName='munkakor';
        public $_fields='munkakor.munkakor_id AS ID,
                                  munkakor_nev AS elso,
                                  IF(munkakor_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(munkakor_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  munkakor_create_date AS letrehozva,
                                  IF(munkakor_modositas_datum=0,\'Nem lett módosítva!\',munkakor_modositas_datum) AS modositva,
                                  munkakor_megtekintve,
                                  munkakor_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=munkakor_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=munkakor_modosito
                               LEFT JOIN munkakor_attr_kategoria ON munkakor_attr_kategoria.munkakor_id=munkakor.munkakor_id';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'munkakor_nev'=>array('label'=>'Név', 'width'=>42),
                        'munkakor_letrehozo'=>array('label'=>'Létrehozó'),
                        'munkakor_letrehozva'=>array('label'=>'Létrehozás ideje'),
                        'munkakor_modosito'=>array('label'=>'Módosító'),
                        'munkakor_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'munkakor_megtekintve'=>array('label'=>'Megtekintve'),
                        'munkakor_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='munkakor_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
                $kategoria_filter=$this->addItem('FilterKategoria');
                $kategoria_filter->_select_value=$this->getKategoriaSelectValues();
        }

        private function getKategoriaSelectValues()
        {
                try
                {
                        $query="SELECT munkakor_kategoria_id AS id,   
                                                    kategoria_cim AS name,    
                                                    szint AS depth,
                                                    baloldal as bal,
                                                    jobboldal AS jobb
                                       FROM  munkakor_kategoria    
                                       WHERE nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID."   
                                       GROUP BY munkakor_kategoria_id   
                                       ORDER BY baloldal";
                        $list[0]='--Válasszon kategóriát--';
                        $obj=$this->_DB->prepare($query)->query_select();
                        while($adat=$obj->query_fetch_array())
                        {
                                $added='';
                                for($i=0; $i<$adat['depth']; $i++)
                                {
                                        $added .= '--';
                                }
                                if($adat['depth']==0)
                                {
                                        $list[$adat['id']]='<'.$adat['name'].'>';
                                }
                                else
                                {
                                        $list[$adat['id']]=$added.' '.$adat['name'];
                                }
                        }
                        return $list;
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return array('--Hírek oldal--');
                }
                catch(Exception_MYSQL $e)
                {
                        return array(0=>'HIBA');
                }
        }

}