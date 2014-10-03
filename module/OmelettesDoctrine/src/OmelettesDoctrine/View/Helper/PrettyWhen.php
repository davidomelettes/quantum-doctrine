<?php

namespace OmelettesDoctrine\View\Helper;

use OmelettesDoctrine\Document\When;
use Zend\Form\View\Helper\AbstractHelper;

class PrettyWhen extends AbstractHelper
{
    public function __invoke(When $when)
    {
        if (!$when->getDate()) {
            return 'Never';
        }
        if ($when->getTime()) {
            // Use PrettyTime
            $prettyTime = $this->getView()->plugin('prettyTime');
            return $prettyTime($when->getDate());
        }
        
        $now = time();
        $then = $when->getDate()->format('Y-m-d');
        
        // Today
        if (date('Y-m-d', $now) === $then) {
            return 'Today';
        }
        
        // Yesterday
        if (date('Y-m-d', strtotime('-1 day')) === $then) {
            return 'Yesterday';
        }
        
        // Tormorrow
        if (date('Y-m-d', strtotime('+1 day')) === $then) {
            return 'Tomorrow';
        }
        
        // Specific day
        return date('D, d F', $when->getDate()->format('U'));
    }
    
}
