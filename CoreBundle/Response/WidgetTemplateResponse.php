<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 20:30
 */

namespace Beaver\CoreBundle\Response;

use Beaver\CoreBundle\Model\Configuration\Widget;
use Beaver\CoreBundle\Entity\WidgetTemplate as WidgetEntity;


/**
 * Prepare the response for a entity Widget
 *
 * Class WidgetTemplateResponse
 * @package Beaver\CoreBundle\Response
 */
class WidgetTemplateResponse extends BaseResponse
{
    /**
     * @param WidgetEntity $data
     * @return $this
     */
    public function setData($data)
    {
        if (false === $data instanceof WidgetEntity)
        {
            $this->setError('Expected a Beaver\CoreBundle\Entity\Widget');
            return $this;
        }
    
        $widget = new Widget();
        $widget
            ->setId($data->getId())
            ->setType($data->getType())
            ->setName($data->getName())
            ->setDescription($data->getDescription())
            ->setContentType($data->getContentType())
            ->setView($data->getView())
        ;

        $this->data = $widget;

        return $this;
    }
}