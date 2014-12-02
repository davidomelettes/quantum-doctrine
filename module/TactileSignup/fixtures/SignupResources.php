<?php

namespace TactileSignupFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OmelettesDoctrine\Document as OmDoc;
use Tactile\Document as Document;
use Tactile\Service as Service;

class SignupResources implements FixtureInterface
{
    /**
     * @var Service\ResourcesService
     */
    protected $service;
    
    public function __construct(Service\ResourcesService $service)
    {
        $this->service = $service;
    }
    
    public function load(ObjectManager $manager)
    {
        $resourceData = array(
            'contacts'      => array(
                'singular'  => 'Contact',
                'plural'    => 'Contacts',
            ),
            'opportunities' => array(
                'singular'  => 'Opportunity',
                'plural'    => 'Opportunities',
            ),
            'activities'    => array(
                'singular'  => 'Activity',
                'plural'    => 'Activities',
            ),
        );
        
        foreach ($resourceData as $slug => $data) {
            $resource = new Document\Resource();
            $resource->setSlug($slug)
                     ->setData($data);
            $this->service->save($resource);
        }
        
        $this->service->commit();
    }
    
}