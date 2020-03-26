<?php
namespace common\models;

use Yii;
use yii\base\Exception;

/**
 * User model
 *
 * @property integer $id
 * @property string $username

 */
class Ip extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ip}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    public function addIp($ip, $address){
        $obj = self::findOne($ip);
        //ip地址保存7天
        if( !empty($obj)  ||  time() - strtotime($obj['create_time']) > 7*24*3600 ){
            $this->ip = $ip;
            $this->ip_address = $address;
            $this->create_time = date("Y-m-d H:i:s", time());
            $this->save();
        }
        return true;
    }

    public function getIpAddress($ip){
        $obj = self::findOne($ip);
        if(!empty($obj)){
            return $obj->ip_address;
        }else{
            return "";
        }
    }
}
