<?php
/**
 * Created by PhpStorm.
 * User: POPsy
 * Date: 27.07.2018
 * Time: 23:54
 */

namespace POPsy\ProxyImage;

use Illuminate\Foundation\Application;
use Intervention\Image\ImageManagerStatic as Image;

class ProxyImage
{


    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $folder;

    /**
     * ProxyImage constructor.
     * @param Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->folder = config('proxy-image.public_folder');
    }

    /**
     * @param $value
     * @param null $width
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function urlLocal($value, $width=null){
        $image = $this->get($value, $width);
        $path = str_replace(public_path('\\'), '' , $image->basePath());
        return url($path);
    }


    /**
     * @param $value
     * @param null $width
     * @return \Intervention\Image\Image
     */
    public function get($value, $width=null){
        $paramstrs = '';
        if($width) $paramstrs .= "w{$width}";
        $name = md5($paramstrs.$value).".png";
        $name_original = md5($value).".png";
        if(!\File::exists(public_path($this->folder.'transformed/'.$name))){
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                if(!\File::exists(public_path($this->folder.$name_original))) {
                    $image = Image::make($value)->save(public_path($this->folder . $name_original));
                }else{
                    $image = Image::make(public_path($this->folder . $name_original));
                }
            }else{
                $image = Image::make(public_path($value));
            }
            if($width) $image->widen($width);
            $image->save(public_path($this->folder.'transformed/'.$name));
        }
        if(!isset($image)) $image = Image::make(public_path($this->folder.'transformed/'.$name));
        return $image;
    }




}