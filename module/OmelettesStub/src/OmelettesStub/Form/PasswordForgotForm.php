<?php

namespace OmelettesStub\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;
use Zend\InputFilter;

class PasswordForgotForm extends AbstractDocumentForm
{
    public function __construct($name = 'signup', $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'emailAddress',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'Email Address',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-emailAddress',
                'required'    => true,
            ),
        ));
        
        $this->addSubmitFieldset('Request Password Reset', 'btn btn-lg btn-primary btn-block');
    }
    
    public function getInputFilter()
    {
        if (!isset($this->filter)) {
            $filter = parent::getInputFilter();
            $filter->add(array(
                'name'			=> 'emailAddress',
                'required'		=> 'true',
                'filters'		=> array(
                    array('name' => 'StringTrim'),
                ),
                'validators'	=> array(
                    array(
                        'name'		             => 'StringLength',
                        'break_chain_on_failure' => true,
                        'options'	             => array(
                            'encoding'	=> 'UTF-8',
                            'min'		=> 1,
                            'max'		=> 255,
                        ),
                    ),
                    array(
                        'name'                   => 'Zend\Validator\EmailAddress',
                        'break_chain_on_failure' => true,
                        'options'                => array(
                            'messages' => array(
                                \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Please enter a valid email address',
                            ),
                        ),
                    ),
                    array(
                        'name'                  => 'OmelettesDoctrine\Validator\Document\Exists',
                        'options'               => array(
                        'field'            => 'emailAddress',
                        'document_service' => $this->documentService,
                        ),
                            ),
                ),
            ));
            $this->filter = $filter;
        }
        
        return $this->filter;
    }
    
}