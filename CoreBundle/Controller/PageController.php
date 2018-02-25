<?php
namespace Beaver\CoreBundle\Controller;

use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Response\BaseResponse;

/**
 * Class PageController
 *
 * @package Beaver\CoreBundle\Controller
 */
class PageController extends ControllerBase
{
    /**
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function page($slug = 'home')
    {
        /** @var BaseResponse $pageResponse */
        $pageResponse = $this->get('beaver.core.page')->getPage($slug);
        
        if (BaseResponse::FAIL === $pageResponse->isSuccess()) {
			throw $this->createNotFoundException('La página solicitada no existe.');
	    }
	    
	    /** @var \Beaver\CoreBundle\Model\Page\Page $page */
	    $page = $pageResponse->getData();
	    
	    if ('@BeaverBackend' !== $this->Bundle()) {
            if (Statutory::UNPUBLISHED === $page->isPublished()) {
                throw $this->createNotFoundException();
            }
        }
	    
	    return $this->render($page->getLayout()->getPath(), [
	    	'page'   => $page
	    ]);
   }
}
