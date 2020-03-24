<?php

namespace common\models;

class ErrorCode
{
    const ERROR_OK = 200;
    const ERROR_PARAM = 1;
    const ERROR_TOKEN = 2;
    const ERROR_USER_EXIXTE = 3;
    const ERROR_USER_NOT_EXIXTE = 4;
    const ERROR_USER_PASSWORD = 5;
    const ERROR_TOTAL_CONTRIBUTION = 10;
    const ERROR_ARTICLE_NOT_EXIST = 20;
    const ERROR_ARTICLE_IS_READ = 21;
    const ERROR_ARTICLE_IS_MAX_READ = 22;

    private $errorList = [
        '200' => "success",
        '1' => "参数不正确",
        '2' => "Token不正确",
        '3' => "该邮箱已注册",
        '4' => "该邮箱未注册",
        '5' => "密码不正确",
        '10' => "贡献度不足",
        '20' => "当前文章不存在",
        '21' => "当前文章已助力",
        '22' => "当前文章已达到最大助力次数",
    ];


    public function getMessage($code)
    {
        return $this->errorList[$code];
    }
}