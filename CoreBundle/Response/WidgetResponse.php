<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 20:30
 */

namespace Beaver\CoreBundle\Response;

use Beaver\CoreBundle\Entity\Widget;


/**
 * Prepare the response for a entity Page
 *
 * Class WidgetResponse
 * @package Beaver\CoreBundle\Response
 */
class WidgetResponse extends BaseResponse
{
    /**
     * @param Widget $data
     * @return $this
     */
    public function setData($data)
    {
        if (false === $data instanceof Widget)
        {
            $this->setError('Expected a Beaver\CoreBundle\Entity\Widget');
            return $this;
        }
    
        $widget = new \Beaver\CoreBundle\Model\Page\Widget();
        $widget
            ->setId($data->getId())
            ->setSlot($data->getSlot())
            ->setWidget($data->getWidget())
        ;

        $this->data = $widget;

        return $this;
    }
}