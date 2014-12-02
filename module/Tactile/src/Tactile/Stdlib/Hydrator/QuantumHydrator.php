<?php

namespace Tactile\Stdlib\Hydrator;

use Tactile\Document;
use OmelettesDoctrine\Stdlib\Hydrator\UberHydrator;

class QuantumHydrator extends UberHydrator
{
    public function extract($object)
    {
        $data = parent::extract($object);
        if (isset($data['customValues'])) {
            // Munge for form
            $newData = array();
            foreach ($data['customValues'] as $customValue) {
                $newData[$customValue->getName()] = array(
                    'value' => $customValue->getValue(),
                );
            }
            $data['customValues'] = $newData;
        }
        
        return $data;
    }
    
    public function hydrate(array $data, $object)
    {
        if (isset($data['customValues'])) {
            // Prepare for EmbedMany
            $newData = array();
            foreach ($data['customValues'] as $key => $customValue) {
                $cv = new Document\CustomValueText();
                $cv->setName($key);
                $cv->setValue($customValue['value']);
                $newData[] = $cv;
            }
            $data['customValues'] = $newData;
        }
        
        return parent::hydrate($data, $object);
    }
    
}
