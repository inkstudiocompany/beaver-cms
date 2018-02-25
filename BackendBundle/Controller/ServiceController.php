<?php
namespace Beaver\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class ServiceController extends ControllerBase
{
    /**
     *
     */
    public function testAction(Request $request)
    {
    	dump($this->get('beaver_core.block')->blocks());
    	die();
     

    }
}