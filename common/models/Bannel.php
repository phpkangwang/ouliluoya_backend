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
class Bannel extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bannel}}';
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

    /**
     * 分页
     * @return array
     */
    public function tablePage($postData)
    {
        $pageNo   = $postData['pageNo'] < 1 ? 1 : $postData['pageNo'];
        $pageSize = $postData['pageSize'] < 1 || $postData['pageSize'] > 100 ? 8 : $postData['pageSize'];//默认一页8条数据
        $limit    = $pageSize;
        $offset   = ($pageNo-1)*$pageSize;
        $where = " 1";
        if( isset($postData['bannelType'])){
            $where .= " and bannel_type = '{$postData['bannelType']}'";
        }
        return self::find()->where($where)->offset($offset)->limit($limit)->orderBy('sort asc')->asArray()->all();
    }

    /**
     *  获取最大条数
     */
    public function tableCount($postData)
    {
        $where = " 1";
        if( isset($postData['bannelType'])){
            $where .= " and bannel_type = '{$postData['bannelType']}'";
        }
        return self::find()->where($where)->count();
    }

    /**
     * @param $sort 当前排序和前一个或者后一个交换位置
     * @param $direction 1：前一套数据  2：后一条数据
     */
    public function ExchangeSort($sort, $direction)
    {
        if( $direction == 1){
            //向前交换位置
            $exchangeObj = self::find()->where('sort < :sort',array(':sort'=>$sort))->orderBy('sort desc')->one();
        }else{
            //向后交换位置
            $exchangeObj = self::find()->where('sort > :sort',array(':sort'=>$sort))->orderBy('sort asc')->one();
        }
        if( !empty($exchangeObj)){
            $this->sort = $exchangeObj->sort;
            $exchangeObj->sort = $sort;
            $this->save();
            $exchangeObj->save();
        }
        return true;
    }

    /**
     *  获取最大的排序
     * @return mixed
     */
    public function getMaxSort()
    {
        $obj = self::find()->orderBy('sort desc')->asArray()->one();
        if(empty($obj)){
            return 0;
        }else{
            return $obj['sort'];
        }
    }

    /**
     *   每个类型bannel的数量
     */
    public function bannelTypeNum()
    {
        $rs = array();
        $data = self::find()->select('bannel_type,count(*) as num')->groupBy('bannel_type')->asArray()->all();
        foreach ($data as $key=>$val){
            $rs[$val['bannel_type']] = $val['num'];
        }
        return $rs;
    }
}
