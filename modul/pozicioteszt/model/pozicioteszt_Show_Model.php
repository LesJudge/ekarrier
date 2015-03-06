<?php
class Pozicioteszt_Show_Model extends Model {
   
    private $mainResKat;
    public  $questions = array("Ha a helyzet úgy hozza nem szívesen vállalom az irányítást, hagyom hogy vállalja más a vezetést.",
                                         "A változtatásokról mindig én értesülök legkésőbb.",
                                         "Aggódom amiatt, hogy valami elromlik, nem jól sikerül.",
                                            "Gyakori az olyan vitahelyzet, amikor utólag gondolkodva jutott eszembe, hogy kellett volna frappánsan visszaszólni a másik félnek.",
                                            "Gyorsan reagáló, gyors beszédű ember vagyok.",
                                            "Huzamosabb (3 évnél hosszabb) ideig voltam (3 főnél több alkalmazottat) irányító pozícióban.",
                                            "Igénylem a folyamatos visszajelzést a munkámról.",
                                            "Jobban szeretek egyedül dolgozni, így könnyebben megy a munka.",
                                            "Mozgalmas az életem.",
                                            "Nehéz kérdésekben kell a külső támogatás.",
                                            "Nehezen viselem, ha meg akarják mondani mit hogyan csinláljak.",
                                            "Nyugodt, kényelmes a munka- és játékstílusom.", 
                                            "Összejöveteleken hagyom, hogy mások vigyék a szót.", 
                                            "Síró embereket látva elérzékenyülök.",
                                            "Sok embert megismerek név szerint...akár évek után is.",
                                            "Szakmai tudásom, tapasztalatom magas szintű.",
                                            "Szeretem ha utolsó szó az enyém lehet.",
                                            "Szívesebben működök együtt másokkal, mint versenyzem velük.",
                                            "Többször előfordult már, hogy jobban jártak volna mások, ha az én véleményemet is megkérdezik.",
                                            "Meghatározó egyénisége voltam annak a csoportnak, amelyhez épp tartoztam.",
                                            "A magam útját járom, mintsem a csoporttal tartsak.",
                                            "Fontosnak tartom, hogy az én meglátásom is érvényesüljön a döntéseknél.",
                                            "Kedvelem a rutin feladatokat, mert hatékonyabbá tesznek."
                        );
    
    
    public $rulesVezSkill = array(              "3"=>array("2"=>"1","1"=>"2","0"=>"3"),
                                               "4" =>array("2"=>"1","1"=>"2","0"=>"3"),
                                               "5" =>array("3"=>"3","2"=>"2","1"=>"1"),
                                               "11" =>array("3"=>"3","2"=>"2","1"=>"1"),
                                               "12" =>array("2"=>"1","1"=>"2","0"=>"3"),
                                               "13" =>array("2"=>"1","1"=>"2","0"=>"3"),
                                               "14" =>array("2"=>"1","1"=>"2","0"=>"3"),
                                               "17" =>array("3"=>"3","2"=>"2","1"=>"1"),
                                               "18" =>array("2"=>"1","1"=>"2","0"=>"3"),                        
                                        );
    
    public $rulesIntrov = array(              "1"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                              "8"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                              "9"=>array("2"=>"1","1"=>"2","0"=>"3"),
                                              "13"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                              "21"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                                                      
                                        );
    
    public $rulesStatus = array(              "1"=>array("2"=>"1","1"=>"2","0"=>"3"),
                                              "6"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                              "15"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                              "19"=>array("2"=>"1","1"=>"2","0"=>"3"),
                                              "20"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                                                      
                                        );
    
    public $rulesDom = array(                 "2"=>array("2"=>"1","1"=>"2","0"=>"3"),
                                              "8"=>array("2"=>"1","1"=>"2","0"=>"3"),
                                              "9"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                              "16"=>array("3"=>"3","2"=>"2","1"=>"1"),
                                              "22"=>array("3"=>"3","2"=>"2","1"=>"1"),           
                                        );
    
