<?php
namespace common\models;

class MyException extends \Exception
{
	private $myCode = 0;
	private $myMessage = "";

	public function __construct($message){
		parent::__construct($message);
	}


	public function toJson($code){
        header('content-type:application/json');
		$obj = new ErrorCode();
		echo json_encode(
				array(
					'code'=>$code,
					'message'=>$obj->getMessage($code)
				),JSON_UNESCAPED_UNICODE
			);
		exit;
	}


}