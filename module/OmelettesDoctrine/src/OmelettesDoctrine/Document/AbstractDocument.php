<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Service\AbstractDocumentService;
use Zend\InputFilter;

/**
 * @ODM\MappedSuperclass
 */
abstract class AbstractDocument implements InputFilter\InputFilterAwareInterface
{
    /**
     * @var string
     * @ODM\Id(strategy="UUID")
     */
    protected $id;
    
    /**
     * @var InputFilter\InputFilterInterface
     */
    protected $inputFilter;
    
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
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setData(array $data)
    {
        foreach ($data as $k => $v) {
            $method = 'set' . $k;
            if (!method_exists($this, $method)) {
                throw new \Exception('Invalid Document property: ' . $k);
            }
            $this->$method($v);
        }
        return $this;
    }
    
}
