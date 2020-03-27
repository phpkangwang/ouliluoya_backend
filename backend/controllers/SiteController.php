<?php
namespace backend\controllers;

use common\models\GlobleConfig;
use common\models\tool;
use Yii;
use common\models\User;
use yii\base\Exception;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
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
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSendMail()
    {
        $mail= Yii::$app->mailer->compose();
        $mail->setTo('474021880@qq.com');
        $mail->setSubject("你的文档有新的通知");
//$mail->setTextBody('zheshisha ');   //发布纯文字文本
        $mail->setHtmlBody("你的文档有新的通知，快点过来查看啊1111");    //发布可以带html标签的文本
        if($mail->send())
            echo "success";
        else
            echo "failse";
        die();
     }
}
