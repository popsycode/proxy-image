<?php
/**
 * Created by PhpStorm.
 * User: POPsy
 * Date: 28.07.2018
 * Time: 0:37
 */

namespace POPsy\ProxyImage;


use Illuminate\Support\Facades\Facade;

class ProxyImageFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'proxy-image';
    }
}