<?php

namespace Tactile\Form\Fieldset;

use Omelettes\Form\ViewPartialInterface;
use OmelettesDoctrine\Form\Fieldset\AbstractDocumentFieldset;
use Tactile\Document;

class ContactAddressFieldset extends AbstractDocumentFieldset implements ViewPartialInterface
{
    public function init()
    {
        $this->setName('addresses');
        $this->setAttribute('class', 'address');
        $this->setAllowedObjectBindingClass('Tactile\Document\ContactAddress');
        $this->setLabel('Address');
        $this->setObject(new Document\ContactAddress());
        
        $this->add(array(
            'name'       => 'street1',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Street 1',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name'       => 'street2',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Street 2',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name'       => 'street3',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Street 3',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name'       => 'city',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'City',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name'       => 'county',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'County',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name'       => 'postalCode',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Postal Code',
            ),
            'attributes' => array(
            ),
        ));
        
        $localesService = $this->getApplicationServiceLocator()->get('OmelettesDoctrine\Service\LocalesService');
        $countryOptions = array('' => '-- Select Country --');
        foreach ($localesService->getCountries() as $country) {
            $countryOptions[$country->getCode()] = $country->getName();
        }
        $this->add(array(
            'name'       => 'country',
            'type'       => 'Select',
            'options'    => array(
                'label'         => 'Country',
                'options'       => $countryOptions,
            ),
            'attributes' => array(
            ),
        ));
    }
    
    public function getViewPartial()
    {
        return 'form/fieldset/address';
    }
    
}
