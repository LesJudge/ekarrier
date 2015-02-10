<?php
/**
 * JSON Helper class.
 * 
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class JsonHelper
{
        
        /**
         * JSON formátumúvá alakítja a tömböt. (sheepItForm)
         * @param array $result => Az eredményt tartalmazó tömb.
         * @param array $kvPairs => Kulcs érték párokat tartalmazó tömb. array('eredmeny_tomb_index'=>'json_tomb_index')
         * @param boolean $encode => Encode-olja-e az elkészített tömböt.
         * @return array
         */
        public static function process2JSON(array $result, array $kvPairs, $encode=false)
        {
                $outputArray=array();
                foreach($result as $r)
                {
                        $arrayItem=array();
                        foreach($r as $key=>$value)
                        {
                                if(isset($kvPairs[$key]))
                                {
                                        $arrayItem[$kvPairs[$key]]=$value;
                                }
                        }
                        $outputArray[]=$arrayItem;
                }
                return ($encode) ? json_encode($outputArray) : $outputArray;
        }
        
}