<?php

namespace OmelettesDoctrine\Filter;

use Zend\Filter\AbstractFilter;

class DateTimeToLocalTime extends AbstractFilter
{
    public function filter($value)
    {
        var_dump($value);
        return $value;
    }
    
}
