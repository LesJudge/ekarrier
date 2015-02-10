<?php
include_once "page/all/model/page.list_model.php";
class Forum_ShowList_Model extends Page_List_Model {
    public $_tableName = "forum";
    public $_fields = "	forum_id, forum_targy, forum_bekuldo, DATE_FORMAT(forum_bekuldve_date,'%Y-%m-%d %H:%i') AS bekuldve,
                       forum_tartalom, 
					   (
						   	SELECT DATE_FORMAT(hozzaszolas_bekuldve_date,'%Y-%m-%d %H:%i') AS hozzaszolas_bekuldve
			   	   			FROM forum_hozzaszolas 
			   	   			WHERE forum_id=kapcsolodo_id AND 
			   	   				  forum_hozzaszolas_aktiv=1 AND 
			   	   				  forum_hozzaszolas_torolt=0
	  	   				    ORDER BY hozzaszolas_bekuldve_date DESC
	  	   				    LIMIT 1
		  				) AS last_hozzasszolas_date,
		  				(
						   	SELECT COUNT(forum_hozzaszolas_id)
			   	   			FROM forum_hozzaszolas 
			   	   			WHERE forum_id=kapcsolodo_id AND 
			   	   				  forum_hozzaszolas_aktiv=1 AND 
			   	   				  forum_hozzaszolas_torolt=0
	  	   				   
		  				) AS sum_hozzaszolas
    ";
    
	public function __construct(){
        parent::__construct();
        $this->sortBY = "forum_bekuldve_date DESC";
        $this->listWhere = array(1=>"forum_aktiv=1", 2=>"forum_nyelv=".Rimo::$_config->SITE_NYELV_ID);
    }
}
?>