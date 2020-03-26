<?php

namespace backend\controllers;

use common\models\ErrorCode;
use common\models\Log;
use common\models\MyException;

/**
 * Site controller
 */
class LogController extends MyController
{

    //分页获取数据
    public function actionPage()
    {
        try {
            if (
                !isset($this->get['pageNo']) ||
                !isset($this->get['pageSize'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            $LogModel = new Log();
            $data = $LogModel->tablePage($this->get);
            $count = $LogModel->tableCount($this->get);
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

}
