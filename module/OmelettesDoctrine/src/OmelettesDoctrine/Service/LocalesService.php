<?php

namespace OmelettesDoctrine\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class LocalesService implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $timeZones;
    
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
}