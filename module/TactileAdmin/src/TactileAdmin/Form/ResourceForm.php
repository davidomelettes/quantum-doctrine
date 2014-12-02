<?php

namespace TactileAdmin\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;

class ResourceForm extends AbstractDocumentForm
{
    public function init()
    {
        $this->setName('resource');
        
        $this->add(array(
            'type'    => 'Text',
            'name'    => 'slug',
            'options' => array(
                'label' => 'URL Slug',
            ),
        ));
        
        $this->add(array(
            'type'    => 'Text',
            'name'    => 'singular',
            'options' => array(
                'label' => 'Singular Label',
            ),
        ));
        
        $this->add(array(
            'type'    => 'Text',
            'name'    => 'plural',
            'options' => array(
                'label' => 'Plural Label',
            ),
        ));
        
        $customFieldFieldset = $this->getServiceLocator()->get('TactileAdmin\Form\Fieldset\CustomFieldFieldset');
        $textFieldset = $this->getServiceLocator()->get('TactileAdmin\Form\Fieldset\CustomFieldTextFieldset');
        $dateFieldset = $this->getServiceLocator()->get('TactileAdmin\Form\Fieldset\CustomFieldDateFieldset');
        $numericFieldset = $this->getServiceLocator()->get('TactileAdmin\Form\Fieldset\CustomFieldNumericFieldset');
        $userFieldset = $this->getServiceLocator()->get('TactileAdmin\Form\Fieldset\CustomFieldUserFieldset');
        $optionsFieldset = $this->getServiceLocator()->get('TactileAdmin\Form\Fieldset\CustomFieldOptionsFieldset');
        $this->add(array(
            'type'    => 'Omelettes\Form\Element\MultiTypeCollection',
            'name'    => 'customFields',
            'options' => array(
                'label'                  => 'Custom Fields',
                'count'                  => 0,
                'allow_add'              => true,
                'allow_remove'           => true,
                'create_new_objects'     => true,
                'should_create_template' => true,
                'target_element'         => $customFieldFieldset,
                'target_map'             => array(
                    't' => $textFieldset,
                    'n' => $numericFieldset,
                    'd' => $dateFieldset,
                    'o' => $optionsFieldset,
                    'u' => $userFieldset,
                ),
                'default_type'           => 't',
                'type_labels'            => array(
                    't' => 'Text',
                    'n' => 'Numeric',
                    'd' => 'Date',
                    'o' => 'Options',
                    'u' => 'User',
                ),
            ),
            'attributes' => array(
                'class'      => 'customFields',
            ),
        ));
        
        $this->addSubmitFieldset('Save Resource');
    }
    
}
