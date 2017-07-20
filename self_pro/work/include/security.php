<?php
/**
 * 
 *
 * Framework 核心框架
 * 安全类
 * 防xss攻击
 */
 /*
$_GET['act'] = !empty($_GET['act'])?$_GET['act']:'index';
$_GET['op'] = !empty($_GET['op'])?$_GET['op']:'index';

require_once 'htmlawed.php';
function xss($arr){
	if(is_array($arr)){
		foreach($arr as $key => $val){
			if(is_array($val)){
				xss($val);
			}else{
				htmlawed($val);
			}
		}
	}
}
*/
if(!defined('PROJECT_NAME')) die('project empty');
$ignore = array( "article_content", "pgoods_body", "doc_content", "content", "sn_content", "goods_body", "store_description", "input_group_intro", "remind_content", "note_content", "ref_url", "qq_appcode", "adv_pic_url", "adv_word_url", "adv_slide_url", "appcode" );

$_GET		= !empty( $_GET ) ? Security::getaddslashesforinput( $_GET, $ignore ) : array();
$_POST		= !empty( $_POST ) ? Security::getaddslashesforinput( $_POST, $ignore ) : array();
$_REQUEST	= !empty( $_REQUEST ) ? Security::getaddslashesforinput( $_REQUEST, $ignore ) : array();

$_GET['act'] = !empty($_GET['act'])?$_GET['act']:'index';
$_GET['op'] = !empty($_GET['op'])?$_GET['op']:'index';
class Security
{

		public static function getToken( )
		{
				$token = substr( md5( substr( time( ), 0, -7 ).md5( MD5_KEY ) ), 8, 8 );
				echo "<input type='hidden' name='formhash' value='".$token."' />";
		}

		public static function checkToken( )
		{
				$token = $_POST['formhash'];
				$input_token = substr( md5( substr( time( ), 0, -7 ).md5( MD5_KEY ) ), 8, 8 );
				if ( $token != $input_token )
				{
						$error = "token is error!";
						show_message( $error );
				}
				return TRUE;
		}

		public static function fliterHtmlSpecialChars( $string )
		{
				$string = preg_replace( "/&amp;((#(\\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/", "&\\1", str_replace( array( "&", "\"", "<", ">" ), array( "&amp;", "&quot;", "&lt;", "&gt;" ), $string ) );
				return $string;
		}

		public static function getAddslashesForInput(&$array, $ignore = array( ))
		{
				if ( !function_exists( "htmlawed" ) )
				{
						require( "htmlawed.php" );
				}
				if ( !empty( $array ) )
				{
						while (list( $k, $v ) = each($array))
						{
								if ( is_string( $v ) )
								{
										if ( $k != "statistics_code" )
										{
												if ( !in_array( $k, $ignore ) )
												{
														$v = self::fliterhtmlspecialchars( $v );
                                                        
												}
												else
												{
														if ( get_magic_quotes_gpc( ) )
														{
																$v = stripslashes( $v );
														}
														$v = htmlawed( $v );
												}
												if ( $k == "ref_url" )
												{
														$v = str_replace( "&amp;", "&", $v );
												}
										}
										if ( !get_magic_quotes_gpc( ) )
										{
												$_array[$k] = addslashes( trim( $v ) );
										}
										else
										{
												$_array[$k] = trim( $v );
										}
								}
								else if ( is_array( $v ) )
								{
										if ( $k == 'statistics_code' )
										{
												$array[$k] = $v;
										}
										else
										{
												$array[$k] = self::getaddslashesforinput( $v );
										}
								}
						}
						return $array;
				}
				return FALSE;
		}
}

?>
