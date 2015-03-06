<?php
class Szektorteszt_Show_Model extends Model {
   
    private $mainResKat;
    private $contents = array();
    private $kompetenciak = array();
    private $wordsFirstKat = array('szabadság',
                                    'önállóság',
                                    'önmenedzselés',
                                    'főnök-mentes',
                                    'magányos tigris',
                                    'multitasking',
                                    'osztott figyelem',
                                    'proaktív',
                                    'családias',
                                    'erős vezér',
                                    'érzékeny',
                                    'csapatjáték',
                                    'delfin csapat',
                                    'stabil',
                                    'szakmai fejlődés',
                                    'szervezeti kultúra',
                                    'karrier',
                                    'fegyelmezett',
                                    'versengés',
                                    'technokrata',
                                    'farkas falka',
                                    'forrásfüggő',
                                    'változatos',
                                    'társadalmi',
                                    'hivatástudat',
                                    'családbarát',
                                    'demokratikus',
                                    'segítő',
                                    'zsiráf család',
                                    'biztonságos',
                                    'monoton',
                                    'beszabályozott',
                                    'reaktív',
                                    'kiszámíthatóság',
                                    'autokrata',
                                    'kimért',
                                    'bölénycsorda'
        );
    
    private $wordsSecondKat = array('kapcsolat sakkozás',
                                    'szétforgácsoló',
                                    'nyomasztó felelősség',
                                    'karrier barrier',
                                    'önkényesség',
                                    "a szakmaiság másodlagos",
                                    "Hibákat kereső",
                                    "személytelen",
                                    "sznobizmus",
                                    "bizonytalan",
                                    "mérsékelt társadalmi presztízs",
                                    "folyamatos alkalmazkodást igényel (megújulási kényszer)",
                                    "Felelősség sakkozás",
                                    "Bürokrata",
                                    "senkiség-érzés"
        );
    
    
    
    
    private $rules = array("0"=>array("0"=>"0",
                                   "3"=>"2"),
                         "1"=>array("0"=>"0",
                                   "3"=>"1",
                                   "1"=>"3",
                                   "2"=>"4"),
                        "2"=>array("0"=>"0",
                                   "1"=>"1",
                                   "2"=>"2",
                                   "3"=>"3",
                                   "4"=>"4"),
                        "3"=>array("0"=>"0",
                                   "3"=>"3"),
                        "4"=>array("0"=>"0"),
                        "5"=>array("0"=>"0",
                                   "3"=>"1",
                                   "1"=>"2",
                                   "2"=>"3"),
                        "6"=>array("0"=>"0",
                                   "3"=>"1",
                                   "1"=>"2",
                                   "2"=>"2"),
                        "7"=>array("0"=>"0",
                                   "2"=>"1",
                                   "3"=>"2",
                                   "1"=>"2"),
                        "8"=>array("1"=>"0",
                                   "3"=>"1",
                                   "2"=>"4"),
                        "9"=>array("1"=>"0",
                                   "4"=>"1",
                                   "2"=>"2"),
                        "10"=>array("1"=>"0",
                                   "0"=>"1",
                                   "3"=>"2",
                                   "2"=>"3"),
                         "11"=>array("1"=>"0",
                                   "2"=>"1",
                                   "3"=>"2",),
                        "12"=>array("1"=>"0",
                                   "3"=>"3",),
                        "13"=>array("2"=>"0",
                                   "4"=>"1",
                                    "3"=>"2",),
                        "14"=>array("2"=>"0",
                                   "3"=>"1",
                                   "4"=>"2",
                                    "1"=>"3"),
                        "15"=>array("2"=>"0",
                                   "1"=>"1",
                                   "4"=>"4"),
                        "16"=>array("2"=>"0",
                                   "1"=>"2",
                                   "4"=>"3"),
                        "17"=>array("2"=>"0",
                                   "4"=>"1",
                                   "1"=>"2"),
                        "18"=>array("2"=>"0",
                                   "1"=>"1",
                                   "0"=>"2"),
                        "19"=>array("2"=>"0",
                                   "1"=>"3"),
                        "20"=>array("2"=>"0",
                                   "1"=>"2"),
                        "21"=>array("3"=>"0",
                                   "0"=>"2",
                                    "1"=>"3",
                                    "2"=>"4"),
                        "22"=>array("3"=>"0",
                                   "0"=>"1",
                                    "1"=>"2",
                                    "2"=>"4"),
                        "23"=>array("3"=>"0",
                                   "4"=>"1",
                                    "2"=>"4"),
                        "24"=>array("3"=>"0",
                                   "4"=>"2"),
                        "25"=>array("3"=>"0",
                                   "0"=>"2",
                                    "2"=>"4"),
                        "26"=>array("3"=>"0",
                                   "0"=>"1",
                                    "2"=>"4"),
                        "27"=>array("3"=>"0",
                                   "4"=>"2",
                                    "2"=>"3",),
                        "28"=>array("3"=>"0"),
                        "29"=>array("4"=>"0",
                                   "2"=>"2"),
                        "30"=>array("4"=>"0",
                                   "2"=>"2",
                                    "1"=>"2"),
                        "31"=>array("4"=>"0",
                                   "2"=>"1",
                                    "1"=>"2"),
                        "32"=>array("4"=>"0"),
                        "33"=>array("4"=>"0",
                                   "2"=>"1",
                                    "1"=>"3"),
                        "34"=>array("4"=>"0",
                                   "1"=>"1",
                                    "2"=>"2",
                                    "3"=>"3"),
                        "35"=>array("4"=>"0"),
                        "36"=>array("4"=>"0")
        
        );
    
