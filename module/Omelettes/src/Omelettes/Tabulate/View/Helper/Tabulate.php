<?php

namespace Omelettes\Tabulate\View\Helper;

use Omelettes\Tabulate\TabulateSetInterface;
use Omelettes\Tabulate\TabulateItemInterface;
use Zend\Form\View\Helper\AbstractHelper;

class Tabulate extends AbstractHelper
{
    protected $options = array(
        'base_route' => null,
    );
    
    public function __invoke(TabulateSetInterface $data, array $options = array())
    {
        $opts = $this->options;
        foreach ($options as $k => $v) {
            $opts[$k] = $v;
        }
        
        foreach ($data as $datum) {
            if (!$datum instanceof TabulateItemInterface) {
                throw new \Exception('Expected TabulateItemInterface');
            }
        }
        
        $partialHelper = $this->getView()->plugin('partial');
        return $partialHelper('tabulate', array(
            'data'		=> $data->getTabulateItems(),
            'mock'		=> $data->getTabulateMock(),
            'options'	=> $opts,
        ));
    }
    
}
