<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\ProjectInformation;
use Uniweb\Module\Ugyfel\Library\Xls\Reader\AbstractTrueOrFalse;

class CoopAgreementTraining extends AbstractTrueOrFalse
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        return $this->createReadableValue($client->projectinformation->egy_megall_ktttnk_kepz);
    }
}