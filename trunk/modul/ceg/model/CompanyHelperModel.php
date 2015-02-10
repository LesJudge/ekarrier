<?php
class CompanyHelperModel extends Model
{
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    /**
     * Példányosít magából egy új objektumot.
     * @return CompanyHelperModel
     */
    public static function model()
    {
        return new self;
    }
    /**
     * Lekérdezi a felhasználóhoz tartozó cégeket.
     * @param int $userId => Felhasználó azonosító.
     * @return mixed (array|false)
     */
    public function findCompanyByUserId($userId)
    {
        try {
            $query = "SELECT ceg_id FROM user_ceg WHERE user_id=" . (int) $userId . " LIMIT 1";
            return $this->_DB->prepare($query)->query_select()->query_fetch_array('ceg_id');
        } catch (Exception_MYSQL_Null_Rows $e) {
            return false;
        }
    }
}