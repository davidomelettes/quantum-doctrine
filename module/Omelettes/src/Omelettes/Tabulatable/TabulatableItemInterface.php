<?php

namespace Omelettes\Tabulatable;

interface TabulatableItemInterface
{
    public function getTableHeadings();
    
    public function getTableRowPartial();
    
}