<?php

namespace Omelettes\View\Helper;

use Omelettes\Tabulatable;
use Zend\Form\View\Helper\AbstractHelper;

class Tabulate extends AbstractHelper
{
    public function __invoke(Tabulatable\TabulatableSetInterface $data, array $options = array())
    {
        $mock = $data->getTableMock();
        if (!$mock instanceof Tabulatable\TabulatableItemInterface) {
            throw new \Exception('Expected TabulatableItemInterface');
        }
        
        $partialHelper = $this->getView()->plugin('partial');
        return $partialHelper('tabulate', array(
            'data'		=> $data->getCurrentItems(),
            'mock'		=> $mock,
            'options'	=> $options,
        ));
    }
    
}
