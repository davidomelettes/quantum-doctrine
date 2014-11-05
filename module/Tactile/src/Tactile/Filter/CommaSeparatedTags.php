<?php

namespace Tactile\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Tactile\Document;
use Tactile\Service;
use Zend\Filter;

class CommaSeparatedTags extends Filter\AbstractFilter
{
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
    
    public function filter($value)
    {
        $parts = preg_split('/,/', $value, -1, PREG_SPLIT_NO_EMPTY);
        $output = array();
        
        $mock = new Document\Tag();
        $tagFilter = $mock->getInputFilter();
        foreach ($parts as $part) {
            // Filter the tag name
            $stringTrim = new Filter\StringTrim();
            $tagName = $stringTrim->filter($part);
            
            // Check for existance
            $tag = $this->tagsService->findBy('name', $tagName);
            if (!$tag) {
                $tag = new Document\Tag();
                $tag->setName($tagName);
                $this->tagsService->save($tag);
            }
            
            $output[] = $tag;
        }
        $this->tagsService->commit();
        
        return $output;
    }
    
}
