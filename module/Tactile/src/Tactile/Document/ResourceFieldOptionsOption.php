<?php

namespace Tactile\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Document as OmDoc;
use Zend\InputFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ResourceFieldOptionsOption implements InputFilter\InputFilterAwareInterface
{
    public function setInputFilter(InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception('Method not used');
    }
    
    public function getInputFilter()
    {
        
    }
    
}
