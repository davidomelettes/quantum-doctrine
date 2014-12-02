<?php

namespace TactileAdmin\Form\Fieldset;

use Omelettes\Form\ViewPartialInterface;
use OmelettesDoctrine\Form\Fieldset\AbstractDocumentFieldset;

class CustomFieldFieldset extends AbstractDocumentFieldset implements ViewPartialInterface
{
    public function init()
    {
        $this->setName('customFields');
        $this->setAttribute('class', 'customField');
        $this->setLabel('Custom Field');
        
        $this->add(array(
            'name'       => 'name',
            'type'       => 'Text',
            'options'    => array(
                'label' => 'Text Field Name',
            ),
            'attributes' => array(
            ),
        ));
    }
    
    public function getHydrator()
    {
        return $this->getApplicationServiceLocator()->get('Tactile\Stdlib\Hydrator\MultiTypeCollectionHydrator');
    }
    
    public function getViewPartial()
    {
        return 'form/fieldset/custom-field';
    }
    
}
