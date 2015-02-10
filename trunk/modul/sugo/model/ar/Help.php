<?php
/**
 * Súgó AR Model.
 */
class Help extends ArBase
{

        static $table_name='sugo';
        
        static $primary_key = array('sugo_id', 'nyelv_id');
        
        public function arBehaviors()
        {
                return array(
                        'ArTimestampBehavior' => array(
                                'createdAttribute' =>'sugo_create_date',
                                'modifiedAttribute'=>'sugo_modositas_datum'
                        ),
                        'ArAuthorBehavior' => array(
                                'creatorAttribute'     =>'sugo_letrehozo',
                                'modificatoryAttribute'=>'sugo_modosito'
                        ),
                        'ArNomBehavior' => array(
                                'nomAttribute' => 'sugo_javitas_szama'
                        ),
                        'ArLanguageBehavior' => array(
                                'langIdAttribute' => 'nyelv_id'
                        )
                );
        }

}