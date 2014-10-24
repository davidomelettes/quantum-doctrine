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
    protected $name;
    
    public function setName($tag)
    {
        $this->name = $tag;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            
            $filter->add(array(
                'name'			=> 'name',
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
                            'max'		=> 32,
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
