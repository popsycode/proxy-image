<?php
/**
 * Created by PhpStorm.
 * User: POPsy
 * Date: 28.07.2018
 * Time: 0:47
 */


if ( ! function_exists('proxy_image'))
{
    /**
     * @param  mixed $value
     * @param null $width
     * @return string
     */
    function proxy_image($value, $width = null)
    {
        return ProxyImage::urlLocal($value, $width);
    }
}

