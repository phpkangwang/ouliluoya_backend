<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="css/base.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <script src="js/common.js"></script>
    <title>新入职员工安全考试试题</title>
  </head>
  <body>
    <div class="bg-img">
      <div class="test-frame-bg">
        <img class="index-top-img" src="./img/res-img.png"  alt="头部-结果" />
        <div class="res-content">
          <h3>您的评测得分为:</h3>
          <p class="res-txt"><?php echo $rsScore;?>分</p>
        </div>
        <div class="test-next-btn">重新测试</div>
        <div class="ranking-btn">查看排名</div>
      </div>
    </div>
    <img class="bottom-img" src="./img/yun-img.png"  alt="云" />
    <div class="footer">©常熟安通林汽车饰件有限公司</div>
  <script>
      $(".test-next-btn").click(function () {
          window.location.href="<?= Yii::$app->urlManager->createUrl(['site/index', 'paperNum' => $paperNum])?>";
      });

      $(".ranking-btn").click(function () {
          window.location.href="<?= Yii::$app->urlManager->createUrl(['site/ranking', 'paperNum' => $paperNum])?>";
      });
  </script>
  </body>
</html>
