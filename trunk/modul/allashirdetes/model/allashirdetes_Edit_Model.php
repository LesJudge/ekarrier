<?php
/**
 * @property MYSQL_DB $_DB Adatbázis.
 */
class Allashirdetes_Edit_Model extends \AllashirdetesBaseEditModel
{
    /**
     * Form elkészítése.
     */
    public function __addForm()
    {
        parent::__addForm();
        // Cég.
        $company = $this->getItemObject('SelCeg');
        $company->_select_value = $this->getSelectValues(
            'ceg', 'nev', ' AND ceg_aktiv = 1 AND ceg_torolt = 0', ' ORDER BY nev ASC', false,
            array('' => '--Kérem, válasszon!--')
        );
        // Link
        $link = $this->getItemObject('TxtLink');
        $link->_verify['string'] = true;
        // Más hirdetése.
        $mh = $this->getItemObject('ChkMasHirdetese');
        $mh->_verify['required'] = true;
        $mh->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        // Egyedi álláshirdetés-e.
        $chkUnique = $this->getItemObject('ChkEgyedi');
        $chkUnique->_verify['required'] = true;
        $chkUnique->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        // Ellenőrzött álláshirdetés-e.
        $chkVerified = $this->getItemObject('ChkEllenorzott');
        $chkVerified->_verify['required'] = true;
        $chkVerified->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        // Hirdető
        $this->addItem('TxtHirdeto');
    }
    /**
     * Rekord ellenőrzés, nyelv_id "letiltása".
     * @param string $nyelv
     * @return boolean
     */
    public function verifyRow($nyelv = "")
    {
        return true;
    }
    /**
     * Rekord visszatöltés után lefutó metódus.
     * @return array
     */
    public function __editData()
    {
        $query = "SELECT num_megtekintve,
                         modositas_szama, 
                         letrehozas_timestamp, 
                         modositas_timestamp, 
                         u1.user_id AS letrehozo_id,
                         u1.user_fnev AS letrehozo_username,
                         CONCAT(u1.user_vnev, ' ', u1.user_knev) AS letrehozo_nev,
                         u2.user_id AS modosito_id,
                         u2.user_fnev AS modosito_username,
                         CONCAT(u2.user_vnev, ' ', u2.user_knev) AS modosito_nev,
                         allashirdetes_aktiv AS active
                  FROM {$this->_tableName}
                  LEFT JOIN user AS u1 ON letrehozo = u1.user_id
                  LEFT JOIN user AS u2 ON modosito = u2.user_id
                  WHERE allashirdetes_id = ". (int)$this->modifyID . "
                  LIMIT 1";
        try {
            $cityName = UserAddressFinder::model()->findCityById($this->_params['IdCity']->_value);
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            $cityName = '';
        }
        $extend = array('cityName' => $cityName);
        $data = array_merge(
            $this->_DB->prepare($query)->query_select()->query_fetch_array(),
            parent::__editData(),
            $extend
        );
        return $data;
    }
    /**
     * Megjelöli az álláshirdetést, mint generált álláshirdetést a felhasználó számára.
     * @param int $jobId Álláshirdetés azonosító.
     * @param int $userId Felhasználó azonosító.
     */
    public function markAsGenerated($jobId, $userId)
    {
        $query = 'INSERT IGNORE INTO user_attr_allashirdetes_doksi 
                  (allashirdetes_id, user_id) VALUES 
                  (' . (int)$jobId . ', ' . (int)$userId . ')';
        $this->_DB->prepare($query)->query_insert();
    }
    /**
     * Generál egy .pdf-et, majd visszatér a nevével.
     * @param int $jobId
     * @return string
     * @throws \UnexpectedValueException
     */
    public static function downloadPdf($jobId)
    {
        try {
            /* @var $mpdf mPDF */
            return self::generatePdf($jobId);
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            throw new \UnexpectedValueException('A keresett álláshirdetés nem található!');
        }
    }
    /**
     * Előnézeti képet generált a .pdf-ből.
     * @param int $jobId Álláshirdetés azonosító.
     * @return \imagick
     * @throws \UnexpectedValueException
     */
    public static function generatePdfPreview($jobId)
    {
        try {
            $pdf = self::downloadPdf($jobId);
            ob_start();
            echo $pdf->Output();
            $output = ob_get_clean();

            $im = new imagick($output . '[0]');
            $im->setImageFormat('jpg');
            return $im;
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            throw new \UnexpectedValueException('A keresett álláshirdetés nem található!');
        }
    }
    /**
     * A paraméterül adott álláshirdetés azonosító alapján generál egy pdf-et az álláshirdetésről.
     * @param int $jobId Allashirdetés azonosító.
     * @return \mPDF
     * @throws \Exception_MYSQL_Null_Rows
     */
    private static function generatePdf($jobId)
    {
        $assm = new Allashirdetes_Site_Show_Model;
        $self = new self;
        // Smarty objektum.
        $smarty = new Smarty;
        // sheepItForm adatok lekérdezése.
        $elvarasok = $self->findElvarasByJobId($jobId);
        $feladatok = $self->findFeladatByJobId($jobId);
        $amitKinalunk = $self->findAmitKinalunkByJobId($jobId);
        // Variable assignment.
        $smarty->assign('pj', $assm->findPostingJobById($jobId));
        $smarty->assign('elvarasok', $elvarasok);
        $smarty->assign('feladatok', $feladatok);
        $smarty->assign('amitKinalunk', $amitKinalunk);
        $smarty->assign('DOMAIN', Rimo::$_config->DOMAIN);
        // Creates a new mPDF instance.
        $mpdf = new mPDF;
        $mpdf->WriteHTML($smarty->fetch('modul/allashirdetes/resource/allashirdetes.tpl'));
        return $mpdf;
    }
    
