<?php

namespace Tactile\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Omelettes\Listable\ListableItemInterface;
use OmelettesDoctrine\Document as OmDoc;

/**
 * @ODM\Document(collection="notes", requireIndexes=true)
 */
class Note extends OmDoc\AbstractAccountBoundHistoricDocument implements ListableItemInterface
{
    const FORMAT_RAW = 'raw';
    
    /**
     * @var string
     * @ODM\String
     */
    protected $body;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $format = self::FORMAT_RAW;
    
    /**
     * @var ArrayCollection
     * @ODM\ReferenceMany(
     *     strategy="addToSet",
     *     targetDocument="Tactile\Document\Quantum"
     * )
     */
    protected $attachedTo;
    
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
    
    public function getBody()
    {
        return $this->body;
    }
    
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }
    
    public function getFormat()
    {
        return $this->format;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            
            $filter->add(array(
                'name'			=> 'body',
                'required'		=> true,
                'filters'		=> array(
                    array('name' => 'StringTrim'),
                ),
                'validators'	=> array(
                    array(
                        'name'		=> 'StringLength',
                        'options'	=> array(
                            'encoding'	=> 'UTF-8',
                            'min'		=> 1,
                            'max'		=> 255,
                        ),
                    ),
                ),
            ));
            
            $this->inputFilter = $filter;
        }
        
        return $this->inputFilter;
    }
    
    public function getListItemPartial()
    {
        return 'listable/note';
    }
    
}
