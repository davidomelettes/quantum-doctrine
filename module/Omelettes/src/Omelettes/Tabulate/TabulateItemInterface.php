<?php

namespace Omelettes\Tabulate;

interface TabulateItemInterface
{
    public function getTabulateHeadings();
    
    public function getTabulateRowPartial();
    
}