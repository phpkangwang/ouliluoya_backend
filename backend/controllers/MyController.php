<?php
namespace backend\controllers;

use common\models\AdminUser;
use common\models\ErrorCode;
use common\models\MyException;
use common\models\User;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class MyController extends Controller
{
    public $post;
    public $get;
    /**
     * @var array 存放用户登录信息
     */
    public $loginInfo = array();
    /**
     * @var 返回的错误码 默认返回200
     */
    private $code=200;

    /**
     * @var 数据
     */
    private $data="";

    /**
     * @var 分页
     */
    private $page="";

    /**
     * 免除角色权益限制访问的功能
     * @var array
     */
    private $NoAccessLimit = [
        'user/login',
        'bannel/upload-file',
        'bannel/upload-file1',
        'bannel/page',
        'bannel/get-louceng-pingpai',
    ];

    public function __construct($id,  $module,  $config = [])
    {
        $this->post = Yii::$app->request->post();
        $this->get = Yii::$app->request->get();
        //获取token信息
        $this->checkToken();
        parent::__construct($id, $module, $config);
    }

    public function checkToken()
    {
        try{
            //部分地址可以不用token
            $route = Yii::$app->requestedRoute;
            if( in_array($route, $this->NoAccessLimit))
            {
                return true;
            }

            $token = isset( $this->get['token'] ) ? $this->get['token'] : "";
            $tokenArr = json_decode( base64_decode($token),true );
            $UserModel = new AdminUser();
            if( !isset($tokenArr['id']) ){
                throw new MyException(ErrorCode::ERROR_TOKEN);
            }
            $obj = $UserModel->findBase($tokenArr['id']);
            //判断当前的token和数据库里面的token是否一致
            if( empty($obj) || $token != $obj['token']  ){
                throw new MyException(ErrorCode::ERROR_TOKEN);
            }
            $this->loginInfo = $obj;
        } catch (MyException $e) {
            echo $e->toJson($e->getMessage());
        }

    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function sendJson()
    {
        header('content-type:application/json');

        echo json_encode(
            array(
                'code' => $this->code,
                'data' => $this->data,
                'page' => $this->page
            )
        );
        die;
    }
}
