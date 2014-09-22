<?php

namespace OmelettesDoctrine\Stdlib\Hydrator;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Stdlib\Hydrator\AbstractHydrator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class UberHydrator extends DoctrineHydrator implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
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
    
    /**
     * Handle various type conversions that should be supported natively by Doctrine (like DateTime)
     *
     * @param  mixed  $value
     * @param  string $typeOfField
     * @return DateTime
     */
    protected function handleTypeConversions($value, $typeOfField)
    {
        switch ($typeOfField) {
            case 'datetimetz':
            case 'datetime':
            case 'time':
            case 'date':
                if ('' === $value) {
                    return null;
                }
                $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $tz = $auth->hasIdentity() ? $auth->getIdentity()->getPrefs()->getTz() : 'Europe/London';
    
                $dateTime = new \DateTime();
                try {
                    $dateTime->setTimezone(new \DateTimeZone($tz));
                } catch (\Exception $e) {
                    // Invalid timezone specified
                }
                if (is_int($value)) {
                    $dateTime->setTimestamp($value);
                    $value = $dateTime;
                } elseif (is_string($value)) {
                    $value = $dateTime->modify($value);
                }
    
                break;
            default:
        }
    
        return $value;
    }
    
}
