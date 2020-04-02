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
    private $BannelFilePath = "image";

    public function actionAdd()
    {
        try {
            if (
                !isset($this->get['bannel_type']) ||
                !isset($this->get['image_url_str']) ||
                !isset($this->get['image_type']) ||
                !isset($this->get['title']) ||
                !isset($this->get['content'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }

            $imageUrlArr = explode(",",$this->get['image_url_str']);
            foreach ($imageUrlArr as $imageUrl){
                $BannelModel = new Bannel();
                if( $this->get['image_type'] == 1){
                    $imageInfo = getimagesize($this->BannelFilePath."/".$imageUrl);
                    $image_width = isset($imageInfo) ? $imageInfo[0] : 0;
                    $image_height = isset($imageInfo) ? $imageInfo[1] : 0;
                }else{
                    $image_width = 0;
                    $image_height = 0;
                }

                //获取最大的排序
                $sort = $BannelModel->getMaxSort() + 1;
                $postData = array(
                    'bannel_type' => $this->get['bannel_type'],
                    'image_url' => $imageUrl,
                    'image_width' => $image_width,
                    'image_height' => $image_height,
                    'image_type' => $this->get['image_type'],
                    'title' => $this->get['title'],
                    'content' => $this->get['content'],
                    'append' => isset( $this->get['append'] ) ? $this->get['append'] : "",
                    'sort' => $sort,
                );
                $BannelModel->add($postData);
            }
            $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }

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
                'maxPage' => ceil($count / $this->get['pageSize']),
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
            if (empty($BannelObj)) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }

            if ($BannelObj->status == 1) {
                $postData['status'] = 2;
            } else {
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
            if (empty($BannelObj)) {
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
            $idArr = explode(",", $ids);
            Bannel::deleteAll(['id' => $idArr]);
            $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }

    /**
     *   上传文件
     */
    public function actionUploadFile()
    {
        $imgname = $_FILES['file']['name'];
        $imgnameArr = explode(".", $imgname);
        $imgname = date("Y_m_d_H_i_s", time()) . "_" . rand(10000, 99999) . "." . end($imgnameArr);
        $tmp = $_FILES['file']['tmp_name'];
        if (move_uploaded_file($tmp, $this->BannelFilePath ."/". $imgname)) {
            $this->setData($imgname);
        } else {
        }
        $this->sendJson();
    }

    /**
     *   每个类型bannel的数量
     */
    public function actionBannelTypeNum()
    {
        $BannelModel = new Bannel();
        $AdminUserModel = new AdminUser();
        $data['bannel'] = $BannelModel->bannelTypeNum();
        $data['admin']  = $AdminUserModel::find()->count();
        $this->setData($data);
        $this->sendJson();
    }

    /**
     *   获取楼层的所有品牌
     */
    public function actionGetLoucengPingpai()
    {
        try {
            if (
            !isset($this->get['title'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            $model = new Bannel();
            $data = $model::find()->where('bannel_type = 4 and title = :title',array('title'=>$this->get['title']))->orderBy('sort asc')->asArray()->all();
            $this->setData($data);
            $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }
}
