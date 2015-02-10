<?php

class AuthRedirecter
{
    /**
     * Be van-e jelentkezve a felhasználó.
     * @var boolean
     */
    protected $authorized;
    /**
     * Aktuális URI.
     * @var string
     */
    protected $currentUri;
    /**
     * URI, amire átirányítja a felhasználót, ha be van jelentkezve.
     * @var string
     */
    protected $authorizedUri;
    /**
     * URI, amire átirányítja a felhasználót, ha nincs bejelentkezve.
     * @var string
     */
    protected $unauthorizedUri;
    /**
     * Konstruktor.
     * @param type $authorized
     * @param type $currentUri
     * @param type $authorizedUri
     * @param type $unauthorizedUri
     */
    public function __construct($authorized, $currentUri, $authorizedUri, $unauthorizedUri)
    {
        $this->authorized = (boolean)$authorized;
        $this->currentUri = $currentUri;
        $this->authorizedUri = $authorizedUri;
        $this->unauthorizedUri = $unauthorizedUri;
    }
    
    public function correctUri()
    {
        $uris = array($this->unauthorizedUri, $this->authorizedUri);
        $neededUri = $uris[(int)$this->getAuthorized()];
        if ($this->currentUri != $neededUri) {
            $this->redirect($neededUri);
        }
    }
    /**
     * Átirányít a paraméterül adott URI-ra.
     * @param string $uri URI, amire át kell irányítania.
     */
    public function redirect($uri)
    {
        header('Location: ' . Rimo::getConfig()->DOMAIN . $uri);
        exit;
    }
    /**
     * Be van-e jelentkezve a felhasználó.
     * @return boolean
     */
    public function getAuthorized()
    {
        return $this->authorized;
    }
    /**
     * Visszatér az aktuális URI-val.
     * @return string
     */
    public function getCurrentUri()
    {
        return $this->currentUri;
    }
    /**
     * Visszatér a "bejelentkezett" URI-val.
     * @return string
     */
    public function getAuthorizedUri()
    {
        return $this->authorizedUri;
    }
    /**
     * Visszatér a "nem bejelentkezett" URI-val.
     * @return string
     */
    public function getUnauthorizedUri()
    {
        return $this->unauthorizedUri;
    }
}