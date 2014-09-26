<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ContactAddress implements InputFilter\InputFilterAwareInterface
{
    /**
     * @var string
     * @ODM\String
     */
    protected $street1;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $street2;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $street3;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $city;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $county;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $postalCode;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $country;
    
    /**
     * @var InputFilter\InputFilter
     */
    protected $inputFilter;
    
    public function setStreet1($street1)
    {
        $this->street1 = $street1;
        return $this;
    }
    
    public function getStreet1()
    {
        return $this->street1;
    }
    
    public function setStreet2($street2)
    {
        $this->street2 = $street2;
        return $this;
    }
    
    public function getStreet2()
    {
        return $this->street2;
    }
    
    public function setStreet3($street3)
    {
        $this->street3 = $street3;
        return $this;
    }
    
    public function getStreet3()
    {
        return $this->street3;
    }
    
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function setCounty($county)
    {
        $this->county = $county;
        return $this;
    }
    
    public function getCounty()
    {
        return $this->county;
    }
    
    public function setPostalCode($code)
    {
        $this->postalCode = $code;
        return $this;
    }
    
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
    
    public function getCountry()
    {
        return $this->country;
    }
    
    public function setInputFilter(InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception('Interface method not used');
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter\InputFilter();
            
            $inputFilter->add(array(
                'name'     => 'street1',
                'required' => false,
            ));
            
            $inputFilter->add(array(
                'name'     => 'street2',
                'required' => false,
            ));
            
            $inputFilter->add(array(
                'name'     => 'street3',
                'required' => false,
            ));
            
            $inputFilter->add(array(
                'name'     => 'city',
                'required' => false,
            ));
            
            $inputFilter->add(array(
                'name'     => 'county',
                'required' => false,
            ));
            
            $inputFilter->add(array(
                'name'     => 'postalCode',
                'required' => false,
            ));
            
            $inputFilter->add(array(
                'name'     => 'country',
                'required' => false,
            ));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
}