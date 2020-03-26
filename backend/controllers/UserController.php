<?php
namespace backend\controllers;

use common\models\AdminUser;
use common\models\ErrorCode;
use common\models\Log;
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
                //添加日志
                $LogModel = new Log();
                $LogModel->add(array(
                    'account_id' => $AdminUserObj->id,
                    'name' => $AdminUserObj->name,
                    'type' => $LogModel->LOG_TYPE_USER,
                    'content' => "用户登陆",
                ));
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

    /**
     *   添加后太账户
     */
    public function actionAdd()
    {
        try {
            if (
                !isset($this->post['account']) ||
                !isset($this->post['password']) ||
                !isset($this->post['sex']) ||
                !isset($this->post['age']) ||
                !isset($this->post['name']) ||
                !isset($this->post['phone']) ||
                !isset($this->post['email']) ||
                !isset($this->post['qq'])
            ) {
                throw new MyException(ErrorCode::ERROR_PARAM);
            }
                $account = $this->post['account'];
                $AdminUserModel = new AdminUser();
                $AdminUserObj = $AdminUserModel->findByAccount($account);
                if( !empty($AdminUserObj) ){
                    throw new MyException( ErrorCode::ERROR_USER_EXIXTE );
                }
                $AdminUserModel->add($this->post);
                $this->sendJson();
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }
    }
}
