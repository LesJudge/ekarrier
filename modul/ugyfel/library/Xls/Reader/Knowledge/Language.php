<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\Knowledge;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class Language implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        /* @var $knowledges \Uniweb\Module\Ugyfel\Model\ActiveRecord\Knowledge */
        $knowledges = $client->knowledges;
        $data = array();
        if (is_array($knowledges) && !empty($knowledges)) {
            foreach ($knowledges as $knowledge) {
                $data[] = $knowledge->language->nev;
            }
        }
        return $data;
    }
}