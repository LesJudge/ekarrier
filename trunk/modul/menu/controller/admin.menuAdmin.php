<?php
include_once "page/admin/controller/admin.list.php";

class MenuAdmin_Admin_Controller extends Admin_List {
    
    public function __construct() {
        $this->_name = "MenuAdminList";
        $this->__addEvent("BtnDelete", "Delete");  
        $this->__addEvent("BtnSave", "Save");
		$this->__loadModel("_Admin_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        if(Rimo::$_config->DEFAULT_NYELV_ID!=Rimo::$_config->ADMIN_NYELV_ID)
            $this->_view->assign("FormInfo", "A kategóriafa csak az alapértelmezett nyelven mozgatható");
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/menu/view/admin.menuadmin_list.tpl"));
    }

    public function onClick_Filter() {
    }
    
    public function onClick_Save(){
        if(Rimo::$_config->DEFAULT_NYELV_ID!=Rimo::$_config->ADMIN_NYELV_ID)
            throw new Exception_Form_Error("A kategóriafa csak az alapértelmezett nyelven mozgatható");
        UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
		$item = $_REQUEST["item"];
        foreach ($item as $elem){
        	$elem["item_id"] = mysql_real_escape_string($elem["item_id"]); 
			$elem["left"] = mysql_real_escape_string($elem["left"]);
			$elem["right"] = mysql_real_escape_string($elem["right"]);
			$elem["depth"] = mysql_real_escape_string($elem["depth"]);
        	$elem["parent_id"] = mysql_real_escape_string($elem["parent_id"]);
			
        	if($elem["item_id"]>0){
	        	 try{
	                $this->_model->_DB->prepare("BEGIN")->query_execute();
	                $this->_model->updateTreeItem($elem["item_id"], $elem["left"], $elem["right"],$elem["depth"]);
	                $this->_model->_DB->prepare("COMMIT")->query_execute();
	            }catch(Exception_MYSQL_Null_Affected_Rows $e){
	                $this->_model->_DB->prepare("COMMIT")->query_execute();
	            }catch(Exception_MYSQL $e){
	                $this->_model->_DB->prepare("ROLLBACK")->query_execute();
	                throw new Exception_Form_Error($e->getMessage());
	            }
           }
       	}
        throw new Exception_Form_Message("Sikeres sorrend mentés.");
    }
    
    protected function onClick_Delete(){
        UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
        try {
            $this->_model->_DB->prepare("BEGIN")->query_execute();
            $this->_model->deleteKategoria($this->_events["BtnDelete"]->_value);
            $this->_model->_DB->prepare("COMMIT")->query_execute();
            throw new Exception_Form_Message("Sikeres törlés.");
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
             $this->_model->_DB->prepare("COMMIT")->query_execute();
             throw new Exception_Form_Error($e->getMessage());
        }catch(Exception_MYSQL $e){
            $this->_model->_DB->prepare("ROLLBACK")->query_execute();
            throw new Exception_Form_Error($e->getMessage());
        }
    }
    
    public function getList(){
    	parent::getList();
    	$count = count($this->vDataArray);
        $tabs = '<ul class="tabs">';
        for ($i=0; $i<$count; $i++) {
        	$visible = "";
        	
			$button = "";
			if($this->vDataArray[$i]["leaves"]==1)
				$button = "
					<button id='delete_{$i}' title='Törlés' class='statusz' onclick=\"return confirmBox('delete_{$i}', 'Biztosan törli a kategóriát', 'Törli a(z) <strong>{$this->vDataArray[$i]['elso']}</strong> kategóriát? <br />A törlés miatt azon elemek melyek a kiválasztott kategóriába tartoznak, nem jelennek meg majd a külső oldalon. <br />A kategória törlése végleges, nem visszavonható!');\" 
						name='".$this->_name.$this->_events["BtnDelete"]->_name."' value='{$this->vDataArray[$i]['ID']}'>
							<span class='ui-icon ui-icon-circle-close'>Törlés</span>
					</button>";
			
			if($this->vDataArray[$i]["Aktiv"])
        		$button .= "
					<button id='statusz_{$i}' title='Visszavonás' class='statusz' onclick=\"return confirmBox('statusz_{$i}', 'Biztosan visszavonja a kategóriát', 'Visszavonja a(z) <strong>{$this->vDataArray[$i]['elso']}</strong> tételt?');\" 
						name='".$this->_name.$this->_events["BtnUnpublish"]->_name."' value='{$this->vDataArray[$i]['ID']}'>
							<span class='ui-icon ui-icon-locked'/>Visszavonás</span>
					</button>";
			else
				$button .= "
					<button id='statusz_{$i}' title='Publikálás' class='statusz' onclick=\"return confirmBox('statusz_{$i}', 'Biztosan publikussá teszi a kategóriát', 'Publikussá teszi a(z) <strong>{$this->vDataArray[$i]['elso']}</strong> tételt?');\" 
						name='".$this->_name.$this->_events["BtnPublish"]->_name."' value='{$this->vDataArray[$i]['ID']}'>
							<span class='ui-icon ui-icon-unlocked'/>Publikálás</span>
					</button>";
					
			if($this->vDataArray[$i]["szint"]==0){
        		$html .= "
					<div id='tabs-{$i}'>
					<ol class='tree-serialize'>
					<li id='list_{$this->vDataArray[$i]["ID"]}'>
						<div class='ui-state-default portlet' style='display:none;'>
							<span class='ui-icon ui-icon-arrow-4 tree-icon'></span>
							<a href='".Rimo::$_config->APP_LINK[$_REQUEST["al"]]."/edit/".$this->vDataArray[$i]["ID"]."?nyelv=".$this->_model->nyelvID."'>
								{$this->vDataArray[$i]["elso"]}
							</a>
							{$button}	
						</div>
						<ol class='tree'>
				";
        		$tabs .= "
					<li id='root-{$this->vDataArray[$i]["ID"]}'>
						<a href='#tabs-{$i}'>{$this->vDataArray[$i]["elso"]}</a>
						<a href='".Rimo::$_config->APP_LINK[$_REQUEST["al"]]."/edit/".$this->vDataArray[$i]["ID"]."?nyelv=".$this->_model->nyelvID."'>
							<span class='ui-icon ui-icon-pencil'></span>
						</a>
					</li>
				";
        	}
        
            if($this->vDataArray[$i]["szint"]!=0){
	        	$html .= "
					<li id='list_{$this->vDataArray[$i]["ID"]}'>
						<div class='ui-state-default portlet' style='$visible'>
							<span class='ui-icon ui-icon-arrow-4 tree-icon'></span>
							<a href='".Rimo::$_config->APP_LINK[$_REQUEST["al"]]."/edit/".$this->vDataArray[$i]["ID"]."?nyelv=".$this->_model->nyelvID."'>
								{$this->vDataArray[$i]["elso"]}
							</a>
							{$button}	
						</div>
	           ";
	           if ($this->vDataArray[$i]["szint"] < $this->vDataArray[$i+1]["szint"]) {
	                $html .= "<ol>";                
				} elseif ($this->vDataArray[$i]["szint"] == $this->vDataArray[$i+1]["szint"]) {
					$html .= "</li>";
				} else {
					$diff = $this->vDataArray[$i]["szint"] - $this->vDataArray[$i+1]["szint"];
					$html .= str_repeat("</li></ol>", $diff) . "</li>";
				}
      		}		
			if($this->vDataArray[$i+1]["szint"]==0 AND $this->vDataArray[$i-1]["szint"]){
       			$html .= "</ol></ol></div>";
			}
       }
       $tabs .= "</ul>";
       $this->_view->assign("kategoriaList",$html);
       $this->_view->assign("kategoriaTabs",$tabs);
    }
}
?>