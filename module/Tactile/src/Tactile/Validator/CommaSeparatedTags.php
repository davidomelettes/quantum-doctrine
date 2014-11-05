<?php

namespace Tactile\Validator;

use Tactile\Document;
use Tactile\Service;
use Zend\Validator;

class CommaSeparatedTags extends Validator\AbstractValidator
{
    const NOT_TRAVERSABLE  = 'notTraversable';
    const CONTAINS_NOT_TAG = 'containsNotTag';
    const INVALID_TAG_NAME = 'invalidTagName';
    
    protected $messageTemplates = array(
        self::NOT_TRAVERSABLE  => "Value is not traversable",
        self::CONTAINS_NOT_TAG => "One of the traversable values was not a Tag",
        self::INVALID_TAG_NAME => "'%value%' is not a valid tag name",
    );
    
    /**
     * @var Service\TagsService
     */
    protected $tagsService;
    
    public function __construct($options)
    {
        if (!isset($options['tags_service'])) {
            throw new \Exception('tags_service option not specified');
        }
        $this->setTagsService($options['tags_service']);
    }
    
    public function setTagsService(Service\TagsService $service)
    {
        $this->tagsService = $service;
        return $this;
    }
    
    public function isValid($value)
    {
        $this->setValue($value);
        
        // Must be iterable
        if (!is_array($value) && !$value instanceof \Traversable) {
            $this->error(self::NOT_TRAVERSABLE);
            return false;
        }
        $errorFree = true;
        foreach ($value as $tag) {
            // Each must be a Tag
            if (!$tag instanceof Document\Tag) {
                $this->error(self::CONTAINS_NOT_TAG);
                return false;
            }
            
            // Each name must be valid
            $inputFilter = $tag->getInputFilter();
            $inputFilter->setData(array('name' => $tag->getName()));
            if (!$inputFilter->isValid()) {
                $this->error(self::INVALID_TAG_NAME, $tag->getName());
                $errorFree = false;
            }
        }
        
        return $errorFree;
    }
    
}