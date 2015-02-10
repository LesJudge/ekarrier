<?php
class User_Jogcsoport_Edit_Model extends Admin_Edit_Model
{
	public $_tableName = "jogcsoport";
	public $_bindArray = array("jogcsoport_nev"  => "TxtNev",
		"jogcsoport_aktiv"=> "ChkAktiv"
	);

	public	function __addForm()
	{
		parent::__addForm();
		$nev = $this->addItem("TxtNev");
		$nev->_verify["string"] = true;
		$nev->_verify["unique"] = array("table" =>"jogcsoport","field" =>"jogcsoport_nev","modify"=>$this->modifyID,"DB"    =>$this->_DB);

		$jogadmin = $this->addItem("SelJogAdmin");
		//$jogadmin->_verify["multiSelect"] = true;

		$jogsite  = $this->addItem("SelJogSite");
		// $jogsite->_verify["multiSelect"] = true;


	}

	public	function __formValues()
	{
		parent::__formValues();

		$this->_params["SelJogAdmin"]->_value = $this->getSelectAktivValues("jogcsoport_function");
		$this->_params["SelJogSite"]->_value = $this->getSelectAktivValues("jogcsoport_function");
	}

	public	function __update()
	{
		$this->saveSelect("jogcsoport_function", $this->jogok_array(), $this->modifyID);


		parent::__update(", site_tipus_id =".$this->select_Site_Tipus());
	}

	public	function __insert()
	{
		parent::__insert(", site_tipus_id =".$this->select_Site_Tipus());
		$this->saveSelect("jogcsoport_function", $this->jogok_array(), $this->insertID);
	}
	
	private	function jogok_array()
	{
		if ($this->_params["SelJogAdmin"]->_value != null && $this->_params["SelJogSite"]->_value != NULL)
		{
			return array_merge( $this->_params["SelJogAdmin"]->_value, $this->_params["SelJogSite"]->_value);
		}
		else
		if ($this->_params["SelJogAdmin"]->_value == null && $this->_params["SelJogSite"]->_value != NULL)
		{
			return $this->_params["SelJogSite"]->_value;
		}
		else
		if ($this->_params["SelJogAdmin"]->_value != null && $this->_params["SelJogSite"]->_value == NULL)
		{
			return $this->_params["SelJogAdmin"]->_value;
		}
		else
		{
			return array();
		}
	}
	
	private	function select_Site_Tipus()
	{
		if ($this->_params["SelJogAdmin"]->_value != NULL && $this->_params["SelJogSite"]->_value == NULL) {
			return 1;
		}
		else
		if ($this->_params["SelJogAdmin"]->_value != NULL && $this->_params["SelJogSite"]->_value != NULL) {
			return 3;
		}
		else
		{
			return 2;
		}
	}

	public	function selectJog()
	{
		if ($this->modifyID != 1)            $where = " AND modul_function_root=0";
		$this->_params["SelJogAdmin"]->_select_value = $this->getSelectValues("modul_function", "modul_function_nev", "{$where} AND site_tipus_id=1","",false);
		$this->_params["SelJogSite"]->_select_value = $this->getSelectValues("modul_function", "modul_function_nev", "{$where} AND site_tipus_id=2","",false);
	}



}
?>
