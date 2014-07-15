<?php

namespace Omelettes\Form\Element;

use Zend\Form\Element;

class StaticAnchor extends Element
{
    protected $routeName = null;
    
    protected $routeParams = array();
    
    protected $routeOptions = array();
    
    protected $routeReuseMatchedParams = false;
    
    protected $attributes = array(
        'type' => 'static-anchor',
    );
    
    public function setOptions($options)
    {
        parent::setOptions($options);
        
        if (isset($options['route_name'])) {
            $this->setRouteName($options['route_name']);
        }
        if (isset($options['route_params'])) {
            $this->setRouteParams($options['route_params']);
        }
        if (isset($options['route_options'])) {
            $this->setRouteOptions($options['route_options']);
        }
        if (isset($options['route_reuse_matched_params'])) {
            $this->setRouteReuseMatchedParams($options['route_reuse_matched_params']);
        }
        
        return $this;
    }
    
    public function setRouteName($name)
    {
        $this->routeName = $name;
        return $this;
    }
    
    public function getRouteName()
    {
        return $this->routeName;
    }
    
    public function setRouteParams(array $params = array())
    {
        $this->routeParams = $params;
        return $this;
    }
    
    public function getRouteParams()
    {
        return $this->routeParams;
    }
    
    public function setRouteOptions(array $options = array())
    {
        $this->routeOptions = $options;
        return $this;
    }
    
    public function getRouteOptions()
    {
        return $this->routeOptions;
    }
    
    public function setRouteReuseMatchedParams($reuse = false)
    {
        $this->routeReuseMatchedParams = (boolean)$reuse;
        return $this;
    }
    
    public function getRouteReuseMatchedParams()
    {
        return $this->routeReuseMatchedParams;
    }
    
}