    private $rules2 = array("0"=>array("0"=>"0",
                                   "2"=>"1",
                                   "1"=>"1",
                                   "4"=>"2",
                                   "3"=>"3"),
                         "1"=>array("0"=>"0",
                                   "1"=>"1",
                                   "2"=>"2",
                                   "3"=>"2"),
                        "2"=>array("0"=>"0",
                                   "1"=>"3",
                                   "2"=>"4"),
                        "3"=>array("1"=>"0",
                                   "4"=>"1",
                                   "3"=>"2",
                                   "0"=>"2"),
                        "4"=>array("1"=>"0",
                                   "4"=>"1",
                                   "2"=>"2",
                                   "3"=>"3"),
                        "5"=>array("1"=>"0",
                                   "2"=>"1",
                                   "4"=>"2"),
                        "6"=>array("2"=>"0",
                                   "1"=>"1",
                                   "4"=>"2"),
                        "7"=>array("2"=>"0",
                                   "4"=>"2"),
                        "8"=>array("2"=>"0"),
                        "9"=>array("3"=>"0",
                                   "0"=>"1",
                                   "1"=>"2",
                                   "2"=>"4"),
                        "10"=>array("3"=>"0",
                                   "4"=>"1",
                                   "0"=>"3",
                                   "1"=>"4"),
                        "11"=>array("3"=>"0",
                                   "0"=>"1",
                                   "1"=>"2"),
                        "12"=>array("4"=>"0"),
                        "13"=>array("4"=>"0",
                                    "2"=>"1"),
                        "14"=>array("4"=>"0",
                                   "2"=>"3",
                                   "1"=>"4")
        );
    
    
    
    
    private $multipliers = array(1,0.7,0.5,0.3,0.2);
    
    
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    public function getFirstKat(){
        return $this->wordsFirstKat;
    }
    public function getSecondKat(){
        return $this->wordsSecondKat;
    }
    public function getMainResKat(){
        return $this->getMainResKatFromDB();
    }
    public function setMainResKat($index,$index2,$val){
        $this->mainResKat[$index][$index2]=$val;
    }
    public function setKompetenciak($index,$index2,$val){
        $this->kompetenciak[$index][$index2]=$val;
    }
    public function getRules(){
        return $this->rules;
    }
    public function getRules2(){
        return $this->rules2;
    }
    public function getMultips(){
        return $this->multipliers;
    }
    public function getContents($index){
        return $this->contents[$index];
    }
    public function getKompetenciak(){
        return $this->getKompetenciakFromDB();
    }
    public function setContents($index,$val){
        $this->contents[$index]=$val;
    }

