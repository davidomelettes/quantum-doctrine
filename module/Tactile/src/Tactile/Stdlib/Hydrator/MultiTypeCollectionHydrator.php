<?php

namespace Tactile\Stdlib\Hydrator;

use OmelettesDoctrine\Stdlib\Hydrator\UberHydrator;

class MultiTypeCollectionHydrator extends UberHydrator
{
    public function extract($object)
    {
        $data = parent::extract($object);
        $data['type'] = $object->getType();
        return $data;
    }
    
}
