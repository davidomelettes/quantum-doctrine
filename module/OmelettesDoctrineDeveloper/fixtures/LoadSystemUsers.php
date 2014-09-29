<?php

namespace OmelettesDoctrineDeveloperFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OmelettesDoctrine\Document as OmDoc;

class LoadSystemUsers implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $now = new \DateTime();
        
        $system = new OmDoc\User();
        $system->setData(array(
            'id'       => 'system',
            'fullName' => 'The Robot',
            'email'    => 'system',
            'aclRole'  => 'system',
            'created'  => $now,
            'updated'  => $now,
        ));
        $manager->persist($system);
        
        $console = new OmDoc\User();
        $console->setData(array(
            'id'       => 'console',
            'fullName' => 'Superuser Console',
            'email'    => 'console',
            'aclRole'  => 'system',
            'created'  => $now,
            'updated'  => $now,
        ));
        $manager->persist($console);
        
        $manager->flush();
    }
    
}