<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/base.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/main.css" />
      <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/common.js"></script>
    <title>新入职员工安全考试试题</title>
  </head>
  <body>
    <div>
      <img class="index-top-img" src="<?php echo Yii::$app->request->baseUrl; ?>/img/index-top.png"  alt="头部-标题" />
    </div>
    <div>
      <form id="form1" action="<?= Yii::$app->urlManager->createUrl('site/login') ?>" method="post">
          <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
        <p class="reg-p">请输入姓名 </p>
        <div class="reg-div"><input class="reg-name" type="text" id="name" name="name" /></div>
          <div class="reg-div" style="display: none"><input class="reg-name" type="text" id="paperNum" name="paperNum" value="<?php echo $paperNum;?>" /></div>
        <div class="reg-div"><input class="reg-sub" type="button" value="注册/登录" /></div>
      </form>
    </div>
    <div class="active-rule">活动规则</div>
    <img class="bottom-img" src="<?php echo Yii::$app->request->baseUrl; ?>/img/yun-img.png"  alt="云" />
    <div class="footer">©常熟安通林汽车饰件有限公司</div>
  <script>
        $(".reg-sub").click(function(){
            var name = $("#name").val();
            if( name == ""){
                alert("请填写姓名");
                return false;
            }
            $("#form1").submit();
        });
  </script>
  </body>
</html>
