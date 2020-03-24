<?php
namespace frontend\controllers;

use frontend\models\Answer;
use frontend\models\Paper;
use frontend\models\Score;
use frontend\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\XiaoHua;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $paperNum = Yii::$app->request->get('paperNum');
        $paperNum = $paperNum == "" ? 1 : $paperNum;
        return $this->render('index',array('paperNum'=>$paperNum));
    }

    /**
     *   登录
     */
	public function actionLogin()
    {
        $name = Yii::$app->request->post('name');
        $paperNum = Yii::$app->request->post('paperNum');
        $paperNum = $paperNum == "" ? 1 : $paperNum;
        if(empty($name)){
            return $this->render('index',array('paperNum'=>$paperNum));
        }else{
            return $this->render('test',array('name'=>$name, 'paperNum'=>$paperNum));
        }
//        if( empty($name) ){
//            $name = $_SESSION['user']['name'];
//            //Yii::$app->getSession()->setFlash('error', '请输入正确的姓名');
//        }
//
//        $obj = new User();
//        $UserObj = $obj->findByName($name);
//        if( empty($UserObj) ){
//            $data = array(
//                'name' => $name,
//                'created_time' => time(),
//            );
//            $UserObj = $obj->add($data);
//        }
        //登录
//        $_SESSION['user']['id'] = $UserObj->id;
//        $_SESSION['user']['name'] = $UserObj->name;

    }

    //获取下一题
    public function actionGetNextTitle()
    {
        $paperNum = Yii::$app->request->get('paperNum');
        $sort = Yii::$app->request->get('sort');
        $obj = new Paper();
        $PaperObj = $obj->findNextTitle($paperNum,$sort);
        $data = [
            'code' => 1,
            'message' => "",
            'data' => $PaperObj,
        ];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        echo json_encode($data);
        return;
    }

    public function actionSubmitAnswer()
    {
        $name     = Yii::$app->request->post('name');
        $paperNum = Yii::$app->request->post('paperNum');
        $sort     = Yii::$app->request->post('sort');
        $answers  = Yii::$app->request->post('answer');
        $answers  = explode(",",$answers);
        $rsScore = 0;
        $obj = new Paper();
        $allAnswerList = $obj->getAllAnswer($paperNum,$sort);
        foreach ($allAnswerList as $val){
            foreach ($answers as $key=>$answer){
                if($val['sort'] == ($key+1) && $val['answer'] == $answer){
                    $rsScore += $val['score'];
                }
            }
        }

        //记录得分结果到数据库
        $AnswerObj = new Answer();
        $AnswerObj->name    = $name;
        $AnswerObj->paper_num= $paperNum;
        $AnswerObj->answer = json_encode($answers);
        $AnswerObj->score  = $rsScore;
        $AnswerObj->created_time = time();
        $AnswerObj->save();

        return $this->render('result',array('rsScore'=>$rsScore, 'paperNum'=>$paperNum));
    }

    public function actionRanking(){
        $paperNum = Yii::$app->request->get('paperNum');
	    $obj = new Answer();
        $data = $obj->getRanking($paperNum);
        return $this->render('ranking',array('data'=>$data, 'paperNum'=>$paperNum));
    }

    public function actionRankingpc(){
        $paperNum = Yii::$app->request->get('paperNum');
        $obj = new Answer();
        $data = $obj->getRanking($paperNum);
        return $this->render('ranking_pc',array('data'=>$data, 'paperNum'=>$paperNum));
    }
}
