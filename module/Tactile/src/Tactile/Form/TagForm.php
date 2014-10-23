<?php

namespace Tactile\Form;

use Omelettes\Form\ViewPartialInterface;
use OmelettesDoctrine\Form\AbstractDocumentForm;
use Zend\InputFilter;

class TagForm extends AbstractDocumentForm implements ViewPartialInterface
{
    public function init()
    {
        $this->setName('tag');
        
        $this->add(array(
            'name' => 'tags',
            'type' => 'text',
            'options' => array(
                'label' => 'Tags',
            ),
        ));
        
        $this->addSubmitFieldset('Add Tags', 'btn btn-success btn-block');
    }
    
    public function getInputFilter()
    {
        if (!$this->filter) {
            $filter = new InputFilter\InputFilter();
            
            $filter->add(array(
                'name'       => 'tags',
                'required'   => true,
                'filters'    => array(),
                'validators' => array(),
            ));
            
            $this->filter = $filter;
        }
        return $this->filter;
    }
    
    public function getViewPartial()
    {
        return 'form/tag';
    }
    
}