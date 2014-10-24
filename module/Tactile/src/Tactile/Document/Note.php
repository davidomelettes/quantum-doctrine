<?php

namespace Tactile\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Omelettes\Listify\ListifyItemInterface;
use OmelettesDoctrine\Document as OmDoc;

/**
 * @ODM\Document(
 *     collection="notes"
 * )
 */
class Note extends OmDoc\AbstractAccountBoundHistoricDocument implements ListifyItemInterface
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
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "c"="Tactile\Document\Contact"
     *     }
     * )
     * @ODM\Index
     */
    protected $attachedTo;
    
    public function __construct()
    {
        $this->attachedTo = new ArrayCollection();
    }
    
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
    
    public function setAttachedTo($items)
    {
        $this->attachedTo = $items;
        return $this;
    }
    
    public function getAttachedTo()
    {
        return $this->attachedTo;
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
    
    public function getListifyItemPartial()
    {
        return 'listify/note';
    }
    
}
