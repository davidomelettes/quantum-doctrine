<?php

namespace Omelettes\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormDateTime;

class FormDateTimeCompatible extends FormDateTime
{
    public function extractDateFromValue($value)
    {
        $dt = new \DateTime($value);
        return $dt->format('Y-m-d');
    }
    
    public function extractTimeFromValue($value)
    {
        $dt = new \DateTime($value);
        return $dt->format('H:i');
    }
    
    public function render(ElementInterface $element)
    {
        $realInput = parent::render($element);
        
        $fakeDateAttributes          = $element->getAttributes();
        $fakeDateAttributes['name']  = $element->getName() . '-date';
        $fakeDateAttributes['id']    .= '-date';
        $fakeDateAttributes['class'] = 'form-control date';
        $fakeDateAttributes['type']  = 'text';
        $fakeDateAttributes['value'] = $this->extractDateFromValue($element->getValue());
        $fakeDateInput = sprintf(
            '<input %s%s',
            $this->createAttributesString($fakeDateAttributes),
            $this->getInlineClosingBracket()
        );
        
        $fakeTimeAttributes          = $element->getAttributes();
        $fakeTimeAttributes['name']  = $element->getName() . '-time';
        $fakeTimeAttributes['id']    .= '-time';
        $fakeTimeAttributes['class'] = 'form-control time';
        $fakeTimeAttributes['type']  = 'text';
        $fakeTimeAttributes['value'] = $this->extractTimeFromValue($element->getValue());
        $fakeTimeInput = sprintf(
            '<input %s%s',
            $this->createAttributesString($fakeTimeAttributes),
            $this->getInlineClosingBracket()
        );
        
        return sprintf('%s<div class="row"><div class="col-md-6">%s</div><div class="col-md-6">%s</div></div>', $realInput, $fakeDateInput, $fakeTimeInput);
    }
    
}