    public function getMainResKatFromDB(){
       
        $query = "
                SELECT szektor_id, szektor_nev, szektor_leiras
                FROM szektor 
                WHERE szektor_torolt = '0' AND szektor_aktiv = '1'
         ";
        
        $result=$this->_DB->prepare($query)->query_select()->query_result_array();
        
        foreach ($result as $key => $value) {
            $this->setMainResKat($key, "szektor_nev", $result[$key]['szektor_nev']);
            $this->setMainResKat($key, "szektor_id", $result[$key]['szektor_id']);
            $this->setMainResKat($key, "szektor_leiras", $result[$key]['szektor_leiras']);
            //$this->setContents($key, $result[$key]['szektor_nev']." ".$result[$key]['szektor_leiras']);
            $this->setContents($key, $result[$key]['szektor_nev']);
        }
        return $this->mainResKat;
   }
    
    public function getResultTartalom($id,$score){
        return $this->getContents($id);
    }

    public function getKompetenciakFromDB(){
       try
        {
            $query = "
                SELECT kompetencia.kompetencia_nev, kompetencia.kompetencia_tartalom, szektor.szektor_id, kompetencia.kompetencia_id
                FROM kompetencia
                INNER JOIN szektor_kompetencia ON kompetencia.kompetencia_id = szektor_kompetencia.kompetencia_id
                INNER JOIN szektor ON szektor.szektor_id = szektor_kompetencia.szektor_id
                WHERE kompetencia_torolt =  '0' AND szektor_torolt =  '0'
                ORDER BY szektor_id
            "; 
            $result = $this->_DB->prepare($query)->query_select()->query_result_array();
       
            
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        
        
       
       foreach ($result as $key => $value) {
           $this->setKompetenciak($key,"szektorid", $result[$key]['szektor_id']);
           $this->setKompetenciak($key,"nev", $result[$key]['kompetencia_nev']);
           $this->setKompetenciak($key,"tartalom", $result[$key]['kompetencia_tartalom']);
           $this->setKompetenciak($key,"kompetenciaid", $result[$key]['kompetencia_id']);
       }
       return $this->kompetenciak;
   }
    
   
   
    public function getFinal($arr){
      
        $score=rtrim($arr,'_');
        $score=explode("_", $score);
        $scoreArr=array();
        $kompetenciak = $this->getKompetenciak();

        foreach ($score as $key => $value){
            $a=explode("=", $value);
            $scoreArr[$a[0]]=$a[1];
        }
        arsort($scoreArr);
                
        $finalResArr=array();
        $MainResKat=$this->getMainResKat();
        
        $i=0;
        foreach ($scoreArr as $key => $value){
            $kompArr=array();
            foreach ($kompetenciak as $key1 => $value1){
                if($kompetenciak[$key1]['szektorid']==$MainResKat[$key]['szektor_id']){
                    $kompArr[$kompetenciak[$key1]['kompetenciaid']]="
                                <div id='opener".$key1."' class='opener'>".$kompetenciak[$key1]["nev"]."</div><input type='hidden' name='".$kompetenciak[$key1]['kompetenciaid']."' value='".$kompetenciak[$key1]['kompetenciaid']."'>
                                <div id='opener".$key1."_nev' class='hidden'>".$kompetenciak[$key1]["nev"]."</div>
                                <div id='opener".$key1."_tartalom' class='hidden'>".$kompetenciak[$key1]["tartalom"]."</div>"
                            ;
                 }
            }
            $finalResArr[$i]["szektor_id"]=$MainResKat[$key]['szektor_id'];
            $finalResArr[$i]["eredmeny"]=$this->getResultTartalom($key, $value);
            $finalResArr[$i]["leiras"]=$this->mainResKat[$key]['szektor_leiras'];
            $finalResArr[$i]["kompetencia"]=$kompArr;
            $i++;
        }
    return $finalResArr;
    }
}
?>