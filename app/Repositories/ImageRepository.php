<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/11
 * Time: 下午5:15
 */

namespace App\Repositories;


use App\Models\Image;

class ImageRepository {

    private $src;
    private $imageinfo;
    private $image;
    private  $percent = 0.1;

    /**
    打开图片
     */
    public function openImage(){

        list($width, $height, $type, $attr) = getimagesize($this->src);
        $this->setPercent(414/$width);
        $this->imageinfo = array(

            'width'=>$width,
            'height'=>$height,
            'type'=>image_type_to_extension($type,false),
            'attr'=>$attr
        );
        $fun = "imagecreatefrom".$this->imageinfo['type'];
        $this->image = $fun($this->src);
    }
    /**
    操作图片
     */
    public function thumpImage(){

        $new_width = $this->imageinfo['width'] * $this->percent;
        $new_height = $this->imageinfo['height'] * $this->percent;
        $image_thump = imagecreatetruecolor($new_width,$new_height);
        //将原图复制带图片载体上面，并且按照一定比例压缩,极大的保持了清晰度
        imagecopyresampled($image_thump,$this->image,0,0,0,0,$new_width,$new_height,$this->imageinfo['width'],$this->imageinfo['height']);
        //imagedestroy($this->image);
        $this->image =   $image_thump;
    }
    /**
    输出图片
     */
    public function showImage(){

        header('Content-Type: image/'.$this->imageinfo['type']);
        $funcs = "image".$this->imageinfo['type'];
        $funcs($this->image);

    }
    /**
    保存图片到硬盘
     */
    public function saveImage($pathName){

        $funcs = "image".$this->imageinfo['type'];
        $funcs($this->image, $pathName);
        //$funcs($this->image, $pathName . $this->imageinfo['type']);

    }
    /**
    销毁图片
     */
    public function __destruct(){

        imagedestroy($this->image);
    }

    /**
     * 删除图片
     * @param $id
     * @return int
     */
    public function destroy($id) {

        return Image::destroy($id);
    }


    public function setSrc($src) {
        $this->src = $src;
    }

    public function getSrc() {
        return $this->src;
    }

    public function setPercent($percent) {
        $this->percent = $percent;
    }

    public function getPercent() {
        return $this->percent;
    }
}