<?php
/**
 * A lapozást kezelő osztály
 * 
 * @package FrameWork
 * @subpackage Library
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class Paging {
    /**
     * @var array $_REQUEST|$_GET|$_POST|$_SESSION|$_FILE
     */
    public $_action_type;
    /**
     * @var int Elem/oldal
     */
    public $_limit_per_page = 10;
    /**
     * @var string A lapozásért felelős $_action_type tömb indexe
     */
    private $paging_url_var = "oldal";
    /**
     * @var mixed URL
     */
    private $paging_url;
    /**
     * @var int Összes elem
     */
    private $szum_items;
    /**
     * @var int Kezdő elem száma
     */
    private $limit_start;
    /**
     * @var int Pozitív linkek száma
     */
    private $paging_number_poz = 3;
    /**
     * @var int Negatív linkek száma
     */
    private $paging_number_neg = 3;
    /**
     * @var string Előző felirat
     */
    private $prev_text = '<span class="ui-icon ui-icon-seek-prev"></span>';
    /**
     * @var string Következő felirat
     */
    private $next_text = '<span class="ui-icon ui-icon-seek-next"></span>';

    /**
     * _action_type beállítása
     * 
     */
    public function __construct() {
        $this->_action_type = $_REQUEST;
    }
    
    /**
     * URL beállítása. {@link Paging::$paging_url}
     * 
     * @param mixed $url
     */
    public function __setURL($url = null) {
        $this->paging_url = ($url) ? $url : $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"];              
        $this->paging_url = preg_replace('/([?&])'.$this->paging_url_var.'=[^&]+(&|$)/','$1',$this->paging_url);
        $this->paging_url = rtrim($this->paging_url,"&?");
    }

    /**
     * Összes elem, illetve elem/oldal beállítása.
     * 
     * @uses Paging::set_start()
     * 
     * @param int $sum_items
     */
    public function set($sum_items) {
        $this->szum_items = ((int)$sum_items > 0 ? (int)$sum_items : 0);
        $this->set_start($this->get_activ_page());
    }

  
    /**
     * Beállítja a megjelenő pozitív és negatív linkek számát.
     * 
     * @param int $poz_link_limit
     * @param int $neg_link_limit
     */
    public function setLinkLimit($poz_link_limit, $neg_link_limit) {
        $this->paging_number_poz = ((int)$poz_link_limit);
        $this->paging_number_neg = ((int)$neg_link_limit);
    }

    /**
     * Összes oldal meghatározása (int)
     * 
     */
    private function get_number_of_page() {
        return ceil($this->szum_items / $this->_limit_per_page);
    }

    /**
     * Aktív oldal meghatározása.
     * 
     * @return $actual_page|1
     */
    private function get_activ_page() {
        $paging_var = $this->_action_type[$this->paging_url_var];
        $actual_page = (isset($paging_var) && $paging_var > 0) ? $paging_var : 1;
        $max_page = $this->get_number_of_page();
        if ($actual_page > $max_page and $max_page > 0)
            $actual_page = $max_page;
        return $actual_page;
    }

    /**
     * Query LIMIT start beállítása.
     * 
     * @param int $actual_page
     */
    private function set_start($actual_page) {
        if ($actual_page)
            $this->limit_start = ($actual_page - 1) * $this->_limit_per_page;
    }

    /**
     * A lapozáshoz szükséges template változó összeállítása
     * 
     * A linkek száma kötött($paging_number_poz + $paging_number_neg). 
     * Ha kevesebb pozitív és negatív link létezik, mint a limit, 
     * akkor az ellenkező előjelűből ad hozzá. A végén a tömböt 
     * sorba rendezi azonosító szerint.
     * 
     * @uses Paging::get_number_of_page()
     * @uses Paging::get_activ_page()
     * @uses Paging::add_element()
     * 
     * @return array|false
     */
    public function getTemplate() {
        $max_page = $this->get_number_of_page();
        if ($max_page < 2) {
            return false;
        }
        $aktual_page = $this->get_activ_page();
        $page_pos = $page_neg = $aktual_page;

        $_paginate["url"] = $this->paging_url;
        $_paginate["urlvar"] = ((strpos($this->paging_url,"?")===false)?"?":"&amp;") . $this->paging_url_var;
        $_paginate["total_item"] = $this->szum_items;
        $_paginate["limit"] = $this->_limit_per_page;
        $_paginate["last_page"] = $max_page;
        $_paginate["prev_text"] = $this->prev_text;
        $_paginate["next_text"] = $this->next_text;
        $_paginate["prev_item"] = ($aktual_page - 1 > 0) ? $aktual_page - 1 : "";
        $_paginate["next_item"] = ($aktual_page + 1 < $max_page + 1) ? $aktual_page + 1 : "";
        $_paginate["activ"] = $aktual_page;

        $limit = $this->paging_number_neg + $this->paging_number_poz;
        $_paginate["page"][$aktual_page] = $this->add_element($aktual_page);

        while ($muvelet < $this->paging_number_neg) {
            if ($page_neg > 1) {
                $page_neg--;
                $_paginate["page"][$page_neg] = $this->add_element($page_neg);
            } elseif ($page_pos < $max_page) {
                $page_pos++;
                $_paginate["page"][$page_pos] = $this->add_element($page_pos);
            }
            $muvelet++;
        }

        while ($muvelet < $this->paging_number_neg + $this->paging_number_poz) {
            if ($page_pos < $max_page) {
                $page_pos++;
                $_paginate["page"][$page_pos] = $this->add_element($page_pos);
            } elseif ($page_neg > 1) {
                $page_neg--;
                $_paginate["page"][$page_neg] = $this->add_element($page_neg);
            }
            $muvelet++;
        }
        sort($_paginate["page"]);
        return $_paginate;
    }

    /**
     * Elem hozzáadása a lapozáshoz.
     * 
     * @param int $page_id
     * 
     * @return array elem
     */
    private function add_element($page_id) {
        $element["value"] = $page_id;
        $element["item_start"] = (($page_id - 1) * $this->_limit_per_page) + 1;
        $element["item_end"] = (($page_id * $this->_limit_per_page) <= $this->szum_items) ? ($page_id * $this->
            limit_step) : $this->szum_items;
        $element["activ"] = ($page_id == $this->get_activ_page());
        return $element;
    }

    /**
     * Az oldalnak megfelelő MYSQL LIMIT elkészítése 
     * 
     * @return string LIMIT
     */
    public function getSqlLimit() {
        return " LIMIT {$this->limit_start} , {$this->_limit_per_page} ";
    }
}

?>