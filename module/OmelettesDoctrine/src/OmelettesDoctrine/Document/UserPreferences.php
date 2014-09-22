<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\EmbeddedDocument
 */
class UserPreferences implements InputFilter\InputFilterAwareInterface
{
    /**
     * @var string
     * @ODM\String
     */
    protected $tz = 'Europe/London';
    
    /**
     * @var InputFilter\InputFilterInterface
     */
    protected $filter;
    
    public function setTz($timezone)
    {
        $this->tz = $timezone;
        return $this;
    }
    
    public function getTz()
    {
        return $this->tz;
    }
    
    public function setInputFilter(InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception('Method not used');
    }
    
    public function getInputFilter()
    {
        if (!$this->filter) {
            $filter = new InputFilter\InputFilter();
            
            $filter->add(array(
                'name'			=> 'tz',
                'required'      => true,
                'filters'		=> array(
                ),
                'validators'	=> array(
                ),
            ));
            
            $this->filter = $filter;
        }
        return $this->filter;
    }
    
}
