
<?php
if(!defined('PROJECT_NAME')) die('project empty');
class orderControl extends systemControl{
	//商品列表
	public function order_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$keywords = isset($_GET['keywords'])?$_GET['keywords']:'';
		$keyword_where = '';
		$other = '';		
		if(!empty($keywords)){
		//	$keyword_where = ' and (order_no like "%'.$keywords.'%" or order_name like "%'.$keywords.'%" or mobile like "%'.$keywords.'%" or city like "%'.$keywords.'%" or safe_name like "%'.$keywords.'%" )';
			$keyword_where = search('order_no|mobile|city|safe_name|transaction_id');
			$keywords_url = str_replace('&keywords='.urlencode($keywords),'',$_SERVER['REQUEST_URI']);
			self::output('keywords',$keywords);
			self::output('keywords_url',$keywords_url);
			$keywords = '&keywords='.$keywords;
		}
		$store_id = isset($_GET['store_id'])?$_GET['store_id']:'';
		$pay = isset($_GET['pay'])?$_GET['pay']:'';
	//	$where = 'is_del = 0 '.$keyword_where;
		$where = array(
			'is_del' => 0,
		);
		$where2 = array();
		if(!empty($store_id)){
			$where2['store_id'] = $store_id;
			$other .= '&store_id='.$store_id;
			self::output('store_id',$store_id);
		}
		if(isset($pay)){
			if($pay != 999 && !empty($pay)){
				$where2['pay'] = $pay;
			}
			$other .= '&pay='.$pay;
			self::output('pay',$pay);
		}
		$order_list = M('order')
					->where($where)
					->where($keyword_where)
					->where($where2)
					->order('create_time desc')
					->page($page,$num)
					->select();
		$count = M('order')
					->where($where)
					->where($keyword_where)
					->where($where2)
					->count();
		
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}'.$keywords.$other,10);
		$page->conf = 345;
		if(!empty($order_list)){
			foreach($order_list as $key => $val){
				if($val['pay'] == 0){
					$order_list[$key]['pay'] = '未支付';
				}
				if($val['pay'] == 1){
					$order_list[$key]['pay'] = '已支付';
				}
				if($val['pay'] == 2){
					$order_list[$key]['pay'] = '已取消';
				}
				if($val['pay'] == 3){
					$order_list[$key]['pay'] = '已完成';
				}
				if($val['deposit_pay'] == 0){
					$order_list[$key]['deposit_pay'] = '未支付押金';
				}
				if($val['deposit_pay'] == 1){
					$order_list[$key]['deposit_pay'] = '已支付押金';
				}
				if($val['deposit_pay'] == 2){
					$order_list[$key]['deposit_pay'] = '已退押金';
				}
				$order_bujia = M('order_bujia')->field('sum(b_price) as num')->where(array('order_id' => $val['order_id'],'pay' => 1))->select();
				$qingdan = M('xiaofeiqingdan')->where(array('is_del' => 0,'order_no' => $val['order_no']))->find();
				if(!empty($qingdan)){
					$order_list[$key]['qingdan'] = true;
				}
				if(!empty($order_bujia)){
					$order_list[$key]['bujia'] = $order_bujia[0]['num'];
				}else{
					$order_list[$key]['bujia'] = 0;
				}
			}
		}
		self::output('page',$page->show());
		$store_list = M('store')->where(array('is_open' => 1))->select(); 
		self::output('store_list',$store_list);
		self::output('data',$order_list);
		self::display('order_list');
	}
	
	//清单查看
	public function xiaofeiqingdan_see(){
		self::setheader('qindanheader');
		self::setleft('qingdanleft');
	//	self::setfooter('qindanfooter');
		if(isset($_GET['order_no'])){
			$order_no = $_GET['order_no'];
			$data = M('xiaofeiqingdan')->where(array('order_no' => $order_no,'is_del' =>0))->find();
			self::output('data',$data);	
			self::display('xiaofeiqingdan_see');
		}
	}
	
	//订单补价
	public function order_bujia_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 20;
		$keywords = isset($_GET['keywords'])?$_GET['keywords']:'';
		$keyword_where = '';
		$other = '';		
		if(!empty($keywords)){
		//	$keyword_where = ' and (order_no like "%'.$keywords.'%" or order_name like "%'.$keywords.'%" or mobile like "%'.$keywords.'%" or city like "%'.$keywords.'%" or safe_name like "%'.$keywords.'%" )';
			$keyword_where = search('order_no');
			$keywords_url = str_replace('&keywords='.urlencode($keywords),'',$_SERVER['REQUEST_URI']);
			self::output('keywords',$keywords);
			self::output('keywords_url',$keywords_url);
			$keywords = '&keywords='.$keywords;
		}
		$link = M('order_bujia')->page($page,$num)
				->where($keyword_where)
				->order('create_time desc')->select();
		$count = M('order_bujia')
				->where($keyword_where)
				->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$link);
		self::display('order_bujia_list');
	}
	
	//库存结算
	public function goods_jisuan(){
		if($_POST){
			$goods_num = $_POST['goods_num'];
			$order_id = $_POST['order_id'];
			$order = M('order')->where(array('order_id' => $order_id))->find();
			$add_data = array();
			$zj_deposit = 0;
			foreach($goods_num as $key => $val){
				$arr1 = array();
				if($val > 0){
					$goods_id =  $_POST['goods_id'][$key];
					$g = M('goods')->where(array('goods_id' => $goods_id))->find();
					$arr1['store_id'] = $order['store_id'];
					$arr1['goods_id'] = $_POST['goods_id'][$key];
					$arr1['goods_num'] = $val;
					$arr1['price'] = $g['goods_price'];
					$arr1['z_price'] = $g['goods_price'] * $val;
					$zj_deposit += $arr1['z_price'];
					$arr1['order_id'] = $order['order_id'];
					$arr1['is_buy'] = 1;
					$arr1['user_id'] = $order['user_id'];
					$arr1['pay_type'] = 'xianxia';
					$arr1['pay_type2'] = 3;
					$arr1['create_time'] = time();
					$arr1['create_time2'] = date('Y-m-d H:i:s',time());
					$arr1['is_know'] = 1;
					
					if(!empty($arr1)){
						$add_data[] = $arr1;
					}
				}
			}
			if( $zj_deposit > 0){
				M('order')->where(array('order_id' => $order_id))->update(array('zj_deposit' =>$zj_deposit));
			}
			if(!empty($add_data)){
				M('order_goods_buy')->where(array('order_id' => $order_id))->del();
				$res = M('order_goods_buy')->insert_all($add_data);
				if($res){
					show_message('操作成功','html','-2');
				}else{
					show_message('操作失败','html','-1');
				}
			}
		}
		$order_id = $_GET['order_id'];
		$order = M('order')->where(array('order_id' => $order_id))->find();
		if(!empty($order) && $order['store_id'] > 0){
			$goods_where = array(
				'store_id'   => $order['store_id'],
				'goods_type' => 2,
			);
			$goods_list = M('goods')->where($goods_where)->select();
			if(!empty($goods_list)){
				foreach($goods_list as $key => $val){
					$goods_num = M('order_goods_buy')->field('sum(goods_num) as num')->where(array('order_id' => $order_id,'goods_id' => $val['goods_id'],'is_buy' => 1))->select();
					if(!empty($goods_num[0]['num'])){
						$goods_list[$key]['num'] = $goods_num[0]['num']; 
					}
				}
			}
			self::output('goods',$goods_list);
			self::output('order',$order);
			self::display('goods_jisuan');
		}
	}
	
	public function no_tuiyajin_list(){
		self::output('data_time_control','see');  //显示时间选择器
		$page 		= isset($_GET['page']) ? $_GET['page'] : 1;
		$num = 10;
		$start_day 	= isset($_GET['start_day']) ? strtotime($_GET['start_day']) : '';   //开始时间
		$end_day 	= isset($_GET['end_day']) ? strtotime($_GET['end_day']) : '';		//结束时间
		$keywords 	= isset($_GET['keywords'])? trim($_GET['keywords']):'';						//关键字
		$keywords_url = $_SERVER['REQUEST_URI'];
		$keyword_where = '';	
		if(!empty($start_day)){
			$keywords_url = str_replace('&start_day='.$_GET['start_day'],'',$keywords_url);
			self::output('start_day',$_GET['start_day']);
		}
		
		if(!empty($end_day)){
			if($start_day > $end_day){
				show_message('时间设置错误','html','-1');
			}
			$keywords_url = str_replace('&end_day='.$_GET['end_day'],'',$keywords_url);
			self::output('end_day',$_GET['end_day']);
		}
		if(!empty($keywords)){
			$keyword_where = search('order_no|order_name|mobile|city|safe_name');  //ands是左边是否有链接
			$keywords_url = str_replace(array('&keywords='.$keywords),array(''),$keywords_url);  //把页面和关键字去掉
			self::output('keywords',$keywords);
			$keywords = '&keywords='.$keywords;
		}
		if(!empty($keywords_url)){
			$keywords_url = str_replace('&page='.$_GET['page'],'',$keywords_url);
			self::output('keywords_url',$keywords_url);
		}
		//支付未删除的 本店铺的
		$where = 'is_tyajin = 0 and deposit_pay = 1 and pay = 1 and is_del = 0';// and store_id='.$_SESSION['store_id'];
		$order_list = M('order')->where($where)->where($keyword_where)->page($page,$num)->order('create_time desc')->select();
		$count = M('order')->where($where)->where($keyword_where)->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}'.$keywords,10);
		$page->conf = 345;
		self::output('page',$page->show());
		if(!empty($order_list)){
			foreach($order_list as $key => $val){
				if($val['pay'] == 0){
					$order_list[$key]['pay'] = '未支付';
				}
				if($val['pay'] == 1){
					$order_list[$key]['pay'] = '已支付';
				}
				if($val['pay'] == 2){
					$order_list[$key]['pay'] = '已取消';
				}
				if($val['pay'] == 3){
					$order_list[$key]['pay'] = '已完成';
				}
				if($val['deposit_pay'] == 0){
					$order_list[$key]['deposit_pay'] = '未支付押金';
				}
				if($val['deposit_pay'] == 1){
					$order_list[$key]['deposit_pay'] = '已支付押金';
				}
				if($val['deposit_pay'] == 2){
					$order_list[$key]['deposit_pay'] = '已退押金';
				}
				$order_bujia = M('order_bujia')->field('sum(b_price) as num')->where(array('order_id' => $val['order_id'],'pay' => 1))->select();
				
				if(!empty($order_bujia)){
					$order_list[$key]['bujia'] = $order_bujia[0]['num'];
				}else{
					$order_list[$key]['bujia'] = 0;
				}
			}
		}
		
		self::output('data',$order_list);
		self::display('no_tuiyajin_list');
	}
	//商品提交
	public function commit_two(){
		$data['safe_name'] = !empty($_POST['safe_name'])?$_POST['safe_name']:show_message('请填写订单名称','html','-1');
		$data['mobile'] 	= !empty($_POST['mobile'])?$_POST['mobile']:show_message('请填写手机号','html','-1');
		
		$data['order_desc'] = $_POST['order_desc'];
		$data['over_price'] = $_POST['over_price'];
		$data['price'] 		= $_POST['price'];
		$data['deposit'] 	= $_POST['deposit'];
		$data['zj_deposit'] 	= $_POST['zj_deposit'];
		$data['order_remarks'] 	= $_POST['order_remarks'];
		$data['youhui_price'] 	= $_POST['youhui_price'];
		$data['reminder'] 		= $_POST['reminder'];
		$data['order_state'] 	= $_POST['order_state'];
		$data['fapiao_price'] 	= $_POST['fapiao_price'];
		$data['order_address'] 	= $_POST['order_address'];
		$data['ruzhu_state'] 	= $_POST['ruzhu_state'];
		$data['channel'] 		= $_POST['channel'];
		$data['store_id'] 		= $_SESSION['store_id'];
		$data['people_num'] 	= $_POST['people_num'];
		$data['pay'] 			= !isset($_POST['pay'])? show_message('实付金额是否支付？','html','-1'):$_POST['pay'];
		$data['deposit_pay'] 	= !isset($_POST['deposit_pay'])? show_message('押金是否支付？','html','-1'):$_POST['deposit_pay'];
		
		
		//开始时间
		/*
		if(!empty($_POST['start_day']) && !empty($_POST['start_hour'])){
			$data['start_time'] = date_en($_POST['start_day'],$_POST['start_hour']);
		}else if(empty($_POST['start_day']) && !empty($_POST['start_hour'])){
			$_POST['start_day'] = date('Y-m-d');
			$data['start_time'] = date_en($_POST['start_day'],$_POST['start_hour']);
		}else if(!empty($_POST['start_day']) && empty($_POST['start_hour'])){
			$data['start_time'] = date_en($_POST['start_day'],0);
		}else{
			$data['start_time'] = 0;
		}
		//结束时间
		if(!empty($_POST['end_day']) && !empty($_POST['end_hour'])){
			$data['end_time'] = date_en($_POST['end_day'],$_POST['end_hour']);
		}else if(empty($_POST['end_day']) && !empty($_POST['end_hour'])){
			$_POST['end_day'] = date('Y-m-d');
			$data['end_time'] = date_en($_POST['end_day'],$_POST['end_hour']);
		}else if(!empty($_POST['end_day']) && empty($_POST['end_hour'])){
			$data['end_time'] = date_en($_POST['end_day'],0);
		}else{
			$data['end_time'] = 0;
		}
		
		if($data['start_time'] > $data['end_time'] && $data['start_time'] != 0){
			show_message('开始时间不能在结束时间之后','html','-1');
		}
		*/
		return $data;
	}
	//添加和修改
	public function tuikuan_edit(){
		
		if($_POST){
			$order_id = (isset($_POST['order_id']) && $_POST['order_id'] > 0)?intval($_POST['order_id']):'';
			//提交修改  搜索  商品提交
			$data = $this->commit_two();
		//	$store_id = $_SESSION['store_id'];
			
			if(!empty($order_id)){
				$res = M('order')->where(array('order_id'=>$order_id))->update($data);
			}else{
				$data['create_time'] = time();
				$data['order_no'] 	= generate_order();
				$res = M('order')->insert($data);
				$order = M('order')->where(array('order_no'=>$data['order_no']))->find();
				$order_id = $order['order_id'];
			}
			
			$goods = $_POST['goods'];
			if(!empty($goods)){
				M('order_goods_buy')->where(array('order_id'=>$order_id))->del();
				foreach($goods as $key => $val){
					if(intval($_POST['goods_'.$val]) > 0 ){
						$num = intval($_POST['goods_'.$val]);
						$g = M('goods')->where(array('goods_id'=> $val))->find();
						$order_goods_buy = array(
						//	'store_id' 	=> $_SESSION['store_id'],
							'goods_id' 	=> $val,
							'goods_num' => $num,
							'price'		=> $g['goods_price'],
							'z_price'	=> $g['goods_price']*$num,
							'order_id'	=> $order_id,
							'is_buy'	=> 1,
							'create_time'	=> time(),
							'create_time2'	=> date('Y-m-d H:i:s',time()),
						);
						M('order_goods_buy')->where(array('order_id'=>$order_id))->add($order_goods_buy);
					};
				}
			}
			$dat2 = array();
			if(!empty($_POST['date_time'])){
				M('order_room_buy')->where(array('order_id'=>$order_id))->del();
				foreach($_POST['date_time'] as $key => $val){
					$d = explode('|',$val);
					$dat2[$d[0]] = $d[1];
				}
			}
			if(!empty($dat2) && $store_id > 0){
				ksort($dat2);
				$msg = '';
				$code = '';
				$return_data = array();
				$over_price = 0;
				$yajin = 0;
				$changci = 1;
				$t1 = '';$t2 ='';
				if(count($dat2) > 1){
					if(reset($dat2) == 1){
						$code = '-1';
						$msg = '预订错误';
					}
					if(end($dat2) == 2){
						$code = '-1';
						$msg = '预订错误';
					}
					
					$d1 = $dat2;
					$last = 0;
					foreach($dat2 as $key => $val){
						if(empty($t1)){
							$t1 = $key;
						}
						if(end($dat2) == $val){
							$t2 = $key;
						}
						if(count($dat2)-1 == $last){
							break;
						}
						$last++;
						
						foreach($d1 as $k => $v){
							if($k != $key && strtotime($k) > strtotime($key)){
								if((strtotime($key) + 86400) == strtotime($k)){
									break;
								}else{
									$code = '-1';
									$msg = '预订错误';
								}
							}
						}
					}
					if($code != '-1'){
						$quantian = false;
						foreach($dat2 as $key => $val){
							if(empty($t1)){
								$t1 = $key;
							}
							if(end($dat2) == $val){
								$t2 = $key;
							}
							if($val == 3){
								$quantian = true;
							}else{
								$quantian = false;
							}
							$week = date('w',strtotime($key));
							if($week == 0){
								$week = 7;
							}
							if($val == 1 || $quantian){
								$label = 1;
								$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
								if(!empty($zhidingjiage)){
									$over_price += $zhidingjiage['goods_price'];
								//	$return_data['over_price'] = $zhidingjiage['goods_price'];
								}else{
									$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
									if(!empty($week_price)){
										$over_price += $week_price['week'.$week];
									}else{
										$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
										$over_price += $goods['goods_price'];
									}
								}
								$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
								$yajin += $goods2['deposit']; //押金
								
							}
							if($val == 2 || $quantian){
								$label = 2;
								$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
								if(!empty($zhidingjiage)){
									$over_price += $zhidingjiage['goods_price'];
								}else{
									$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
									if(!empty($week_price)){
										$over_price += $week_price['week'.$week];
									}else{
										$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
										$over_price += $goods['goods_price'];
									}
								}
								$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
								$yajin += $goods2['deposit'];
							}
						}
					}else{
						$return_data['code'] = $code;
						$return_data['msg'] = $msg;
					}
				}else{
					foreach($dat2 as $key => $val){  //一天的价格
						$week = date('w',strtotime($key));
						if($week == 0){
							$week = 7;
						}
						$quantian = false;
						if($val == 3){
							$quantian = true;
						}
						
						if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
								}
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
							}else{
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								}
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						break;
					}
				}
			//	$t1 = reset($dat2);
				$changci = reset($dat2);
			//	$t2 = end($dat2);
				if(reset($dat2) == 2){
					$g1 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>2))->find();
				}else{
					$g1 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>1))->find();
				}
				$t1 = array_flip($t1);
				$t1 .= ' '.$g1['goods_start_time'];
				if(end($dat2) == 1){
					$g2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>1))->find();
				}else{
					$g2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>2))->find();
				}
				
				$t2 = array_flip($t2);
				$t2 .= ' '.$g2['goods_start_time'];
				$t2 = strtotime($t2) + 3600 * $g2['duration'];
				$start_time = strtotime($t1);
				$end_time = $t2;
				M('order')->where(array('order_id'=> $order_id))
						->update(array('start_time'=>$start_time,'end_time'=>$end_time));
				foreach($dat2 as $key => $val){
					$ins_and_ins = false;
					if($val == 3){
						$ins_and_ins = true;
					}
					$order_room_buy = array();
					$order_room_buy['order_id'] = $order_id;
					$order_room_buy['store_id'] = $store_id;
					$order_room_buy['create_time'] = time();
					$order_room_buy['order_time'] = strtotime($key);
					$order_room_buy['is_buy'] = $data['pay'];
					if($val == 1 || $ins_and_ins){
						$order_room_buy['label'] = 1;
						M('order_room_buy')->add($order_room_buy);
					}
					if($val == 2 || $ins_and_ins){
						$order_room_buy['label'] = 2;
						M('order_room_buy')->add($order_room_buy);
					}
				}
			}
			
			if($res){
				show_message('操作成功','html','?act=order&op=order_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		//查询是否有该商品
		if(isset($_GET['order_id']) && intval($_GET['order_id'])){
			$order_id = intval($_GET['order_id']);
			$data = M('order')->where(array('order_id'=>$order_id))->find();
			if($data['zj_deposit'] > 0){
				$data['deposit2'] = $data['deposit'] - $data['zj_deposit'];
			}else{
				$data['deposit2'] = $data['deposit'];
			}
			$where = array(
				'store_id'=>$data['store_id'],
				'goods_type' =>2,
			);
			$goods_list = M('goods')->where($where)->order('add_time desc')->select();
			if(!empty($goods_list)){
				foreach($goods_list as$key => $val){
					$goods_num = M('order_goods_buy')->where(array('goods_id'=>$val['goods_id'],'order_id'=>$order_id))->find();
					$goods_list[$key]['num'] = $goods_num['goods_num'];
				}
			}
			
			//如果有兑换码就使之失效
			$duihuanma = M('duihuanma')->where(array(
								'is_del' =>0,
								'is_use' =>0,
								'order_id' =>$data['order_id'],
							))->find();
			if(!empty($duihuanma)){
				$data['duihuanma'] = $duihuanma['d_code'];
			}
			self::output('data',$data);	
		}
		self::output('goods_list',$goods_list);
		//获取分类
		$category_list = M('public',true)->get_category();
		self::output('category_list',$category_list);
		
		self::display('tuikuan_edit');
	}
	//添加和修改
	public function order_edit(){
		
		if($_POST){
			$order_id = (isset($_POST['order_id']) && $_POST['order_id'] > 0)?intval($_POST['order_id']):'';
			//提交修改  搜索  商品提交
			$data = $this->commit();
			
			if(!empty($order_id)){
				$res = M('order')->where(array('order_id'=>$order_id))->update($data);
			}else{
				$where = 'is_del = 0 and start_time > '.(time()-86400);
				$orders = M('order')->where($where)->select();
				if(!empty($orders)){
					foreach($orders as $key => $val){
						if($data['create_time'] > $val['create_time'] && $data['create_time'] < $val['end_time']
						|| $data['end_time'] > $val['create_time'] && $data['end_time'] < $val['end_time']
						){
							show_message('创建订单，时间冲突','html','-1');
						}
					}
				}	
				$data['create_time'] = time();
				$data['order_no'] 	= generate_order();
				$res = M('order')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=order&op=order_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		
		
		//查询是否有该商品
		if(isset($_GET['order_id']) && intval($_GET['order_id'])){
			$order_id = intval($_GET['order_id']);
			$data = M('order')->where(array('order_id'=>$order_id))->find();
			
			if(!empty($data['start_time'])){
				$start_time = array();
				$start_time = date_un($data['start_time']);
				$data['start_day'] = $start_time['day'];
				$data['start_hour'] = $start_time['hour'];
			}
			if(!empty($data['end_time'])){
				$end_time = array();
				$end_time = date_un($data['end_time']);
				$data['end_day'] = $end_time['day'];
				$data['end_hour'] = $end_time['hour'];
			}
			if(!empty($data['editorValue'])){
				$data['editorValue'] = str_replace_baidu($data['editorValue']);
			}
			
			self::output('data',$data);	
		}
		
		//查询是否有该商品
		if(isset($_GET['order_id']) && intval($_GET['order_id'])){
			$order_id = intval($_GET['order_id']);
			$data = M('order')->where(array('order_id'=>$order_id))->find();
			
			if(!empty($goods_list)){
				foreach($goods_list as$key => $val){
					$goods_num = M('order_goods_buy')->where(array('goods_id'=>$val['goods_id'],'order_id'=>$order_id))->find();
					$goods_list[$key]['num'] = $goods_num['goods_num'];
				}
			}
			self::output('goods_list',$goods_list);
			self::output('data',$data);	
		}
		
		//获取分类
		$category_list = M('public',true)->get_category();
		self::output('category_list',$category_list);
		//获取富文本编辑器
		$baidu_text = file_get_contents(BasePath.DS.PLUGINS.DS.'textarea'.DS.'index.php');
		//echo $baidu_text;die;
		self::output('baidu_text',$baidu_text);
		
		self::display('order_edit');
	}
	
	//退押金列表
	public function tuiyajin_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		
		$start_day 	= isset($_GET['start_day']) ? strtotime($_GET['start_day']) : '';   //开始时间
		$end_day 	= isset($_GET['end_day']) ? strtotime($_GET['end_day']) : '';		//结束时间
		$keywords 	= isset($_GET['keywords'])? trim($_GET['keywords']):'';						//关键字
		$keywords_url = $_SERVER['REQUEST_URI'];
		$keyword_where = '';	
		$where = array();
		if(!empty($start_day)){
			$keywords_url = str_replace('&start_day='.$_GET['start_day'],'',$keywords_url);
			self::output('start_day',$_GET['start_day']);
			$where['create_time'] = '>'.$start_day;
		}
		
		if(!empty($end_day)){
			if($start_day > $end_day){
				show_message('时间设置错误','html','-1');
			}
			$keywords_url = str_replace('&end_day='.$_GET['end_day'],'',$keywords_url);
			self::output('end_day',$_GET['end_day']);
			$where['__AFFIX__tuiyajin.create_time'] = '<'.($end_day +86400);
		}
		if(!empty($keywords)){
			$keyword_where = search('__AFFIX__user.nickname|__AFFIX__user.phone|__AFFIX__order.order_no|__AFFIX__order.mobile|__AFFIX__order.safe_name');  //ands是左边是否有链接
			$keywords_url = str_replace(array('&keywords='.urlencode($keywords)),array(''),$keywords_url);  //把页面和关键字去掉
			self::output('keywords',$keywords);
			$keywords = '&keywords='.$keywords;
		}
		if(!empty($keywords_url)){
			$keywords_url = str_replace('&page='.$_GET['page'],'',$keywords_url);
			
			self::output('keywords_url',$keywords_url);
		}
		$where = array(
			'is_show' => 0,
		);
		$data = M('tuiyajin')
				->field('__AFFIX__tuiyajin.*,__AFFIX__order.order_no,__AFFIX__order.safe_name,__AFFIX__order.transaction_id,__AFFIX__user.nickname,__AFFIX__store.store_name')
				->join('left __AFFIX__user','__AFFIX__user.user_id = __AFFIX__tuiyajin.user_id')
				->join('left __AFFIX__order','__AFFIX__order.order_id = __AFFIX__tuiyajin.order_id')
				->join('left __AFFIX__store','__AFFIX__order.store_id = __AFFIX__store.store_id')
				->where($where)
				->where($keyword_where)
				->page($page,$num)
				->order('create_time desc')
				->select();
				
		$count = M('tuiyajin')
				->join('left __AFFIX__user','__AFFIX__user.user_id = __AFFIX__tuiyajin.user_id')
				->join('left __AFFIX__order','__AFFIX__order.order_id = __AFFIX__tuiyajin.order_id')
				->join('left __AFFIX__store','__AFFIX__order.store_id = __AFFIX__store.store_id')
				->where($where)
				->where($keyword_where)
				->count();
				
		//$count = count($data);
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		self::output('data',$data);
		self::display('tuiyajin_list');
	}	
	
	//退押金
	public function tuiyajin(){
		
		$order_id = intval($_GET['order_id']);
		$yajin = $_GET['yajin'];
		$order = M('order')->where(array('order_id'=>$order_id))->find();
		$goods_list = M('goods_num')->where(array('store_id'=>$order['store_id'],'is_kouchu'=>0))->select();
		if(!empty($goods_list)){
			foreach($goods_list as $key => $val){
				$goods = M('goods')->where(array('goods_id' => $val['goods_id']))->find();
			//	$goods_num = $goods['goods_num'] - ($goods['goods_num'] - $val['num']);
				$goods_num = $goods['goods_num'] - $val['num'];
				M('goods')->where(array('goods_id' => $val['goods_id']))->update(array('goods_num'=> $goods_num,'floor_quantity' =>$goods_num));
				M('goods_num')->where(array('g_id' => $val['g_id']))->update(array('is_kouchu'=> 1));
			}
		}
	//	$is_tui = false;  //是否有押金退款
		if($_POST){
			$is_tui = isset($_POST['is_tui']) && $_POST['is_tui'] == 'on' ? true : false ;
		}
		
		if($order_id > 0){
			if($data['zj_deposit'] > 0){
				$data['deposit'] -= $data['zj_deposit'];
			}
			if(empty($order)){
				show_message('无此订单','html','-1');
			}
			
			if($is_tui){  //假
				if($order['is_tyajin'] != 0){
					show_message('退押金错误','html','-1');
				}
				if($yajin <= 0){
					show_message('押金错误','html','-1');
				}
			}
			
			/*
			if($yajin <= 0 || $yajin > $order['deposit']){
				show_message('押金错误','html','-1');
			}
			*/
			if($order['is_settlement'] > 0){
				show_message('已经结算','html','-1');
			}
			
			$order['yajin'] = $yajin;
			if($is_tui == false){   //无押金
				$res = M('order')->where(array('order_id'=>$order_id))->update(array('is_tyajin' => 1,'deposit_pay' => 2 , 'is_settlement' => 1));  //已退押金
				$tuiyajin_data = array(
					't_price' => '0',
					't_type' => '退押金0',
					'user_id' => $order['user_id'],
					'order_id' => $order_id,
					'create_time' => time(),
				);
				$res2 = M('tuiyajin')->add($tuiyajin_data);
				if($res && $res2){
					$url = URL.'/api/api.php?commend=send_message_tuiyajin&order_id='.$order['order_id'].'&t_price='.$yajin;
				//	var_dump($url);die;
					_curl('get',$url); //通知用户退押金成功
					show_message('押金退回成功','html','-2');
				}else{
					show_message('押金退回失败','html','-1');
				}
			}else if($order['pay_type'] == 'wx'){  //微信退款
				error_reporting(E_ERROR);
				require_once BasePath."/payment/wx_pay/example/order_tyajin.php";
				
				if(!empty($result) && $result['result_code'] == 'SUCCESS' && $result['return_code'] == 'SUCCESS'){
					
					//退过押金
					$res = M('order')->where(array('order_id'=>$order_id))->update(array('is_tyajin' => 1,'deposit_pay' => 2 , 'is_settlement' => 1));  //已退押金
					
					$tuiyajin_data = array(
						't_price' => $yajin,
						't_type' => '微信支付',
						'user_id' => $order['user_id'],
						'order_id' => $order_id,
						'create_time' => time(),
					);
					$res2 = M('tuiyajin')->add($tuiyajin_data);
					
					if($res && $res2){  
						$url = URL.'/api/api.php?commend=send_message_tuiyajin&order_id='.$order['order_id'].'&t_price='.$yajin;
					//	var_dump($url);die;
						_curl('get',$url); //通知用户退押金成功
						show_message('押金退回成功','html','-2');
					}else{
						show_message('押金退回失败','html','-1');
					}
				}
			}else if($order['pay_type'] == 'ali'){  //支付宝退款
				error_reporting(E_ERROR);
				require_once BasePath."/payment/alipay/wappay/order_tyajin.php";
				if(!empty($result) && $result->msg == 'Success' ){
					//退过押金
					$res = M('order')->where(array('order_id'=>$order_id))->update(array('is_tyajin' => 1,'deposit_pay' => 2 , 'is_settlement' => 1));  //已退押金
					
					$tuiyajin_data = array(
						't_price' => $yajin,
						't_type' => '支付宝支付',
						'user_id' => $order['user_id'],
						'order_id' => $order_id,
						'create_time' => time(),
					);
					$res2 = M('tuiyajin')->add($tuiyajin_data);
					
					if($res && $res2){
						$url = URL.'/api/api.php?commend=send_message_tuiyajin&order_id='.$order['order_id'].'&t_price='.$yajin;
					//	var_dump($url);die;
						_curl('get',$url); //通知用户退押金成功
						show_message('押金退回成功','html','-2');
					}else{
						show_message('押金退回失败','html','-1');
					}
				}
			}else{
				show_message('支付类型不匹配','html','-1');
			}	
		}else{
			show_message('页面错误','html','-1');
		}
	}
	
	//订单计算
	public function order_settlement(){
		$order_id = intval($_POST['order_id']);
		$res = true;
		if($order_id > 0){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$data = array(); 
		//	$data['is_settlement'] = 1;  //是否结算
			if(intval($_POST['yinkouchu']) > 0){  //实际修改后
				$data['zj_deposit'] = $_POST['yinkouchu'];
			}
			if(isset($_POST['goods_id'])){
				$data3 = array();
				foreach($_POST['goods_id'] as $key => $val){
					if($_POST['goods_num'][$key] > 0){
						$data2 = array(
							'goods_id' 		=> $val,
							'create_time' 	=> time(),
							'order_id' 		=> $order_id,
							'store_id' 		=> $order['store_id'],
							'goods_price' 	=> $_POST['goods_price'][$key],
							'num' 			=> $_POST['goods_num2'][$key],
							'is_kouchu' 	=> 0,
						);
						$data3[] = $data2;
					}
				}
				M('goods_num')->where(array('order_id' => $order_id))->del();
				M('goods_num')->insert_all($data3);
			}
			if(!empty($data)){
				$res = M('order')->where(array('order_id'=>$order_id))->update($data);
			}else{
				
			}
		}
		if($res){
			show_message('结算成功','html','?act=index&op=index');
		}else{
			show_message('结算失败','html','-1');
		}
	}
	
	//订单结算
	public function order_jiesuan(){
		$num = 1;
		//半小时内能搜到此订单
	//	$where = 'is_settlement = 0 and pay=1 and is_del = 0 and start_time < '.time().' and end_time > '.(time()-1800).' and store_id='.$_SESSION['store_id'];
		$where = array(
			'order_id' => $_GET['order_id'],
		);
		$data = M('order')->where($where)->page($page,$num)->find();
		if(!empty($data['start_time'])){
			$start_time = array();
			$start_time = date_un($data['start_time']);
			$data['start_day'] = $start_time['day'];
			$data['start_hour'] = $start_time['hour'];
		}
		if(!empty($data['end_time'])){
			$end_time = array();
			$end_time = date_un($data['end_time']);
			$data['end_day'] = $end_time['day'];
			$data['end_hour'] = $end_time['hour'];
		}
		if(empty($data)){
			show_message('当前无订单','html','-1');
		}
		self::output('data',$data);
		
		$goods_buy = M('order_goods_buy')
							->field('__AFFIX__goods.goods_name,__AFFIX__order_goods_buy.*,__AFFIX__goods.goods_num as z_num')
							->join('left __AFFIX__goods','__AFFIX__goods.goods_id = __AFFIX__order_goods_buy.goods_id')
							->where(array('__AFFIX__order_goods_buy.order_id'=>$data['order_id'],'__AFFIX__order_goods_buy.is_buy'=>1))
							//无订单购买的
						//	->where('__AFFIX__order_goods_buy.store_id ='.$data['store_id'].' AND __AFFIX__order_goods_buy.create_time > '.$data['start_time'].' AND __AFFIX__order_goods_buy.create_time < '.$data['end_time'].' AND __AFFIX__order_goods_buy.is_buy=1 ','or')
							->select();
		if(!empty($goods_buy)){
			$goods = array();
			foreach($goods_buy as $key => $val){
				if(isset($goods[$val['goods_id']])){
					$goods[$val['goods_id']]['goods_num'] += $val['goods_num'];
					$goods[$val['goods_id']]['xian_num'] -= $val['goods_num'];
				}else{
					$d = array(
						'goods_name' =>$val['goods_name'],
						'goods_id'  =>$val['goods_id'],
						'price' 	=>$val['price'],
						'goods_num' =>$val['goods_num'],
						'xian_num' 	=>$val['z_num'] - $val['goods_num'],
						'z_num' 	=>$val['z_num'],
					);
					$goods[$val['goods_id']] = $d;
				}
			}
			self::output('goods',$goods);
		}
		$goods_zu = M('shangpinzulin_log')
					->field('__AFFIX__shangpinzulin.z_name,__AFFIX__shangpinzulin_log.*')
					->join('left __AFFIX__shangpinzulin',' __AFFIX__shangpinzulin_log.zl_id = __AFFIX__shangpinzulin.z_id')
					->where(array('order_id' => $data['order_id']))
					->select();
		if(!empty($goods_zu)){
			self::output('goods_zu',$goods_zu);
		}
		self::output('order_id',$data['order_id']);
		self::display('order_jiesuan');
	}
	//商品删除
	public function order_del(){
		$order_id = $_GET['order_id'];
		if(intval($order_id) > 0 ){
			//拿商品
			/*
			$order = M('order',true)->get_order_info($order_id,'path');
			if(!empty($order['order_img'])){
				rm_file($order['order_img']);
			}
			if(!empty($order['order_images']) && count($order['order_images']) > 0){
				foreach($order['order_images'] as $key => $val){
					rm_file($val);
				}
			}
			*/
			$res = M('order')->where(array('order_id'=>$order_id))->update(array('is_del'=>'1'));
			
			if($res){
				show_message('删除成功','html','-1');
			}else{
				show_message('删除失败','html','-1');
			}
		}else{
			show_message('操作失败','html','-1');
		}
	}
	
	//商品提交
	public function commit(){
	//	$data['order_name'] = !empty($_POST['order_name'])?$_POST['order_name']:show_message('请填写订单名称','html','-1');
		$data['mobile'] 	= !empty($_POST['mobile'])?$_POST['mobile']:show_message('请填写手机号','html','-1');
		
		$data['safe_name'] = $_POST['safe_name'];
		$data['order_desc'] = $_POST['order_desc'];
		$data['over_price'] = $_POST['over_price'];
		$data['price'] 		= $_POST['price'];
		$data['deposit'] 	= $_POST['deposit'];
		$data['youhui_price'] 	= $_POST['youhui_price'];
		$data['reminder'] 		= $_POST['reminder'];
		$data['people_num'] 	= $_POST['people_num'];
		$data['pay'] 			= !isset($_POST['pay'])? show_message('实付金额是否支付？','html','-1'):$_POST['pay'];
		$data['deposit_pay'] 	= !isset($_POST['deposit_pay'])? show_message('押金是否支付？','html','-1'):$_POST['deposit_pay'];
		
		//开始时间
		if(!empty($_POST['start_day']) && !empty($_POST['start_hour'])){
			$data['start_time'] = date_en($_POST['start_day'],$_POST['start_hour']);
		}else if(empty($_POST['start_day']) && !empty($_POST['start_hour'])){
			$_POST['start_day'] = date('Y-m-d');
			$data['start_time'] = date_en($_POST['start_day'],$_POST['start_hour']);
		}else if(!empty($_POST['start_day']) && empty($_POST['start_hour'])){
			$data['start_time'] = date_en($_POST['start_day'],0);
		}else{
			$data['start_time'] = 0;
		}
		//结束时间
		if(!empty($_POST['end_day']) && !empty($_POST['end_hour'])){
			$data['end_time'] = date_en($_POST['end_day'],$_POST['end_hour']);
		}else if(empty($_POST['end_day']) && !empty($_POST['end_hour'])){
			$_POST['end_day'] = date('Y-m-d');
			$data['end_time'] = date_en($_POST['end_day'],$_POST['end_hour']);
		}else if(!empty($_POST['end_day']) && empty($_POST['end_hour'])){
			$data['end_time'] = date_en($_POST['end_day'],0);
		}else{
			$data['end_time'] = 0;
		}
		
		if($data['start_time'] > $data['end_time'] && $data['start_time'] != 0){
			show_message('开始时间不能在结束时间之后','html','-1');
		}
		return $data;
	}
	
	public function order_images_del(){
		if(intval($_POST['order_id']) > 0){
			$order_id = intval($_POST['order_id']);
			$image = $_POST['image'];
			$order = M('order')->field('order_images')->where(array('order_id'=>$order_id))->find();
			$order['order_images'] = explode(',',$order['order_images']);
			if(!empty($order['order_images'])){
				foreach($order['order_images'] as $key => $val){
					if($val == $image){
						rm_file(BasePath.DS.'uploads/order/'.substr($image,0,19).DS.$image);
						unset($order['order_images'][$key]);
					}
				}
			}
			$order['order_images'] = implode(',',$order['order_images']);
			
			M('order')->where(array('order_id'=>$order_id))->update($order);
			echo json_encode(array('code'=>'1','msg'=>'图片已删除'));
		}else{
			echo json_encode(array('code'=>'-1','msg'=>'图片删除失败'));
		}
	}
	
	//取消订单
	public function order_quxiao(){
		$order_id = $_GET['order_id'];
		if($order_id > 0){
			$order_data = array(
				'pay' => 2,
				'is_del' => 1,
			);
			M('order')->where(array('order_id' => $order_id))->update($order_data);
			M('order_goods_buy')->where(array('order_id' => $order_id))->update(array('is_del' => 1));
			M('order_room')->where(array('order_id' => $order_id))->update(array('is_del' => 1));
			M('order_room_buy')->where(array('order_id' => $order_id))->update(array('is_del' => 1));
			show_message('取消成功','html','-2');
		}
	}
	
}