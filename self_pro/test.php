<?php

//echo date('Y-m-d H:i:s',1496487600);
/*
echo date('Y-m-d H:i:s',1487125404);die;
echo strtotime('2016-12-1 0:00:00');
echo '<br>';
echo strtotime('2017-1-1 0:00:00');
die;

$key = 'abcdef';

$txt = 'wdsaddsasadsad';

$code = 'ok';
$code = 'fial';

$str = encrypt($txt,$key);
echo $str;
function encrypt( $txt, $key = "" )
{
		if ( empty( $key ) || empty( $txt ) )
		{
				return $txt;
		}
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
		$ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
		$nh1 = rand( 0, 64 );
		$nh2 = rand( 0, 64 );
		$nh3 = rand( 0, 64 );
		$ch1 = $chars[$nh1];
		$ch2 = $chars[$nh2];
		$ch3 = $chars[$nh3];
		$nhnum = $nh1 + $nh2 + $nh3;
		$knum = 0;
		$i = 0;
		while ( isset( $key[$i] ) )
		{
				$knum += ord( $key[$i++] );
		}
		$mdKey = substr( md5( md5( md5( $key.$ch1 ).$ch2.$ikey ).$ch3 ), $nhnum % 8, $knum % 8 + 16 );
		$txt = base64_encode( $txt );
		$txt = str_replace( array( "+", "/", "=" ), array( "-", "_", "." ), $txt );
		$tmp = "";
		$j = 0;
		$k = 0;
		$tlen = strlen( $txt );
		$klen = strlen( $mdKey );
		$i = 0;
		for ( ;	$i < $tlen;	++$i	)
		{
				$k = $k == $klen ? 0 : $k;
				$j = ( $nhnum + strpos( $chars, $txt[$i] ) + ord( $mdKey[$k++] ) ) % 64;
				$tmp .= $chars[$j];
		}
		$tmplen = strlen( $tmp );
		$tmp = substr_replace( $tmp, $ch3, $nh2 % ++$tmplen, 0 );
		$tmp = substr_replace( $tmp, $ch2, $nh1 % ++$tmplen, 0 );
		$tmp = substr_replace( $tmp, $ch1, $knum % ++$tmplen, 0 );
		return $tmp;
}


*/
?>