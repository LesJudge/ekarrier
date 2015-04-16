<?php

abstract class AjaxController extends RimoController implements \ValidateRequest
{
    /**
     * Csak AJAX kérést dolgozzon fel.
     * @var boolean
     */
    protected $ajaxOnly = true;
    /**
     * Automatikusan futtassa-e a controllert.
     * @var boolean
     */
    protected $autorun = true;
    
    public function __construct()
    {
        if ($this->isValidRequest()) {
            if ($this->getAutorun()) {
                $this->__run();
            }
        } else {
            $this->invalidRequest();
        }
    }
    /**
     * Megvizsgálja, hogy megfelelő kérés érkezett-e.
     * @return type
     */
    public function isValidRequest()
    {
        return ($this->getAjaxOnly() && $this->isAjaxRequest()) || !$this->getAjaxOnly();
    }
    /**
     * Nem megfelelő kérés esetén lefutó metódus.
     */
    public function invalidRequest()
    {
        echo json_encode(false);
        exit;
    }
    /**
     * Megvizsgálja, hogy AJAX kérés-e.
     * @return boolean
     */
    public function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    /**
     * AJAX kérés-e.
     * @return boolean
     */
    public function getAjaxOnly()
    {
        return $this->ajaxOnly;
    }
    /**
     * Automatikusan futtassa-e a controllert.
     * @return boolean
     */
    public function getAutorun()
    {
        return $this->autorun;
    }
}