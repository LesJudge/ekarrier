<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\Address;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;

abstract class AddressAbstract implements ReaderInterface
{
    /**
     * Visszatér az ügyfélhez tartozó lakcím objektummal.
     * @param Client $client Ügyfél objektum.
     * @return \Uniweb\Module\Ugyfel\Model\ActiveRecord\Address
     */
    protected function getResidenceByClient(Client $client)
    {
        /* @var $addresses \Uniweb\Module\Ugyfel\Model\ActiveRecord\Address[] */
        $addresses = $client->addresses;
        if (is_array($addresses) && !empty($addresses)) {
            foreach ($addresses as $address) {
                if ($address->ugyfel_cim_tipus_id == 1) {
                    return $address;
                }
            }
        }
        return null;
    }
}