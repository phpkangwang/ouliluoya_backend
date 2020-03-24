<?php

namespace backend\controllers;

use common\models\education\ShapeBase;
use common\models\ErrorCode;
use common\models\MyException;
use common\models\tool;

/**
 * Site controller
 */
class EducationController extends MyController
{

    /**
     *   添加 ShapeBase
     */
    public function actionShapeBaseAdd()
    {
        try {
            if (
                !isset($this->get['firstName']) ||
                !isset($this->get['secondName']) ||
                !isset($this->get['job']) ||
                !isset($this->get['email']) ||
                !isset($this->get['province']) ||
                !isset($this->get['labName']) ||
                !isset($this->get['labPeopleNum']) ||
                !isset($this->get['cdt_num'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            $postData['user_id'] = $this->loginInfo['id'];
            $postData['first_name'] = $this->get['firstName'];
            $postData['second_name'] = $this->get['secondName'];
            $postData['job'] = $this->get['job'];
            $postData['email'] = $this->get['email'];
            $postData['province'] = $this->get['province'];
            $postData['lab_name'] = $this->get['labName'];
            $postData['lab_people_num'] = $this->get['labPeopleNum'];
            $postData['cdt_num'] = $this->get['cdt_num'];
            $model = new ShapeBase();
            $model->add($postData);
            $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }


    /**
     *   分页获取 ShapeBase
     */
    public function actionShapeBasePage()
    {
        try{
            if( !isset( $this->get['pageNo'] ) || !isset( $this->get['pageSize'] ) )
            {
                throw new MyException( ErrorCode::ERROR_PARAM );
            }
            $pageNo   = $this->get['pageNo'];
            $pageSize = $this->get['pageSize'];
            $where = "  1";
            $model = new ShapeBase();
            $data = $model->page($pageNo, $pageSize, $where);
            $account = $model->pageNum($where);
            $page = array(
                'account' => $account,
                'maxPage' => ceil($account/$pageSize),
                'nowPage' => $pageNo
            );
            if( $page['maxPage'] != 0 && $page['maxPage'] < $page['nowPage'] )
            {
                throw new MyException( ErrorCode::ERROR_PAGE_UNKNOWN );
            }
            $this->setData($data);
            $this->setPage($page);
            $this->sendJson();
        }catch (MyException $e){
            echo $e->toJson($e->getMessage());
        }
    }


}
