<?php
/**
* Bárhonnan elérhető generálások gyűjtő osztálya.
*
* @package FrameWork
* @subpackage Create
* @author Rimóczi Gergely
* @copyright 2011
* @version 1.0
* @access public
*/

class Create
{
	/**
	* Query-hez mezők készítése
	*
	* @param array $binds
	* @return sets
	*/
	public static function query_load_sets(array & $binds)
	{
		$i    = 0;
		$sets = "";
		$key  = array_keys($binds);
		$size = sizeOf($key);
		for ($i = 0; $i < $size; $i++) {
			if ($i !== 0) $sets .= ', ';
			$sets .= $key[$i];
		}
		return $sets;
	}

	/**
	* Query-hez mezők készítése: 1 sor beszúrása/módosítása
	*
	* @param array $binds
	* @return sets
	*/
	public static function query_set_sets(array & $binds)
	{
		$i    = 0;
		$sets = "";
		foreach ($binds as $field => $value)
		{
			if ($i !== 0) $sets .= ', ';
			$sets .= mysql_real_escape_string($field) . "='" . mysql_real_escape_string($value)."'";
			$i++;
		}
		return $sets;
	}

	/**
	* Query készítés: limitált sorok kiolvasása
	*
	* @param string $table
	* @param array $binds
	* @param string $where
	* @param string $limit
	* @param mixed $sort
	* @return query
	*/
	public static function query_list_load($table, array & $binds, $where, $limit, $sort)
	{
		$i = 0;
		foreach ($binds as $field => $value)
		{
			if ($i != 0) $elem .= ', ';
			$elem .= $field . ' AS ' . $value;
			$i++;
		}
		$i = 0;
		if (!empty($sort))
		{
			$order = " ORDER BY $sort";
		}
		return "SELECT {$elem} FROM `{$table}` {$where} {$order} {$limit}";
	}

