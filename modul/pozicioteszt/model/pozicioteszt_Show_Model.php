<?php
class Pozicioteszt_Show_Model extends Model {
   
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
    
    public function getLeaderDetails()
    {
        $query = "SELECT pozicio_id AS ID, pozicio_nev AS nev, pozicio_leiras AS leiras
                  FROM pozicio
                  WHERE pozicio_aktiv = 1 AND pozicio_torolt = 0 AND link = 'vezeto'
                  LIMIT 1
                ";
        
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    
    public function getLeaderComps($id)
    {
        try{
        $query = "SELECT k.kompetencia_nev AS nev, k.kompetencia_link AS link
                  FROM kompetencia k
                  INNER JOIN pozicio_attr_kompetencia pak ON pak.kompetencia_id = k.kompetencia_id
                  WHERE k.kompetencia_aktiv = 1 AND k.kompetencia_torolt = 0 AND pak.pozicio_id = ".(int)$id."
                ";
        }  catch (Exception_MYSQL_Null_Rows $e)
        {
                            
        }
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getEmployeeDetails()
    {
        $query = "SELECT pozicio_id AS ID, pozicio_nev AS nev, pozicio_leiras AS leiras
                  FROM pozicio
                  WHERE pozicio_aktiv = 1 AND pozicio_torolt = 0 AND link = 'alkalmazott'
                  LIMIT 1
                ";
        
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    
    public function getEmployeeComps($id)
    {
        try{
        $query = "SELECT k.kompetencia_nev AS nev, k.kompetencia_link AS link
                  FROM kompetencia k
                  INNER JOIN pozicio_attr_kompetencia pak ON pak.kompetencia_id = k.kompetencia_id
                  WHERE k.kompetencia_aktiv = 1 AND k.kompetencia_torolt = 0 AND pak.pozicio_id = ".(int)$id."
                ";
        }  catch (Exception_MYSQL_Null_Rows $e)
        {
                            
        }
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function saveResult($result,$cID,$score){
        try{
            $query = "INSERT INTO ugyfel_attr_pozicioteszt
                        SET ugyfel_id = ".(int)$cID.", eredmeny = '". mysql_real_escape_string($result)."', pont = ".  mysql_real_escape_string($score)."
                      ON DUPLICATE KEY UPDATE eredmeny = '". mysql_real_escape_string($result)."', pont = ".  mysql_real_escape_string($score)."
                        ";
            
            $this->_DB->prepare($query)->query_insert();
            
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
        }
        catch(Exception_MYSQL $e){
        }
    }
    
    
    
}
?>