<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Behavior\ClientId;
use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Author;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\NumberOfModifications;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Timestamp;
use Uniweb\Library\Resource\Interfaces\ResourcableInterface;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;

abstract class BaseResourcable extends Behaviorable implements ResourcableInterface
{
    public function behaviors()
    {
        return array(
            'clientId' => new ClientId,
            'author' => new Author('letrehozo_id', 'modosito_id'),
            'modifications' => new NumberOfModifications('modositas_szama'),
            'timestamp' => new Timestamp('letrehozas_timestamp', 'modositas_timestamp')
        );
    }
    /**
     * @return string Erőforrás kulcsa.
     */
    public static function getResourceKey()
    {
        return Client::$primary_key;
    }
}