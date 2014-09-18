<?php

namespace OmelettesDoctrine\Stdlib\Hydrator;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Stdlib\Hydrator\AbstractHydrator;

class UberHydrator extends DoctrineHydrator
{
    public function extract($object)
    {
        $data = parent::extract($object);
        return $data;
    }
    
    public function hydrate(array $data, $object)
    {
        $this->prepare($object);
        
        $metadata = $this->metadata;
        foreach ($data as $field => $value) {
            $value  = $this->handleTypeConversions($value, $metadata->getTypeOfField($field));
            $setter = 'set' . ucfirst($field);
            
            if ($metadata->hasAssociation($field)) {
                $target = $metadata->getAssociationTargetClass($field);
                
                if ($metadata->isSingleValuedEmbed($field)) {
                    // EmbedOne
                    if (! method_exists($object, $setter)) {
                        continue;
                    }
                    
                    $value = $this->toEmbedOne($target, $this->hydrateValue($field, $value, $data));
                    
                    if (null === $value
                    && !current($metadata->getReflectionClass()->getMethod($setter)->getParameters())->allowsNull()
                    ) {
                        continue;
                    }
                    
                    $object->$setter($value);
                } elseif ($metadata->isSingleValuedReference($field)){
                    // RefereceOne
                    if (! method_exists($object, $setter)) {
                        continue;
                    }
                    
                    $value = $this->toOne($target, $this->hydrateValue($field, $value, $data));
                    
                    if (null === $value
                        && !current($metadata->getReflectionClass()->getMethod($setter)->getParameters())->allowsNull()
                    ) {
                        continue;
                    }
            
                    $object->$setter($value);
                } elseif ($metadata->isCollectionValuedEmbed($field)) {
                    // EmbedMany
                    $this->toEmbedMany($object, $field, $target, $value);
                } elseif ($metadata->isCollectionValuedReference($field)) {
                    // ReferenceMany
                    $this->toMany($object, $field, $target, $value);
                }
            } else {
                if (! method_exists($object, $setter)) {
                    continue;
                }
            
                $object->$setter($this->hydrateValue($field, $value, $data));
            }
        }
        
        return $object;
    }
    
    protected function toEmbedOne($target, $value)
    {
        $object = new $target;
        
        if (is_array($value)) {
            return $this->hydrate($value, $object);
        } elseif (is_object($value)) {
            // ???
            return $value;
        } else {
            throw new \Exception('what');
        }
    }
    
    protected function toEmbedMany($object, $collectionName, $target, $values)
    {
        throw new \Exception('lol not ready!');
    }
    
}
