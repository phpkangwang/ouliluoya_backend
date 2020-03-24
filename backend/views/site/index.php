<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录页面</title>
    <style>
        .div1{
            display: none;
            color: red;
        }
    </style>
    <script src="../../web/js/jquery-3.1.1.min.js"></script>

    <script>
        $(function () {
            $("#register1").click(function(){
                $.ajax({
                    url:'http://150.109.45.122/backend/web/user/register?email=qqq@qq.com',//地址
                    //dataType:'json',//数据类型
                    type:'GET',//类型
                    timeout:2000,//超时
                    //请求成功
                    success:function(data,status){
                        console.log(data);
                        //alert(data);
                        //alert(status);
                    }
                })
            });

            $("#register2").click(function(){
                $.ajax({
                    url:'http://106.14.204.137:10035/fivepk/machine/backend-version-view',//地址
                    dataType:'json',//数据类型
                    type:'GET',//类型
                    timeout:2000,//超时
                    //请求成功
                    success:function(data,status){
                        console.log(data);
                        //alert(data);
                        //alert(status);
                    }
                })
            });
        });
    </script>
</head>
<body>
<div>
    用户名:<input type="text" id="username" ><br/>
    记住用户名:<input type="checkbox" id="rember"><br/>
    密码<input type="password" id="password"><br/>
    <input type="submit" value="登录1" id="register1">
    <input type="submit" value="登录2" id="register2">
    <div class="div1"></div>
</div>
</body>
</html>
