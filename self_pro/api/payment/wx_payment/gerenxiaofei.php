<?php
file_put_contents('text.log',date('Y-m-d|H:i:s')."\n" , FILE_APPEND );
$_GET['commend'] = 'wx_people_goods_payment';
include_once (__dir__).'/../../payment_api.php';

?>