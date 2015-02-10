<?php
class MenuShow_Admin_Controller extends RimoController{
    public function __construct(){
        $this->__run();
    }
    
    public function __run(){
        $this->__loadModel("_Admin");
        parent::__run();
    }
    
    public function __show(){
        $this->_view->assign("menu", $this->getAlmenu(2));
        Rimo::$_site_frame->assign("Menu_one",$this->_view->fetch("modul/menu/view/admin.menu_show_one.tpl"));
        
        $template_file = "modul/menu/view/admin.menu_show_all.tpl";
        $this->getFullMenu($template_file);
        Rimo::$_site_frame->assign("Menu_all",$this->_view->fetch($template_file));
    }
    
    private function getAlmenu($szint){
        try{
            $server_link = strtok($_SERVER["REQUEST_URI"],"?");
            if($_REQUEST["al"])
                $link = $_REQUEST["m"]."/".$_REQUEST["al"];
            else    
                $link = $_REQUEST["m"];
            $obj = $this->_model->loadChildTree($link, Rimo::$_config->RIGHTSWHERE, 2);
            while($menu = $obj->query_fetch_array()){
                 if (strstr($server_link, $menu["menu_link"]) == $menu["menu_link"])
                        $menu["aktiv"] = true;
                 $list[] = $menu;
            }
            return $list;
            
        }catch(Exception_MYSQL_Null_Rows $e){   
        }
    }
    
    private function getFullMenu(){
        try{
            $tree = $this->_model->loadTree(Rimo::$_config->FOMENU_ID, Rimo::$_config->RIGHTSWHERE);
            $count = count($tree);
            $html = "<ul id='navigation' class='dropdown right'>";
            for ($i=0; $i<$count; $i++) {
                if($tree[$i]["szint"]==1){
                    $html .= "<a href='#{$tree[$i]["id"]}_{$i}' class='flat_menu'>
                              	<span class='v'></span>{$tree[$i]["menu_nev"]}
							  </a>
                              <div id='{$tree[$i]["id"]}_{$i}' class='fg-menu' style='display: none;'>
                                ";
                } 
                else{ 
                    $html .= "<li>" . "<a href='".Rimo::$_config->DOMAIN_ADMIN."{$tree[$i]["menu_link"]}' class='menu_link'>".$tree[$i]["menu_nev"]."</a>";
                }
			    if ($tree[$i]["szint"] < $tree[$i+1]["szint"]) {
                    $html .= "<ul class='szint_".$tree[$i]["szint"]."'>";
    			} elseif ($tree[$i]["szint"] == $tree[$i+1]["szint"]) {
    				$html .= "</li>";
    			} else {
    				$diff = $tree[$i]["szint"] - $tree[$i+1]["szint"];
    				$html .= str_repeat("</li></ul>", $diff) . "</li>";
    			}
    			if($tree[$i+1]["szint"]==1 AND $i!=0){
    				$len=strlen($html);
					$html=substr($html,0,($len-5));	
                	$html .= "</div></li>";
      			}   
            }
           $html .= "</ul>";
           $html=substr($html,0,(-10));
		   $this->_view->assign("menu_all",$html);
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
}
?>