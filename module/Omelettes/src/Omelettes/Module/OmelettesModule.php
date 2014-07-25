<?php

namespace Omelettes\Module;

use Zend\Http\Header\SetCookie;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface as Response;

class OmelettesModule
{
    /**
     * If an event returns a response, the event manger is
     * short-ciruted and prevented from dispatching
     * (if the event occurs before dispatch)
     * 
     * @param MvcEvent $ev
     * @param string $routeName
     * @return Response
     */
    protected function redirectToRoute(MvcEvent $ev, $routeName = 'login')
    {
        $routeUrl = $ev->getRouter()->assemble(array(), array('name' => $routeName));
        $response = $ev->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $ev->getRequest()->getBaseUrl() . $routeUrl);
        $response->setStatusCode('302');
        return $response;
    }
    
    /**
     * Adds a set-cookie header to the HTTP response
     * @param Response $response
     * @param string $name
     * @param string $value
     * @param string $expires
     * @param string $path
     * @param string $domain
     * @param string $secure
     * @param string $httponly
     * @param string $maxAge
     * @param string $version
     */
    protected function setCookie(
        Response $response,
        $name = null,
        $value = null,
        $expires = null,
        $path = null,
        $domain = null,
        $secure = false,
        $httponly = false,
        $maxAge = null,
        $version = null
    )
    {
        $setCookieHeader = new SetCookie(
            $name,
            $value,
            $expires,
            $path,
            $domain,
            $secure,
            $httponly,
            $maxAge,
            $version
        );
        $response->getHeaders()->addHeader($setCookieHeader);
    }
    
}