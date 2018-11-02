<?php
function generate_code($length = 6) 
{
    $min = pow(10 , ($length - 1));
	$max = pow(10, $length) - 1;
	return rand($min, $max);
}

function sendSms() {
	# 初始化SendSmsRequest实例用于设置发送短信的参数
	$request = new SendSmsRequest();
	# 必填，设置短信接收号码
	$request->setPhoneNumbers("12345678901");
	# 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
	$request->setSignName("短信签名");
	# 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
	$request->setTemplateCode("SMS_0000001");
	# 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
	$request->setTemplateParam(json_encode(Array(  # 短信模板中字段的值
	"code"=>"12345",
	"product"=>"dsd"
	)));
	# 可选，设置流水号
	$request->setOutId("yourOutId");
	# 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
	$request->setSmsUpExtendCode("1234567");
	# 发起访问请求
	$acsResponse = static::getAcsClient()->getAcsResponse($request);
	return $acsResponse;
}



$phone_number = $_POST['phone_number'];
session_start();
$code = (string)generate_code();
$_SESSION['code'] = $code;
$_SESSION['phone_number'] = $phone_number;
session_commit();

#上线时需要将msg里面的code去掉
$result = array("status" => true,"msg" => $code);
echo json_encode($result);

?>
