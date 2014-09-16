<?php

namespace Omelettes\Form;

interface ViewPartialInterface
{
    /**
     * Returns the name of a view partial to use instead of the default 
     * @return string
     */
    public function getViewPartial();
    
}