<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/base.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/main.css" />
    <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/common.js"></script>
    <title>新入职员工安全考试试题</title>
  </head>
  <body>
    <div class="bg-img">
      <div class="ranking-frame-bg">
        <img class="rank-top-img" src="./img/ranking-img.png"  alt="头部-结果" />
        <div class="ranking-content">
          <ul>
              <?php
                 foreach ($data as $key=>$val){
              ?>
            <li><span class="rank-num"><?php echo $key+1?></span><span class="rank-name"><?php echo $val['name']?></span><span class="rank-score"><?php echo $val['score']?></span></li>
              <?php
              }
              ?>
          </ul>
        </div>
        <div class="test-next-btn">返回首页</div>
      </div>
    </div>
    <img class="bottom-img" src="<?php echo Yii::$app->request->baseUrl; ?>/img/yun-img.png"  alt="云" />
    <div class="footer">©常熟安通林汽车饰件有限公司</div>


    <script>
        $(".test-next-btn").click(function () {
            window.location.href="<?= Yii::$app->urlManager->createUrl(['site/index', 'paperNum' => $paperNum])?>";
        });
    </script>
  </body>
</html>
