<?php

namespace Tactile\Form\Element;

use Doctrine\Common\Collections\Collection;
use Tactile\Service;
use Zend\Form\Element\Text;
use Zend\InputFilter\InputProviderInterface;

class CommaSeparatedTags extends Text implements InputProviderInterface
{
    protected $attributes = array(
        'type' => 'tags',
    );
    
    /**
     * @var Service\TagsService
     */
    protected $tagsService;
    
    public function setOptions($options)
    {
        parent::setOptions($options);
    
        if (!isset($options['tags_service'])) {
            throw new Exception\InvalidArgumentException('tags_service option not specified');
        }
        $this->setTagsService($options['tags_service']);
    
        return $this;
    }
    
    public function setTagsService(Service\TagsService $service)
    {
        $this->tagsService = $service;
        return $this;
    }
    
    public function getTagNames($imploded = false)
    {
        $names = array();
        if ($this->value instanceof Collection) {
            foreach ($this->value as $tag) {
                $names[] = $tag->getName();
            }
        } else {
            $names = preg_split('/,/', $this->value, -1, PREG_SPLIT_NO_EMPTY);
        }
        return $imploded ? implode(',', $names) : $names;
    }

    public function getInputSpecification()
    {
        $spec = array(
            'name'       => $this->getName(),
            'required'   => false,
            'filters'    => array(
                array(
                    'name'    => 'Tactile\Filter\CommaSeparatedTags',
                    'options' => array(
                        'tags_service' => $this->tagsService,
                    ),
                ),
            ),
            'validators' => array(
                array(
                    'name'    => 'Tactile\Validator\CommaSeparatedTags',
                    'options' => array(
                        'tags_service' => $this->tagsService,
                    ),
                ),
            ),
        );
        
        return $spec;
    }
    
}
