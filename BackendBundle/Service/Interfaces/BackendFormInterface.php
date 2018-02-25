<?php
namespace Beaver\BackendBundle\Service\Interfaces;

interface BackendFormInterface
{
    /**
     * Return the ID service that it'll process the form.
     *
     * @return string
     */
    public function processor();
}