<?php

namespace OmelettesDoctrine\View\Helper;

use OmelettesDoctrine\Document as OmDoc;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\Permissions\Acl;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclAllows extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    /**
     * Returns the application service manager
     *
     * @return ServiceLocatorInterface
     */
    public function getApplicationServiceLocator()
    {
        // View helpers implementing ServiceLocatorAwareInterface are given Zend\View\HelperPluginManager!
        return $this->getServiceLocator()->getServiceLocator();
    }
    
    /**
     * Returns the ACL service used by the application
     *
     * @return Acl\Acl
     */
    public function getAcl()
    {
        return $this->getApplicationServiceLocator()->get('OmelettesDoctrine\Service\AclService');
    }
    
    /**
     * Returns the acl role of the current authentication identity
     * 
     * @return string
     */
    public function getRole()
    {
        $auth = $this->getApplicationServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            if ($identity instanceof OmDoc\User) {
                return $identity->getAclRole();
            }
        }
        return 'guest';
    }
    
    public function __invoke($resource, $privilege = null)
    {
        $acl = $this->getAcl();
        $role = $this->getRole();
        
        return $acl->isAllowed($role, $resource, $privilege);
    }
    
}
