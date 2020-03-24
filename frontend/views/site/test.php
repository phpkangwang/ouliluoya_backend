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
      <img class="test-top-img" src="<?php echo Yii::$app->request->baseUrl; ?>/img/test-banner.png"  alt="头部-结果" />
      <div class="test-frame-bg">
        <div class="test-content">
          <table>
            <tr>
              <td>
              <p id="title"></p>
                  <span id="answer_list">
<!--                      <input type="radio" value="a" name="t1"/>A.在工作时间和工作场所内，因工作原因受到事故伤害的</br>-->
<!--                      <input type="radio" value="b" name="t1"/>B.因犯罪或者违反治安管理伤亡的</br>-->
<!--                      <input type="radio" value="c" name="t1"/>C.因工外出期间，由于工作原因受到伤害或者发生事故下落不明的</br>-->
<!--                      <input type="radio" value="d" name="t1"/>D.员工小马下班回家时被小汽车撞伤右脚</br>-->
                  </span>
              </td>
            </tr>
          </table>
        </div>
        <div class="test-next-btn">下一题</div>
      </div>
    </div>
    <form id="form1" action="<?= Yii::$app->urlManager->createUrl('site/submit-answer') ?>" method="post" style="display: block">
        <input type="text" name="name" value="<?php echo $name?>">
        <input type="text" name="paperNum" id="paperNum">
        <input type="text" name="sort" id="sort">
        <input type="text" name="answer" id="answer">
    </form>
    <img class="bottom-img" src="<?php echo Yii::$app->request->baseUrl; ?>/img/yun-img.png"  alt="云" />
    <div class="footer">©常熟安通林汽车饰件有限公司</div>

  <script>
      var paperNum = "<?php echo $paperNum?>";
      var sort = 1;
      var answerList = new Array();
      var titleType = 1;//默认是单选
      init();

      function init()
      {
          getTitle(paperNum,sort);
      }

      $(".test-next-btn").click(function () {
          if(titleType == 1){
              var myAnswer = $("input[name='t1']:checked").val();
          }else{
              var myAnswer = $("input:checkbox[name='t1']:checked").map(function(index,elem) {
                  return $(elem).val();
              }).get().join('');
          }
          if(myAnswer == undefined){
              alert("请选择一个答案");
              return false;
          }
          answerList.push(myAnswer);
          sort = sort+1;
          getTitle(paperNum,sort);
      });

      function submitAnswer(answer)
      {
          $("#paperNum").val(paperNum);
          $("#sort").val(sort);
          $("#answer").val(answer.join(','));
          $("#form1").submit();
      }

      function getTitle()
      {
          var data = {};
          data.paperNum = paperNum;
          data.sort = sort;
          $.ajax({
              type : 'get',
              url : '<?= Yii::$app->urlManager->createUrl('site/get-next-title') ?>',
              data : data,
              success : function(res){
                  if(res.data == "" || res.data == null){
                      submitAnswer(answerList);
                      return;
                  }
                  var radioList = '';
                  if(res.data.type == 1){
                      if(res.data.answer_one != ""){
                          radioList += '<label><input type="radio" value="A" name="t1"/>'+res.data.answer_one+'</br></label>';
                      }
                      if(res.data.answer_two != ""){
                          radioList += '<label><input type="radio" value="B" name="t1"/>'+res.data.answer_two+'</br></label>';
                      }
                      if(res.data.answer_three != ""){
                          radioList += '<label><input type="radio" value="C" name="t1"/>'+res.data.answer_three+'</br></label>';
                      }
                      if(res.data.answer_four != ""){
                          radioList += '<label><input type="radio" value="D" name="t1"/>'+res.data.answer_four+'</br></label>';
                      }
                  }else{
                      if(res.data.answer_one != ""){
                          radioList += '<label><input type="checkbox" value="A" name="t1"/>'+res.data.answer_one+'</br></label>';
                      }
                      if(res.data.answer_two != ""){
                          radioList += '<label><input type="checkbox" value="B" name="t1"/>'+res.data.answer_two+'</br></label>';
                      }
                      if(res.data.answer_three != ""){
                          radioList += '<label><input type="checkbox" value="C" name="t1"/>'+res.data.answer_three+'</br></label>';
                      }
                      if(res.data.answer_four != ""){
                          radioList += '<label><input type="checkbox" value="D" name="t1"/>'+res.data.answer_four+'</br></label>';
                      }
                  }
                  $("#title").text(res.data.title);
                  $("#answer_list").html(radioList);
                  titleType = res.data.type;
              }
          });
      }

  </script>
  </body>
</html>
