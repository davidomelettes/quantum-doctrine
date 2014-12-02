<?php

namespace TactileAdmin\Form\Fieldset;

use Tactile\Document;
use OmelettesDoctrine\Form\Fieldset\AbstractDocumentFieldset;
use Omelettes\Form\ViewPartialInterface;

class CustomFieldOptionsOptionFieldset extends AbstractDocumentFieldset implements ViewPartialInterface
{
    public function init()
    {
        $this->setName('options');
        $this->setAttribute('class', 'option');
        $this->setAllowedObjectBindingClass('Tactile\Document\ResourceFieldOptionsOption');
        $this->setLabel('Option');
        $this->setObject(new Document\ResourceFieldOptionsOption());
        
        $this->add(array(
            'name'       => 'option',
            'type'       => 'Text',
            'options'    => array(
                'label' => 'Option Name',
            ),
            'attributes' => array(
            ),
        ));
    }
    
    public function getViewPartial()
    {
        return 'form/fieldset/custom-field-options-option';
    }
    
}
