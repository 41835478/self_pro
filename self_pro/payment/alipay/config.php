<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017040606570612",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDLzEe8CR6wzJ4i
lSG+Rfps4Dq9UjaNvYhT34SYy3ppW9Bx76LsJwq9vsiRpVDb//Oc5AQJajq6P/jB
IduQ2h0CnW+wMgzLuPHZnW9cYy9IKxamvy5iC6x9DWMmY2z50UPPqWVU3xAQC2rc
QagIiJ7eAYJF/jrPaWXG7AfiezDmUGl87vn6fY9OnjTfUQKWXAQ36MCppP2DxcHr
t81a4BRG/TpMD8VfS9ipt6MZO/5ARy1zMzQEVfcVsCwGtpsYW13njleJ9nhNdxb1
LZPpEAHXtZ01AzlIjE304gl4g6D/9YApQ5VKPPJBHNQilnu9xV1w60R1FCyd6XPk
BQso8eE3AgMBAAECggEAMQ7btcf8O1MGPgzoMoVl4w+XFDvWJgiZ6JbFtIJG1VXk
t4iYD4DWdRaX8Xd6H3tdiUbaMeoAeRUtLFCaKiRXF2oOmLtzmRbMITZkuDioCRdW
PI2I/NESlIfEdlk4wmo9iJ+eZO/NTg9xidPEP0mj9I0obvDj90nH1jq7Kym8e7Qx
s98sOQUoCFHqwukz3JZGvnzGV//tabxY8GLP4wnCUg2xVhdxS4jQPuRg/OeIHS11
T4rd2XGN6WU1uhmMZ+HIZUWtAVNevF3p+KF4dQ26Qgov5RowVHg3aGvNDUW/5N1q
wSKWHhQswIc327x66uBYBqSbjorc6HNIzTa4IIGgAQKBgQDoqkenYXjG4QTcaI5C
DINW9cFL7Ou/GQYkj0UkA6aeuQmZgNJt3n5zkwE/R4BUYI2zJrp0kKGdxUZZr/Mq
z/CquItDTxSRMWJvaVaEjwt2dN12KwCYTRdo9muqbHpCSSgdkJ8+xlsS+hWoAgGt
IgrPWXg/0la8FxCM2Snan87CtwKBgQDgPNR/YbGuw+VeW29MpbjygO29GQ1HFnfp
fLYpgWNu3zeY8YXrclu+RzBrlmXnEkNNsLAXqGuIIV5pdScIZ9ys1oIA50Ye73pU
GOVSfb87rpXqCVPOcKxDfaGkOOhxPExaT7pKCrm2cD7bl67sFlpxaxs5z0sDr5tZ
Rg+Mlr1VgQKBgQCZDMJ76dOQSB9xednyutZ/EsSn1F8z4xs2W4So7zng+WnGL4a9
PXpDPrW4UamqV6V+7wACg828wjPH9cVpKUZwl1sM2O13oVvWXB3Mr2hj8PZpsFoA
1d2Lb2ZdwmQeTI91+1e17LemYRpz3XYK1PT1dy5yFUR3EFkTvhsZNLzHOwKBgQDU
ey/M6LDq7vvotnG3yo1/VYZxmkyHoRXNbPxcRhwHkoLnbW2+FmYy3thWCnTTSe32
r0edk10Z6KzC910eTPTB3p3f50b9x2U+TTz4Num/zwaFd4MvansBlQlXSQmRS1b6
ePQIdzNVWfVmNcxuMBxRvvFUjUYC3yMwq//N84TDgQKBgAH4qGZko6dWyoVNkLB7
27G5nDFPiczkXSPn09cj72K+FP10x1eSjFiDmp2PFma/fyL6Km49rqNsM52KxmbR
logvO8gcJ8wzmWyWLH4fj94A1ILBop1CDPBtfFbAYTUnl/+xpoE31Wy9JqvCx7IH
5TkZE5YQVU3vXLnsLY0DgW95",
		
		//异步通知地址
		'notify_url' => "http://www.pandaeyes.club/payment/alipay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://www.pandaeyes.club/payment/alipay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoCF/4zCX1i7UGYl0qEMyI9cLecOgsZOchOigjuGcltIw10wRQQNIPzHW+jsBaIbuzgxnKQu/V1PTZ7JELcqjM038lU7qkmxgh4kCBH+Kv8T29jB3eBAbBg9vU4UL2+NbmMYuvNwqHbibiTnjmRYz1kY89MTR8znR4Em1/iw5TccZJ06eQA361VQJI8vnrizJDqkH7vVMsd/Z77es+8URfereMKYNkv0IuXShpDTfnFka7cy7VSI9fHTQ0xJbW+MZb/HNsgv9HVpwZ5jyq/QvPzdKLfAoOzsrrF99YZ/dEM5/NhS/5E7X7zMc27VK4wyWKFQ8bYqML7rnBk/v9tpAewIDAQAB",
		
	
);