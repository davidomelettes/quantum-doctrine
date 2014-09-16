<?php

namespace OmelettesDoctrine\View\Helper;

use OmelettesDoctrine\Document as OmDoc;
use Zend\Form\View\Helper\AbstractHelper;

class PrettyUser extends AbstractHelper
{
    public function __invoke(OmDoc\User $user)
    {
        $urlHelper = $this->getView()->plugin('url');
        return sprintf(
            '<a href="%s">%s</a>',
            $urlHelper('users', array('action' => 'view', 'id' => $user->getId())),
            $user->getFullName()
        );
    }
    
}
