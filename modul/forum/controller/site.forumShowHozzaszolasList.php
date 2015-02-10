<?php
include_once "page/all/controller/page.list.php";

class ForumShowHozzaszolasList_Site_Controller extends Page_List
{
    
    public $_name = "ForumHozzaszolasShowList";
    protected $_multiple_lang = false;

    public function __construct()
    {
        //UserLoginOut_Site_Controller::isAuthorized('Exception_404');
        Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->_model = $this->__loadPublicModel("hozzaszolas","_ShowList");
        $this->_model->_tableName = "forum_hozzaszolas";
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
	$this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show()
    {
        parent::__show();
        try
        {
            $data = $this->_model->getTartalom($_REQUEST["kapcs_id"],"forum");
            $this->_view->assign("data",$data);
            $this->_view->assign("kapcs_id",$_REQUEST["kapcs_id"]);
            Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>"Fórum témák", "link"=>"forum/"),2=>array("nev"=>$data[0]["targy_min"])));
            Rimo::$_site_frame->assign("PageName",$data[0]["targy_min"]);
            Rimo::$_site_frame->assign("site_title",$data[0]["targy_min"]);
            Rimo::$_site_frame->assign("site_description",$data[0]["tartalom_min"]);
            Rimo::$_site_frame->assign("site_keywords",$data[0]["targy_min"]);
            Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/forum/view/site.forum_hozzaszolas_list.tpl"));
        }
        catch(Exception_MYSQL $e)
        {
            throw new Exception_404();
        }
    }
    
    public function getList(){
    	try{
            $this->getCount();
            $this->_model->limit = $this->vPaging->getSqlLimit();
            $this->vDataArray = $this->_model->__loadList();
            $count = count($this->vDataArray);
			
			/*
			
			
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title"><i class="icomoon icomoon-user"></i>{$lista.forum_bekuldo} <span class="badge">{$lista.bekuldve}</span></h3></div>
				<div class="panel-body">
					<div class="clear">{$lista.forum_tartalom}</div>					
					<ul class="list-group" style="display:inline-block;">
						{if $lista.sum_hozzaszolas}
							<li class="list-group-item">Utolsó hozzászólás: &nbsp; <span class="badge"> {$lista.last_hozzasszolas_date}</span></li>
							<li class="list-group-item">Eddigi hozzászólások száma: &nbsp; <span class="badge"> {$lista.sum_hozzaszolas}</span> </li>
						{/if}							
							<li class="list-group-item"> <a href="{$DOMAIN}forum/{$lista.forum_id}/" class="btn btn-md btn-primary">Hozzászólások</a></li>
					</ul>
				</div>
			</div>		
			
			
			*/
			
			
			
            $html = "<style type='text/css'> .panel-default { margin:1em 1em 1em 3em; } .content > .panel { margin-left: 0em; } </style> ";
            for ($i=0; $i<$count; $i++) { 
                if($i==0){
                    $remove = $this->vDataArray[$i]["szint"];
                    $this->vDataArray[$i]["szint"] -= $remove;
                }
                if($this->vDataArray[$i+1]["szint"])
                    $this->vDataArray[$i+1]["szint"] -= $remove;    
            	$hozzaszol_link = Rimo::$_config->DOMAIN."forum/".$_REQUEST["kapcs_id"]."/bekuldes/?parent_id=".$this->vDataArray[$i]["ID"];
				$html .= "<div class='panel panel-default'>
							<div class='panel-heading'>
								<h3 class='panel-title'>
									{$this->vDataArray[$i]["hozzaszolas_bekuldo"]} <a href='{$hozzaszol_link}' class='btn btn-xs btn-primary'>Hozzászólás</a>
									<span class='badge'>{$this->vDataArray[$i]["bekuldve"]}</span>
								</h3>
							</div>
							<div class='panel-body'>
								{$this->vDataArray[$i]["hozzaszolas_tartalom"]}								
							</div>
				";
				if ($this->vDataArray[$i]["szint"] < $this->vDataArray[$i+1]["szint"]) {
					$html .= " ";
    			} elseif ($this->vDataArray[$i]["szint"] == $this->vDataArray[$i+1]["szint"]) {
    				$html .= "</div>";
    			} else {
    				$diff = $this->vDataArray[$i]["szint"] - $this->vDataArray[$i+1]["szint"];
                    if($this->vDataArray[$i+1]["szint"]<0) $diff=0;
    				$html .= str_repeat("</div>", $diff) . "</div>";
    			}
            }
            $this->vDataArray = $html."</div> ";
        }
		catch (Exception_Mysql_Null_Rows $e) {
        	$this->_view->assign("No_SelTetel", true);
            //$this->_view->assign("FormInfo", LANG_PageList_nincs_elem);
        }
        catch (Exception $e) {
        	$this->_view->assign("No_SelTetel", true);
            //$this->_view->assign("FormError", $e->getMessage());
        }
    }
}
?>