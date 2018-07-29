<?php
/**
 * Created by PhpStorm.
 * User: POPsy
 * Date: 29.07.2018
 * Time: 7:10
 */

namespace POPsy\ProxyImage\Controllers;

use App\Http\Controllers\Controller;


class ProxyImageController extends Controller
{
    public function get(){
        $imagepath = request('url', false);
        return \ProxyImage::get($imagepath, request('w'))->response();
    }
}