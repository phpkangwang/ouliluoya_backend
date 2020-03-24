<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username

 */
class BaseModel extends ActiveRecord
{

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

    public function findBase($id){
        return self::find()->where('id = :id', array(':id' =>$id))->asArray()->one();
    }

}
