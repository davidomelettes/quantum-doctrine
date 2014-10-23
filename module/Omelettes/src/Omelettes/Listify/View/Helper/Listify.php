<?php

namespace Omelettes\Listify\View\Helper;

use Omelettes\Tabulatable;
use Zend\Form\View\Helper\AbstractHelper;
use Omelettes\Listify\ListifyItemInterface;

class Listify extends AbstractHelper
{
    protected $options = array(
        'list_class' => 'list-unstyled',
    );
    
    public function __invoke($data, array $options = array())
    {
        $opts = $this->options;
        foreach ($options as $k => $v) {
            $opts[$k] = $v;
        }
        foreach ($data as $datum) {
            if (!$datum instanceof ListifyItemInterface) {
                throw new \Exception('Expected ListifyItemInterface');
            }
        }
        
        $partialHelper = $this->getView()->plugin('partial');
        return $partialHelper('listify', array(
            'data'		=> $data,
            'options'	=> $opts,
        ));
    }
    
}
