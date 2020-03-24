<?php
namespace  common\models;


use Yii;
use yii\base\Model;
use linslin\yii2\curl\Curl;

class tool extends Model
{
    public static function sendMail($address,$title,$content)
    {
        $mail= Yii::$app->mailer->compose();
        $mail->setTo($address);
        $mail->setSubject($title);
        //$mail->setTextBody($content);   //发布纯文字文本
        $mail->setHtmlBody($content);    //发布可以带html标签的文本
        if($mail->send()){
            return true;
        }else {
            return false;
        }
    }

    /**
     *  get curl获取网址结果
     */
    public static function getCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res,true);
    }
    
    /**
     *  post curl获取网址结果
     */
    public static function postCurl($url,$post_data)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res,true);
    }
    
    /**
     *  获取IP
     *  return 数组
     */
    public static function getIp()
    {
        return Yii::$app->getRequest()->getUserIP();
    }
    
    
    /**
     *  单文件上传
     *  @params $thumbnail 数组，是否生成缩略图，包含width，height
     *  return 相对cdn/imatges文件路径
     */
    public static function uploadImage($name, $type, $tmpName, $size, $url)
    {
        if(!in_array($type,yii::$app->params['IMAGE_FILE']['TYPE'])){
            //上传格式不正确
            $reInfo['code'] = -1;
            $reInfo['message'] = "上传格式不正确";
            $reInfo['data'] = "";
            return $reInfo;
        }
    
        if($size > yii::$app->params['IMAGE_FILE']['MAXSIZE'])
        {
            //上传大小不正确
            $reInfo['code'] = -1;
            $reInfo['message'] = "上传大小不正确";
            $reInfo['data'] = "";
            return $reInfo;
        }
    
        $arrImageType = explode("/", $type);
        $image['site'] = Yii::getAlias('@imgcdn').$url;//文件位置
		tool::createFolders($image['site']);
        $image['name'] = date("YmdHis",time()).rand(10000,99999).".".$arrImageType[1];//生成随机文件名称
        $image['url']  = $image['site'].$image['name'];//文件路径
        $image['saveUrl'] = $url.$image['name'];//数据库保存的路径
        
        move_uploaded_file($tmpName,$image['url']);//上传文件
        
        $reInfo['code'] = 1;
        $reInfo['message'] = "";
        $reInfo['data']['url'] = $image['saveUrl'];
        
        //生成缩略图
        $imagename = explode('.', $image['name']);
        $s_imageName = $image['site'].$imagename[0].'_s.'.$arrImageType[1];
        
        self::img_create_small($image['url'], yii::$app->params['IMAGE_FILE_SMALL']['WIDTH'], yii::$app->params['IMAGE_FILE_SMALL']['HEIGHT'], $s_imageName);
        return $reInfo;
    }
    
    
    public static function img_create_small($big_img, $width, $height, $small_img) {//原始大图地址，缩略图宽度，高度，缩略图地址
        $imgage = getimagesize($big_img); //得到原始大图片
        switch ($imgage[2]) { // 图像类型判断
            case 1:
                $im = imagecreatefromgif($big_img);
                break;
            case 2:
                $im = imagecreatefromjpeg($big_img);
                break;
            case 3:
                $im = imagecreatefrompng($big_img);
                break;
        }
        $src_W = $imgage[0]; //获取大图片宽度
        $src_H = $imgage[1]; //获取大图片高度
        $tn = imagecreatetruecolor($width, $height); //创建缩略图
        imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $src_W, $src_H); //复制图像并改变大小
        imagejpeg($tn, $small_img); //输出图像
    }

	//创建目录
    public static function createFolders($dir){
        return is_dir($dir) or (tool::createFolders(dirname($dir)) and mkdir($dir,0777));
    }
    
    /**
     *  发送手机短信
     * @param unknown $PhoneNum 手机号码
     * @param unknown $message 短信消息
     */
    public static function sendPhoneMessage($PhoneNum,$message)
    {
        $url = "http://api.dingdongcloud.com/v1/sms/sendyzm";
    
        $post_data = array('account' => yii::$app->params['dingdongyun']['account'], 'pwd' => yii::$app->params['dingdongyun']['pwd'], 'mobile'=> $PhoneNum, 'content'=> '【驿渡网】'.$message);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    
        $output = curl_exec($ch);
        curl_close($ch);
    
        $reInfo['code'] = 1;
        $reInfo['message'] = "";
        $reInfo['data'] = "";
    
        return $reInfo;
    }
    
    /**
     *  跳转页面
     */
    public static function JumpUrl($url)
    {
        echo " <script   language = 'javascript'type = 'text/javascript' > ";
        echo " window.location.href = '$url' ";
        echo " </script > ";
    }
    
}
