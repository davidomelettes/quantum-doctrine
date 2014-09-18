<?php

namespace Tactile\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;
use Zend\InputFilter;

class UserPreferencesForm extends AbstractDocumentForm
{
    public function init()
    {
        $this->setName('preferences');
        $localesService = $this->getApplicationServiceLocator()->get('OmelettesDoctrine\Service\LocalesService');
        
        $tzOptions = $localesService->getTimeZones();
        $this->add(array(
            'name'       => 'tz',
            'type'       => 'Select',
            'options'    => array(
                'label'         => 'Time Zone',
                'value_options' => $tzOptions,
            ),
            'attributes' => array(
                'id'           => $this->getName() . '-tz',
                'required'     => true,
            ),
        ));
        
        $this->add(array(
            'name'       => 'password',
            'type'       => 'Password',
            'options'    => array(
                'label' => 'New password',
            ),
            'attributes' => array(
                'id'           => $this->getName() . '-password',
                'required'     => true,
                'autocomplete' => 'off',
            ),
        ));
        
        $this->add(array(
            'name' => 'passwordConfirm',
            'type' => 'Password',
            'options' => array(
                'label' => 'Confirm your new Password',
            ),
            'attributes' => array(
                'id'           => $this->getName() . '-passwordConfirm',
                'required'     => true,
                'autocomplete' => 'off',
            ),
        ));
        
        $this->addSubmitFieldset('Save changes', 'btn btn-lg btn-primary btn-block');
    }
    
    public function getInputFilter()
    {
        if (!isset($this->filter)) {
            $filter = parent::getInputFilter();
            $filter->add(array(
                'name'       => 'password',
                'required'   => 'true',
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
                'name'       => 'passwordConfirm',
                'required'   => 'true',
                'filters'    => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'      => 'Identical',
                        'options'   => array(
                            'token' => 'password',
                        ),
                    ),
                ),
            ));
            $this->filter = $filter;
        }
        
        return $this->filter;
    }
    
}