	/**
	* Permalink képzés
	*
	* @param sting $string
	* @param array $replace
	* @param string $delimiter
	* @param string $charcode
	*
	* @return cleanedString
	*/
	public static function remove_accents($string, $replace = array(), $delimiter = '-', $charcode = 'UTF-8')
	{
		setlocale(LC_ALL, "hu_HU.$charcode");
		if (!empty($replace))
		{
			$string = str_replace((array )$replace, ' ', $string);
		}
		$clean = iconv($charcode, 'ASCII//TRANSLIT', $string);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, $delimiter));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		return $clean;
	}

	/**
	* Form megadott eleméhez JQUERY validálás generálása
	*
	* @param array $input_fields
	* @param string $event_name
	* @param string $form_name
	* @uses Exception_Load::Create_Error()
	* @throw {@link Exception_Load_error} Ha nincs olyan JQUERY-s kötelezőség ({@link Verify::$validate}), amit beállítottunk az {@link Item} -nek
	*
	* @return script
	*/
	public static function JQUERY_verify(array $input_fields, $event_name, $form_name)
	{

		$script = '$("#'. $form_name.$event_name . '").click(  function() { ';
		$script .= '$("#' . $form_name . '").validate( { rules: { ';
		foreach ($input_fields as $input_val)
		{
			if (is_array($input_val->_verify))
			{
				$script .= $form_name . $input_val->_name . ': { ';
				foreach ($input_val->_verify as $verify_type=>$verify_val)
				{
					if (!array_key_exists($verify_type, Verify::$validate))
					{
						throw Exception_Load::Create_Error("Verify", $verify_type);
					}
					if (Verify::$validate[$verify_type])
					{
						if (is_object($verify_val))                            $script .= Verify::$validate[$verify_type] . ":'#{$form_name}{$verify_val->_name}', ";
						else                            $script .= Verify::$validate[$verify_type] . ":{$verify_val}, ";
					}
				}
				$script = rtrim($script,', ');
				$script .= '},';
			}
		}
		$script = rtrim($script,',');
		$script .= " } }) });";
		return $script;
	}


	/**
	* Méret kiíratásának felhasználóbarátabbá tétele.
	*
	* @param int $bytes
	*
	* @return mixed byte
	*/
	public static function byte_converter($bytes)
	{
		$symbol = array('B','kB','MB','GB','TiB','PB','EB','ZB','YB');
		$exp             = 0;
		$converted_value = 0;
		if ( $bytes > 0 )
		{
			$exp             = floor( log($bytes) / log(1024) );
			$converted_value = ( $bytes / pow(1024,floor($exp)) );
		}
		return sprintf( '%.2f '.$symbol[$exp], $converted_value );
	}
	/**
	* Előző fordítva
	*
	* @param mixed $from
	*
	*/
	public static function convertToBytes($from)
	{
		$number = substr($from,0, - 2);
		switch (strtoupper(substr($from, - 2)))
		{
			case "KB":
			return $number * 1024;
			case "MB":
			return $number * pow(1024,2);
			case "GB":
			return $number * pow(1024,3);
			case "TB":
			return $number * pow(1024,4);
			case "PB":
			return $number * pow(1024,5);
			default:
			return $from;
		}
	}

	/**
	* File feltöltés.
	* Az adott modul beállított $target_dir mappájába tölti a fájlt.
	* A fájlt átnevezi .=($i), hamár az adott fájl létezik.
	* Ha nincs fájl megadva, akkor visszatér a $table_field változó értékével.
	*
	* @param mixed $file_value
	* @param bool $table_field
	* @param string $target_dir
	*
	* @uses Exception_Form_Error
	* @return $file_name|$table_field
	*/
	public static function upload_file($file_value, $table_field = false, $target_dir = "upload")
	{
		if ($file_value["error"] === 0)
		{
			$file_name_array = explode('.', strrev($file_value['name']),2);
			$file_extension  = strrev($file_name_array[0]);

			$file_name       = Create::remove_accents(strrev($file_name_array[1]));
			$file_value["name"] = $file_name.'.'.$file_extension;
			$targetFile = "modul/".Rimo::$_config->APP_PATH."/".$target_dir. "/" . $file_value['name'];
			$targetFile = str_replace("//", "/", $targetFile);
			$i          = 1;
			while (is_file($targetFile))
			{
				$file_value["name"] = $file_name."({$i}).".$file_extension;
				$targetFile = "modul/".Rimo::$_config->APP_PATH."/".$target_dir. "/" . $file_value['name'];
				$i++;
			}
			if (move_uploaded_file($file_value["tmp_name"], $targetFile) === false)
			{
				throw new Exception_Form_Error("Sikertelen file feltöltés.".$file_value["tmp_name"]."--".$targetFile);
			}
			chmod($targetFile, 0777);
			return "'".$file_value["name"]."'";
		}
		return $table_field;
	}

	/**
	* Könyvtár rekurzív törlése
	*
	* @param mixed $dirname
	* @return true|false
	*/
	public static function directory_delete($dirname)
	{
		if (is_dir($dirname))
		{
			$dir_handle = opendir($dirname);
			while ($file = readdir($dir_handle))
			{
				if ($file != "." && $file != "..")
				{
					if (!is_dir($dirname . "/" . $file)) unlink($dirname . "/" . $file);
					else  Create::directory_delete($dirname . '/' . $file);
				}
			}
			closedir($dir_handle);
			rmdir($dirname);
			return true;
		}
		return false;
	}

	public static function passwordGenerator($val, $salt)
	{
		return sha1(substr(md5($val),1,19).strlen($salt) . $salt) . substr($salt,2,4);
	}

	/**
	* Create::getWord()
	*
	* @param mixed $database
	* @param mixed $azon
	* @param mixed $modul_id
	* @return szo
	*/
	public static function getSzotarUzenet($database, $azon, $modul_id, $nyelv_id)
	{
		$query = "
		SELECT 	nyelv_szotar_szo
		FROM nyelv_szotar
		WHERE nyelv_szotar_torolt=0 AND
		nyelv_id={$nyelv_id} AND
		modul_id={$modul_id} AND
		nyelv_szotar_azon='{$azon}'
		LIMIT 1
		";
		try
		{
			$szo = $database->prepare($query)->query_select()->query_fetch_array("nyelv_szotar_szo");
			return $szo;
		}
		catch (Exception_MYSQL $e)
		{
			return "szó HIBA! <strong>{$azon}</strong>";
		}
	}
}