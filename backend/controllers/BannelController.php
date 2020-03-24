<?php
namespace backend\controllers;

use common\models\AdminUser;
use common\models\Bannel;
use common\models\ErrorCode;
use common\models\MyException;
use common\models\tool;
use common\models\User;

/**
 * Site controller
 */
class BannelController extends MyController
{
    //分页获取数据
    public function actionPage()
    {
        try {
            if (
                !isset($this->get['pageNo']) ||
                !isset($this->get['pageSize']) ||
                !isset($this->get['bannelType'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            $BannelModel = new Bannel();
            $data = $BannelModel->tablePage($this->get);
            $count = $BannelModel->tableCount($this->get);
            $this->setData($data);
            $this->setPage(array(
                'pageNo' => $this->get['pageNo'],
                'maxPage' => ceil($count/$this->get['pageSize'] ),
                'count' => $count,
            ));
            $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }

    /**
     *    改变bannel显示状态
     */
    public function actionUpdateStatus()
    {
        try {
            if (
                !isset($this->get['id'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            $id = $this->get['id'];
            $BannelModel = new Bannel();
            $BannelObj = $BannelModel->findOne($id);
            if(empty($BannelObj)){
                throw new MyException(ErrorCode::ERROR_PARAM);
            }

            if($BannelObj->status == 1){
                $postData['status'] = 2;
            }else{
                $postData['status'] = 1;
            }
            $BannelObj->add($postData);
            $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }

    /**
     *    bannel 排序 上移 下移
     */
    public function actionExchangePosition()
    {
        try {
            if (
                !isset($this->get['id']) ||
                !isset($this->get['direction'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            $id = $this->get['id'];
            $direction = $this->get['direction'];
            $BannelModel = new Bannel();
            $BannelObj = $BannelModel->findOne($id);
            if(empty($BannelObj)){
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            //交换两个排序
            $BannelObj->ExchangeSort($BannelObj->sort, $direction);
            $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }

    /**
     *   批量删除 数据
     */
    public function actionDel()
    {
        try {
            if (
                !isset($this->get['ids'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            $ids = $this->get['ids'];
            $idArr = explode(",",$ids);
            Bannel::deleteAll(['id'=>$idArr]);
            $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }
}
