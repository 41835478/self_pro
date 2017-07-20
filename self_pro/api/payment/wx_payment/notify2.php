<?php
//file_put_contents('text2.log',date('Y-m-d|H:i:s').'--'.json_encode($_REQUEST) , FILE_APPEND );
$input = file_get_contents('php://input');
if (!empty($input) && empty($_GET['out_trade_no'])) {
    $obj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	file_put_contents('text2.log',date('Y-m-d|H:i:s').'--'.json_encode($obj) , FILE_APPEND );
    $data = json_decode(json_encode($obj), true);
    //根据$data处理自己所要的逻辑
}
$_GET['commend'] = 'wx_payment2';
include_once (__dir__).'/../../payment_api.php';

?>