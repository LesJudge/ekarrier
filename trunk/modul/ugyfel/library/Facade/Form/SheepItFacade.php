<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;
use Uniweb\Module\Ugyfel\Library\Decorator\SheepItAddress;
use Uniweb\Library\Utilities\ActiveRecord\SheepIt\CollectionSerializer;
use Uniweb\Library\Utilities\ActiveRecord\SheepIt\JsonSerializeModel;
use Uniweb\Library\Form\Interfaces\AssignableInterface;

class SheepItFacade implements AssignableInterface
{
    public function assign(\ArrayObject $data)
    {
        // Iskolai végzettségek.
        $educations = new CollectionSerializer($data->offsetGet('client')->educations, array(
            'educationForm_#index#', 
            array(
                'ugyfel_attr_vegzettseg_id', 
                'vegzettseg_id', 
                'iskola', 
                'kezdet', 
                'veg', 
                'szak',
                'megnevezes'
            )
        ));
        // Nyelvtudás.
        $knowledges = new CollectionSerializer($data->offsetGet('client')->knowledges, array(
            'knowledgeForm_#index#', array('ugyfel_attr_nyelvtudas_id', 'nyelvtudas_nyelv_id', 'nyelvtudas_szint_id')
        ));
        // Számítógépes ismeret.
        $computerKnowledge = new CollectionSerializer($data->offsetGet('client')->computerknowledges, array(
            'cKnowledgeForm_#index#', array('ugyfel_attr_szamitogepes_ismeret_id', 'ismeret')
        ));
        // Címek.
        $addresses = new CollectionSerializer($data->offsetGet('client')->addresses, array(
            'addressForm_#index#', array(
                'ugyfel_attr_cim_id',
                'ugyfel_cim_tipus_id',
                'orszag',
                'megye',
                'varos',
                'iranyitoszam',
                'utca',
                'hazszam'
            )
        ));
        // Munkakörök.
        $jobs = new CollectionSerializer($data->offsetGet('client')->jobs, array(
            'jobForm_#index#', array('ugyfel_attr_munkakor_id', 'munkakor_nev')
        ));
        //$addresses = array();
        /* @var $clientAddresses \Uniweb\Module\Ugyfel\Model\ActiveRecord\Address */
        /*
        $clientAddresses = $data->offsetGet('client')->addresses;
        if (is_array($clientAddresses) && !empty($clientAddresses)) {
            $prefix = 'addressForm_#index#';
            $attributes = array(
                'ugyfel_attr_cim_id',
                'ugyfel_cim_tipus_id',
                'cim_orszag_id',
                'cim_megye_id',
                'cim_varos_id',
                'cim_iranyitoszam_id',
                'utca',
                'hazszam'
            );
            foreach ($clientAddresses as $clientAddress) {
                $serializeModel = new JsonSerializeModel($clientAddress, $prefix, $attributes);
                $decorator = new SheepItAddress($clientAddress, $prefix);
                $addresses[] = array_merge(
                    $serializeModel->jsonSerialize(), 
                    $decorator->getCountryName(), 
                    $decorator->getCountyName(),
                    $decorator->getCityName(),
                    $decorator->getZipCode()
                );
            }
        }
        */
        $data->offsetSet('educations', \Uniweb\Functions\json_encode($educations));
        $data->offsetSet('knowledges', \Uniweb\Functions\json_encode($knowledges));
        $data->offsetSet('computerKnowledges', \Uniweb\Functions\json_encode($computerKnowledge));
        $data->offsetSet('addresses', \Uniweb\Functions\json_encode($addresses));
        $data->offsetSet('jobs', \Uniweb\Functions\json_encode($jobs));
    }
}