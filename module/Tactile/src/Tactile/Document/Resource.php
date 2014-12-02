<?php

namespace Tactile\Document;

use Omelettes\Tabulate\TabulateItemInterface;
use OmelettesDoctrine\Document as OmDoc;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\Document(
 *     collection="resources",
 *     requireIndexes=true
 * )
 * @ODM\UniqueIndex(keys={"account.id"="asc", "slug"="asc"})
 */
class Resource extends OmDoc\AbstractAccountBoundHistoricDocument implements TabulateItemInterface
{
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $slug;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $singular;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $plural;
    
    /**
     * @var boolean
     * @ODM\Boolean
     */
    protected $protected;
    
    /**
     * @var Array
     * @ODM\ReferenceMany(
     *     targetDocument="Tactile\Document\Tag"
     * )
     * @ODM\Index
     */
    protected $tags = array();
    
    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(
     *     strategy="setArray",
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "t"="Tactile\Document\ResourceFieldText",
     *         "n"="Tactile\Document\ResourceFieldNumeric",
     *         "d"="Tactile\Document\ResourceFieldDate",
     *         "o"="Tactile\Document\ResourceFieldOptions",
     *         "u"="Tactile\Document\ResourceFieldUser",
     *     }
     * )
     */
    protected $customFields;
    
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
    
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function setSingular($label)
    {
        $this->singular = $label;
        return $this;
    }
    
    public function getSingular()
    {
        return $this->singular;
    }
    
    public function setPlural($label)
    {
        $this->plural = $label;
        return $this;
    }
    
    public function getPlural()
    {
        return $this->plural;
    }
    
    public function setProtected($protected)
    {
        $this->protected = (boolean) $protected;
        return $this;
    }
    
    public function getProtected()
    {
        return $this->protected;
    }
    
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }
    
    public function getTags()
    {
        return $this->tags;
    }
    
    public function addTags($toAdd)
    {
        foreach ($toAdd as $add) {
            $this->tags->add($add);
        }
        return $this;
    }
    
    public function removeTags($toRemove)
    {
        foreach ($toRemove as $remove) {
            $this->tags->removeElement($remove);
        }
        return $this;
    }
    
    public function setCustomFields($methods)
    {
        $this->customFields = $methods;
        return $this;
    }
    
    public function getCustomFields()
    {
        return $this->customFields;
    }
    
    public function addCustomFields($toAdd)
    {
        foreach ($toAdd as $add) {
            $this->customFields->add($add);
        }
        return $this;
    }
    
    public function removeCustomFields($toRemove)
    {
        foreach ($toRemove as $remove) {
            $this->customFields->removeElement($remove);
        }
        return $this;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            
            $filter->add(array(
                'name'			=> 'slug',
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
            
            $filter->add(array(
                'name'			=> 'singular',
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
            
            $filter->add(array(
                'name'			=> 'plural',
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
    
    public function getTabulateHeadings()
    {
        return array(
            'plural' => 'Name'
        );
    }
    
    public function getTabulateRowPartial()
    {
        return 'tabulate/resource';
    }
    
}