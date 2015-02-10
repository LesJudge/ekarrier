<?php
class MenuShow_Site_Controller extends RimoController{
    public function __construct(){
        $this->__run();
    }

    public function __run(){
        $this->__loadModel();
        parent::__run();
    }

    public function __show(){
        $template_file = "modul/menu/view/site.menu_show_all.tpl";
		
		//Rimo::$_config->FOMENU_ID[0]=23;
        foreach(Rimo::$_config->FOMENU_ID as $id){
            $this->getFullMenu($id);
            //print_r(Rimo::$_config->FOMENU_ID);
            
            
            Rimo::$_site_frame->assign("Menu_{$id}",$this->_view->fetch($template_file));
			
        }
   	}


	private function getAlmenu($szint){
        try{
            $server_link = strtok($_SERVER["REQUEST_URI"],"?");
            $obj = $this->_model->loadChildTree($_REQUEST["m"], Rimo::$_config->RIGHTSWHERE, $szint);
            while($menu = $obj->query_fetch_array()){
                 if (@strstr($server_link, $menu["menu_link"]) == $menu["menu_link"])
                        $menu["aktiv"] = true;
                 $list[] = $menu;
            }
            return $list;
        }catch(Exception_MYSQL_Null_Rows $e){   
        }
    }

    private function getFullMenu($id){
        try{
            $tree = $this->_model->loadTree($id, Rimo::$_config->RIGHTSWHERE);
            $count = count($tree);
            $html = "<ul id='menu_{$id}' class='nav clearfix'>";
            $server_link = strtok($_SERVER["REQUEST_URI"],"?");
            for ($i=0; $i<$count; $i++) {
            	if (@strstr($server_link, $tree[$i]["menu_link"]) == $tree[$i]["menu_link"]){
            		$tree[$i]["menu_class"] = "aktiv";
            	}
                if(strlen($tree[$i]["menu_link"])==0){
            		if($_SERVER["REQUEST_URI"]==="/"){
						$tree[$i]["menu_class"] = "aktiv";
					}
					else{
						$tree[$i]["menu_class"] = "";
					}	
            	}
                // DEBUG
            	if($tree[$i]["szint"]==1 AND (isset($tree[$i-1]) && $tree[$i-1]["szint"]!=1) ){
            		if($i!=0) $html .= "</li>"; 
            	}
               /*
			    if($tree[$i]["szint"]==1 AND (($tree[$i+1]["szint"]!=1 OR !$tree[$i+1]["szint"]) AND $tree[$i+1]["szint"])){
                    	$html .= "<li><a class='".$tree[$i]["menu_class"]."'>{$tree[$i]["menu_nev"]}</a>";
                }
				*/	
				/*			
				if($tree[$i]["szint"]==1 AND $tree[$i+1]["szint"] ){
                    	$html .= "<li><a class='topLevel ".$tree[$i]["menu_class"]."' href='{$tree[$i]['menu_link']}'><span class='fomenuSpan'>{$tree[$i]["menu_nev"]}</span></a>";
                }
				*/	 
                if($tree[$i]["szint"]==1 )
				{
                    // DEBUG
                    	if (isset($tree[$i+1]) && (($tree[$i+1]["szint"]!=1 OR !$tree[$i+1]["szint"]) AND $tree[$i+1]["szint"]))
						{
							$html .= "<li class='topLevel-li'><a class='topLevel ".$tree[$i]["menu_class"]."' href='javascript:;'><span class='fomenuSpan'>{$tree[$i]["menu_nev"]}</span></a>";
						}
						else 
						{ // DEBUG
                                                    $class=isset($tree[$i]['menu_class']) ? $tree[$i]['menu_class'] : '';
							$html .= "<li class='topLevel-li'><a href='{$tree[$i]['menu_link']}' class='topLevel ".$class."'><span class='fomenuSpan'>{$tree[$i]["menu_nev"]}</span></a>";
					    }
						
                }
				else{ 
                    $html .= "<li class='".$tree[$i]["menu_class"]."'>" . "<a href='{$tree[$i]['menu_link']}' class='menu_link'>".$tree[$i]["menu_nev"]."</a>";
                }
                // DEBUG
			    if (isset($tree[$i+1]) && ($tree[$i]["szint"] < $tree[$i+1]["szint"])) {
                    $html .= "<ul class='szint_".$tree[$i]["szint"]." ".$tree[$i]["menu_class"]."'>";
    			} elseif (isset($tree[$i+1]) && ($tree[$i]["szint"] == $tree[$i+1]["szint"])) {
    				$html .= "</li>";
    			} else {
                            // DEBUG
                            $szint=isset($tree[$i+1]['szint']) ? $tree[$i+1]['szint'] : 0;
    				$diff = $tree[$i]["szint"] - $szint;
    				$html .= str_repeat("</li></ul>", $diff) ;//. "</li>";
    			}
            }
			
           //$html .= "</ul>";
           
		   //$html=substr($html,0,(-10));
		   
		   
		   
		//echo $html; 
           $this->_view->assign("menu_all",$html);
        }catch(Exception_MYSQL_Null_Rows $e){
            $this->_view->assign("menu_all","");
        }
    }
}
?>