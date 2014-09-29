<?php

namespace OmelettesDoctrine\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class LocalesService implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $timeZones;
    
    /**
     * @var DocumentManager
     */
    protected $documentManager;
    
    public function __construct(DocumentManager $dm)
    {
        $this->documentManager = $dm;
    }
    
    public function getTimeZones()
    {
        if (!$this->timeZones) {
            $timeZoneGroups = array(
                \DateTimeZone::AFRICA,
                \DateTimeZone::AMERICA,
                \DateTimeZone::ASIA,
                \DateTimeZone::ATLANTIC,
                \DateTimeZone::EUROPE,
                \DateTimeZone::INDIAN,
                \DateTimeZone::PACIFIC,
            );
            
            $zones = array();
            foreach ($timeZoneGroups as $group) {
                foreach (\DateTimeZone::listIdentifiers($group) as $tzName) {
                    $zones[$tzName] = str_replace('_', ' ', $tzName);
                }
            }
            $this->timeZones = $zones;
        }
        return $this->timeZones;
    }
    
    public function getCountries()
    {
        $qb = $this->documentManager->createQueryBuilder('OmelettesDoctrine\Document\LocaleCountry');
        $qb->sort('name');
        return $qb->getQuery()->execute();
    }
    
}