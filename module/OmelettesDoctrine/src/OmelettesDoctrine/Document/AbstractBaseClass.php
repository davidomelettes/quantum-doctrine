<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\MappedSuperclass
 */
abstract class AbstractBaseClass extends AbstractDocument implements InputFilter\InputFilterAwareInterface
{
    /**
     * @var string
     * @ODM\Id(strategy="UUID")
     */
    protected $id;
    
    /**
     * @var \DateTime
     * @ODM\Date
     */
    protected $created;
    
    /**
     * @var \DateTime
     * @ODM\Date
     */
    protected $updated;
    
    /**
     * @var \DateTime
     * @ODM\Date
     * @ODM\Index
     */
    protected $deleted;
    
    /**
     * @var InputFilter\InputFilterInterface
     */
    protected $inputFilter;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setCreated(\DateTime $date)
    {
        $this->created = $date;
        return $this;
    }
    
    public function getCreated()
    {
        return $this->created;
    }
    
    public function setUpdated(\DateTime $date)
    {
        $this->updated = $date;
        return $this;
    }
    
    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function setInputFilter(InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception('Interface method not used');
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = new InputFilter\InputFilter();
            
            $this->inputFilter = $filter;
        }
        return $this->inputFilter;
    }
    
}