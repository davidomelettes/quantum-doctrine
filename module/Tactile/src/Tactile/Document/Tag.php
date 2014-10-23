<?php

namespace Tactile\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Omelettes\Listify\ListifyItemInterface;
use OmelettesDoctrine\Document as OmDoc;

/**
 * @ODM\Document(collection="tags", requireIndexes=true)
 */
class Tag extends OmDoc\AbstractAccountBoundDocument implements ListifyItemInterface
{
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $tag;
    
    public function __construct()
    {
        $this->attachedTo = new ArrayCollection();
    }
    
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }
    
    public function getTag()
    {
        return $this->tag;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            
            $filter->add(array(
                'name'			=> 'tag',
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
        return 'listify/tag';
    }
    
}
