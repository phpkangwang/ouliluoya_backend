<?php
namespace backend\controllers;

use common\models\AdminUser;
use common\models\ErrorCode;
use common\models\MyException;
use common\models\User;

/**
 * Site controller
 */
class UserController extends MyController
{
    public function actionLogin()
    {
        try {
            if (
                !isset($this->post['account']) ||
                !isset($this->post['password'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
            $account = $this->post['account'];
            $password = $this->post['password'];
            $AdminUserModel = new AdminUser();
            $AdminUserObj = $AdminUserModel->findByAccount($account);
            //判断密码是否正确
            if( !empty($AdminUserObj) && $AdminUserObj->password == $password){
                $token = $AdminUserObj->updateToken();
                $this->setData(
                    array(
                        'token'=>$token,
                    )
                );
                $this->sendJson();
            }else{
                throw new MyException( ErrorCode::ERROR_USER_PASSWORD );
            }
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }

    /**
     *   获取用户基本信息
     */
    public function actionAdminUserInfo()
    {
        $this->setData($this->loginInfo);
        $this->sendJson();
    }
}