    public static function generateDocx($jobId)
    {
        $assm = new Allashirdetes_Site_Show_Model;
        $self = new self;
        // PhpWord objektum létrehozása.
        $phpWord = new \PhpOffice\PhpWord\PhpWord;
        // Dokumentum stílusok definiálása.
        // Felül megjelenő táblázat stílusa.
        $topTableStyle = array(
            'align' => 'center',
            'cellMargin' => 0
        );
        // Felül megjelenő táblázat első oszlopának stílusa. (Munkakör, hirdető, leírás)
        $topTableFirstTdStyle = array(
            'bold' => true,
            'size' => 12
        );
        // Munkakör nevének stílusa.
        $jobNameStyle = array(
            'bold' => true,
            'size' => 18
        );
        // Lista fölött megjelenő szöveg stílusa.
        $listHeadingStyle = array(
            'bold' => true,
            'italic' => true,
            'name' => 'Arial',
            'size' => 14,
        );
        // Lista elem stílusa.
        $listItemStyle = array(
            'name' => 'Arial',
            'size' => 12
        );
        $cellWidth = 2880;
        // Új oldal hozzáadása a dokumentumhoz.
        $section = $phpWord->addSection();        
        // Táblázat stílus "regisztrálása".
        $phpWord->addTableStyle('topTable', $topTableStyle);
        $pj = $assm->findPostingJobById($jobId);
        // Felső táblázat létrehozása a dokumentumban.
        $table = $section->addTable('topTable');
        $table->addRow();
        $table->addCell($cellWidth)->addText('Munkakör:', $topTableFirstTdStyle);
        $table->addCell($cellWidth)->addText($pj['nev'], $jobNameStyle);
        $table->addRow();
        $table->addCell($cellWidth)->addText('Hirdető:', $topTableFirstTdStyle);
        $table->addCell($cellWidth)->addText($pj['hirdeto']);
        $table->addRow();
        $table->addCell($cellWidth)->addText('Leírás:', $topTableFirstTdStyle);
        $table->addCell($cellWidth)->addText(strip_tags($pj['ismerteto']));
        $section->addTextBreak();
        $section->setSettings(array('colNum' => 2));
        $section->setDocPart(2, 2);
        // Adatok lekérdezése.
        $elvarasok = $self->findElvarasByJobId($jobId);
        $feladatok = $self->findFeladatByJobId($jobId);
        $amitKinalunk = $self->findAmitKinalunkByJobId($jobId);
        // Lista render Closure.
        $renderList = function(array $data, $index, $label) use ($section, $listHeadingStyle, $listItemStyle) {
            if (!empty($data)) {
                $section->addText($label, $listHeadingStyle);
                foreach ($data as $item) {
                    $section->addListItem($item[$index], 0, $listItemStyle);
                }
            }
        };
        // Álláshirdetés adatok renderelése.
        $renderList($elvarasok, 'elvaras', 'Elvárások');
        $renderList($feladatok, 'feladat', 'Feladatok');
        $renderList($amitKinalunk, 'amit_kinalunk', 'Amit kínálunk');
        $section->addText('Munkavégzés jellege:', $listHeadingStyle);
        $section->addText($pj['munkarend_nev']);
        // Munkavégzés helye
        $section->addText('Munkavégzés helye:', $listHeadingStyle);
        $section->addText($pj['cim_varos_nev']);
        // Jelentkezés módja
        $section->addText('Jelentkezés módja:', $listHeadingStyle);
        $section->addText(strip_tags($pj['jelentkezes_modja']));
        // Más hirdetése-e.
        if ($pj['mas_hirdetese']) {
            $section->addText('Az álláshirdetés nem a saját adatbázisunkból származik, így tartalmáért nem tudunk felelősséget vállalni.');
            if (is_string(($url = $pj['mas_hirdetes_link']))) {
                $section->addText('A hirdetés forrása: ' . $url);
            }
        }
        // Mentés a /tmp könyvtárba.
        $format = '.docx';
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        //$format = '.odt';
        //$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        $temp = '/tmp/' . time() . $format;
        $self->markAsGenerated($jobId, UserLoginOut_Admin_Controller::$_id);
        //$xmlWriter->save($temp);
        //return $temp;
        $name = 'output/' . time() . '.docx';
        $xmlWriter->save($name);
        return $name;
    }
    
    public function getUserId()
    {
        return (int)UserLoginOut_Admin_Controller::$_id;
    }
    
    public function findAllCompetence()
    {
        try {
            $query = "SELECT
                     kompetencia_id AS kompetencia_id,
                     kompetencia_nev AS Nev
                     FROM kompetencia
                     WHERE kompetencia_aktiv = 1 AND kompetencia_torolt = 0 AND tipus = 'sajat'
                        ";
            
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            
        }
        catch(Exception_MYSQL $e){
            
        }
    }
}