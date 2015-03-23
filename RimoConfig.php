<?php
/**
 * RimoConfig
 * 
 * @package FrameWork
 * @subpackage Config
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class RimoConfig
{

        const ROOT_RG = 1;
        const USER_RG = 2;
        const COMPANY_RG = 3;
        const EDITOR_RG = 4;
        const ADMIN_RG = 5;
        const KARRIERPONT_RG = 6;
        const DIAKMUNKA_1_RG = 7;

        public $CHARSET="UTF-8";
        public $SESSION_NAME="referenciasite";
        //public $SESSION_DIR="/var/www/session/admin";
        public $SESSION_DIR="session/admin";
        public $SQL_PATH="sql";
        public $MODEL_PATH="model";
        public $APP_PATH="";
        public $PAGE_NAME="";
        public $SITE_TIPUS="";
        //public $MYSQL_DB_NAME="uniweb_ekarrier2013";
        //public $MYSQL_DB_NAME="uniweb_ekarrier";
        public $MYSQL_DB_NAME="ekarrier_dev";
        public $MYSQL_DB_HOST="localhost";
        //public $MYSQL_DB_USER="uwsql19W";
        //public $MYSQL_DB_PASS="H56sJP:2";
        public $MYSQL_DB_USER="root";
        public $MYSQL_DB_PASS="";
        public $MYSQL_DB_CHARSET="utf8";
        public $PAGE_CHARSET="UTF-8";
        //public $DOMAIN_ADMIN="http://balazs.ekarrier.hadesz.lan/admin/";
        //public $DOMAIN="http://balazs.ekarrier.hadesz.lan/";
        //public $DOMAIN_ADMIN="http://local.ekarrier/admin/";
        //public $DOMAIN="http://local.ekarrier/";
        //public $DOMAIN_ADMIN="http://192.168.33.10/admin/";
        //public $DOMAIN="http://192.168.33.10/";
        public $DOMAIN_ADMIN="http://ekarrier.local/admin/";
        public $DOMAIN="http://ekarrier.local/";
        public $DEFAULT_NYELV_ID=1;
        public $ADMIN_NYELV_ID=1;
        public $ADMIN_NYELV_VAR="hu";
        public $SITE_NYELV_ID=1;
        public $MAIL_SMTP=true;
        public $MAIL_SMTP_AUTH=true;
        public $MAIL_HOST="mail.netra.hu";
        public $MAIL_PORT=2525;
        public $MAIL_USER="level@uniweb.hu";
        public $MAIL_PASS="Uwlevelplusz1";
        public $MAIL_CHARSET="UTF-8";
        public $ADMIN_EMAIL="balazs@uniweb.hu";
        public $FORM_ERROR=array(
                "form_mess_kotelezo" => "Kötelező kitölteni",
                "form_mess_number" => "Csak szám lehet!",
                "form_mess_select" => "Kötelező választani",
                "form_mess_file" => "Kötelező file-t feltölteni",
                "form_mess_kep" => "Csak képet tölthet fel",
                "form_mess_maxchar_start" => "Maximum ",
                "form_mess_maxchar_end" => " karaktert adhat meg",
                "form_mess_maxfile_start" => "Maximum ",
                "form_mess_maxfile_end" => " méretű fájlt adhat meg",
                "form_mess_datetimegreaterthan" => "A vég dátum nem lehet kisebb mint a kezdő dátum",
                "form_mess_datetime" => "Dátumot és órát és percet adjon meg",
                "form_mess_date" => "Dátumot adjon meg",
                "form_mess_equalTo" => "Meg kell egyeznie a két értéknek",
                "form_mess_equalToCaptcha" => "Nem megfelelő ellenőrző kód",
                "form_mess_email" => "Nem megfelelő e-mail cím formátum",
                "form_mess_unique" => "Az adatbázisban már szerepel ilyen elem",
                'form_mess_tableExists' => 'A megadott tábla már szerepel az adatbázisban',
        );
        public $FB_LIKEBOX=array(
                'class' => 'fb-like-box',
                'url' => 'https://www.facebook.com/ekarrier143?fref=ts',
                'width' => 300,
                'height' => 250,
                'colorscheme' => 'dark',
                'show_faces' => true,
                'header' => true,
                'stream' => false,
                'show_border' => false,
        );
        public $tooltips=array(
                array(
                        'label' => '1.',
                        'description' => 'Here is some text...',
                        'value' => 1
                ),
                array(
                        'label' => '2.',
                        'description' => 'Here is some text...',
                        'value' => 2
                ),
                array(
                        'label' => '3.',
                        'description' => 'Here is some text...',
                        'value' => 3
                ),
                array(
                        'label' => '4.',
                        'description' => 'Here is some text...',
                        'value' => 4
                ),
                array(
                        'label' => '5.',
                        'description' => 'Here is some text...',
                        'value' => 5
                ),
        );
        /**
         * Kulcs alapján visszatér a beállítás értékével.
         * @param string $item => Config elem kulcsa.
         * @return mixed
         * @throws RuntimeException
         */
        public function getItem($item)
        {
                if(isset($this->{$item}))
                {
                        return $this->{$item};
                }
                else
                {
                        throw new RuntimeException("A keresett config elem ($item) nem található!");
                }
        }
        
        public function setItem($item, $value)
        {
                
        }
        
        /**
         * A config objektum változóinak ad értéket.
         * 
         * @param mixed $config
         * @return
         */
        public function set(array $config)
        {
                foreach($config as $id => $val)
                {
                        $this->{$id}=$val;
                }
        }

}