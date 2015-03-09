<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class Job implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        /* @var $jobs \Uniweb\Module\Ugyfel\Model\ActiveRecord\Job */
        $jobs = $client->jobs;
        $data = array();
        if (is_array($jobs) && !empty($jobs)) {
            foreach ($jobs as $job) {
                $data[] = $job->munkakor_nev;
            }
        }
        return $data;
    }
}