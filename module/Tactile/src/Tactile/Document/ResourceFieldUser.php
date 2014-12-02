<?php

namespace Tactile\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Document as OmDoc;

/**
 * @ODM\EmbeddedDocument
 */
class ResourceFieldUser extends ResourceField
{
    /**
     * @ODM\String
     * @var string
     */
    protected $default;
    
    public function setDefault($default)
    {
        $this->default = $default;
    }
    
    public function getDefault()
    {
        return $this->default;
    }
    
    public function getType()
    {
        return 'u';
    }
    
}
