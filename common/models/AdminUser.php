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
class AdminUser extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
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
            [[ 'account','password'], 'required'],
        ];
    }

    public function add($data){
        foreach ($data as $key=>$val){
            $this->$key = $val;
        }
        if( $this->save()){
            return $this;
        }else{
            Yii::$app->getSession()->setFlash('error', '系统错误');
            return false;
        }
    }

    public function findByAccount($account){
        return self::find()->where('account = :account', array(':account' =>$account))->one();
    }

    /**
     *   初始化一下用户的token
     */
    public function updateToken()
    {
        $token = base64_encode(
            json_encode(array(
                'id' => $this->id,
                'time' => time()
            ))
        );
        $this->add(['token'=>$token,'update_time'=>date("Y-m-d H:i:s",time())]);
        return $token;
    }

    public function findBase($id){
        return self::find()->select('id,account,token,name,ip,sex,phone,email')->where('id = :id', array(':id' =>$id))->asArray()->one();
    }
}