    public $rulesExtra = array(         "0"=>1.5,
                                        "0.1"=>1.3,
                                        "0.2"=>1.1,
                                        "0.3"=>1,
                                        "0.4"=>0.8,
                                        "0.5"=>0.75,
                                        "0.6"=>0.8,
                                        "0.7"=>0.85,
                                        "0.8"=>0.9,
                                        "0.9"=>0.95,
                                        "1"=>0.95,
                                        "1"=>1,
                                        "1.1"=>1.05,
                                        "1.2"=>1.1,
                                        "1.3"=>1.15,
                                        "1.4"=>1.2,
                                        "1.5"=>1.25,
                                        "1.6"=>1.3,
                                        "1.7"=>1.35,
                                        "1.8"=>1.4,
                                        "1.9"=>1.45,
                                        "2"=>1.5,
                                        "2.1"=>1.55,
                                        "2.2"=>1.6,
                                        "2.3"=>1.65,
                                        "2.4"=>1.7,
                                        "2.5"=>1.75,
                                        "2.6"=>1.8,
                                        "2.7"=>1.85,
                                        "2.8"=>1.8,
                                        "2.9"=>1.85,
                                        "3"=>2,      
                                        );






    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
   
    
    public function calcPoints($arr)
    {
        $vezSkillPoints = 0;
        $introvPoints = 0;
        $statusPoints = 0;
        $domPoints = 0;
        
        foreach($arr as $key=>$value)
        {
            
            if(array_key_exists($key, $this->rulesVezSkill)){
               
                $vezSkillPoints+=$this->rulesVezSkill[$key][$value];
            }
            
            if(array_key_exists($key, $this->rulesIntrov)){
               
                $introvPoints+=$this->rulesIntrov[$key][$value];
            }
            
            if(array_key_exists($key, $this->rulesStatus)){
               
                $statusPoints+=$this->rulesStatus[$key][$value];
            }
            
            if(array_key_exists($key, $this->rulesDom)){
               
                $domPoints+=$this->rulesDom[$key][$value];
            }
            
            
        }
        
        
        
        $vezSkillPoints = $vezSkillPoints/9;
        $introvPoints = round($introvPoints/5,1);
        
        if(array_key_exists("".$introvPoints."", $this->rulesExtra))
        {       
            
                $introvPoints = $this->rulesExtra["".$introvPoints.""];
                
        }
        
        
        $statusPoints = $statusPoints/5;
        $domPoints = $domPoints/5;
        
        
        $finalScore = ($statusPoints * $domPoints * $vezSkillPoints) / $introvPoints;
        
        return $finalScore;
        
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
        //return $this->getContents($id)." - ".$score." pont";
        return $this->getContents($id);
    }

    public function getKompetenciakFromDB(){
       $query = "
            SELECT kompetencia.kompetencia_nev, kompetencia.kompetencia_tartalom, szektor.szektor_id, kompetencia.kompetencia_id
            FROM kompetencia
            INNER JOIN szektor_kompetencia ON kompetencia.kompetencia_id = szektor_kompetencia.kompetencia_id
            INNER JOIN szektor ON szektor.szektor_id = szektor_kompetencia.szektor_id
            WHERE kompetencia_torolt =  '0' AND szektor_torolt =  '0'
            ORDER BY szektor_id
        "; 
       $result=$this->_DB->prepare($query)->query_select()->query_result_array();
       
       foreach ($result as $key => $value) {
           $this->setKompetenciak($key,"szektorid", $result[$key]['szektor_id']);
           $this->setKompetenciak($key,"nev", $result[$key]['kompetencia_nev']);
           $this->setKompetenciak($key,"tartalom", $result[$key]['kompetencia_tartalom']);
           $this->setKompetenciak($key,"kompetenciaid", $result[$key]['kompetencia_id']);
       }
       return $this->kompetenciak;
   }
    
   public function getSzektorOrderArray($arr)
   {
       
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