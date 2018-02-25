<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 19:56
 */

namespace Beaver\CoreBundle\Service;

use Beaver\BackendBundle\BackendBundle;
use Beaver\CoreBundle\BeaverCoreBundle;
use Beaver\CoreBundle\CoreBundle;
use Symfony\Component\Routing\RequestContext;

/**
 * Class PageService
 * @package Beaver\CoreBundle\Service
 *
 * Servicio para resolver el contexto en el que se ejecuta la aplicación.
 */
class ContextService
{
    /** @var RequestContext $em */
    protected $requestContext;
    
    public function __construct(
        RequestContext $requestContext
    ) {
        $this->requestContext = $requestContext;
    }
    
    /**
     * @return String
     */
    public function getBundle()
    {
        $bundle = CoreBundle::BUNDLE;
        if (stristr($this->requestContext->getPathInfo(), 'backend')) {
            $bundle = BackendBundle::BUNDLE;
        }
        
        return $bundle;
    }
}
