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
        $path = str_replace([public_path(), '\\'], '' , $image->basePath());
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
            if ($this->validate_url($value)) {
                if(!\File::exists(public_path($this->folder.$name_original))) {
                    try{
                        $image = Image::make(file_get_contents($value))->save(public_path($this->folder . $name_original));
                    }catch (\Exception $e){
                        $image = Image::make(public_path($this->folder . "default.png"));
                    }
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


    private function validate_url($url) {
        $path = parse_url($url, PHP_URL_PATH);
        $encoded_path = array_map('urlencode', explode('/', $path));
        $url = str_replace($path, implode('/', $encoded_path), $url);

        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }


}