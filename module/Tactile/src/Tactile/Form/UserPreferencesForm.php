<?php

namespace Tactile\Form;

use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Form\AbstractDocumentForm;
use Zend\InputFilter;

class UserPreferencesForm extends AbstractDocumentForm
{
    public function init()
    {
        $this->setName('preferences');
        
        $preferencesFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\PreferencesFieldset');
        $this->add($preferencesFieldset);
        
        $this->add(array(
            'name'       => 'newPassword',
            'type'       => 'Password',
            'options'    => array(
                'label' => 'Change your password',
            ),
            'attributes' => array(
                'id'           => $this->getName() . '-password',
                'autocomplete' => 'off',
            ),
        ));
        
        $this->add(array(
            'name' => 'newPasswordConfirm',
            'type' => 'Password',
            'options' => array(
                'label' => 'Confirm your new Password',
            ),
            'attributes' => array(
                'id'           => $this->getName() . '-passwordConfirm',
                'autocomplete' => 'off',
            ),
        ));
        
        $this->addSubmitFieldset('Save changes', 'btn btn-lg btn-primary btn-block');
    }
    
    public function getInputFilter()
    {
        if (!isset($this->filter)) {
            $filter = new InputFilter\InputFilter();
            
            $prefs = new OmDoc\UserPreferences();
            $filter->add($prefs->getInputFilter(), 'prefs');
            
            $filter->add(array(
                'name'       => 'newPassword',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 8,
                            'max'      => 255,
                        ),
                    ),
                ),
            ));
            $filter->add(array(
                'name'       => 'newPasswordConfirm',
                'filters'    => array(
                ),
                'validators' => array(
                    array(
                        'name'      => 'Zend\Validator\NotEmpty',
                        'options'   => array(
                            'type'  => \Zend\Validator\NotEmpty::NULL,
                        ),
                    ),
                    array(
                        'name'      => 'Zend\Validator\Identical',
                        'options'   => array(
                            'token' => 'newPassword',
                        ),
                    ),
                ),
            ));
            $this->filter = $filter;
        }
        
        return $this->filter;
    }
    
}