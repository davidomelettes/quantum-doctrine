<?php

namespace Omelettes\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class PrettyText extends AbstractHelper
{
    const EMPTY_STRING = '<span class="text-muted">&mdash;</span>';
    
    public function __invoke($text)
    {
        if (null === $text || '' === $text) {
            return self::EMPTY_STRING;
        }
        
        $escaper = $this->getView()->plugin('escapeHtml');
        
        return nl2br($escaper($text));
    }
	
}
