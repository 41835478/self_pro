<?php
if(!defined('PROJECT_NAME')) die('project empty');
class dataControl extends systemControl{
	
	private $ttt_time = '2017-06-17 00:00:00'; //导出日期 
	
	public function data(){
		self::display("data_expload");
	}
	
	public function data_expload(){
		$xlsName = "出账".date('YmdHis');
		$xlsCell = array(
            array('order_id', '订单id'),
            array('safe_name', '下单人姓名'),
            array('order_no', '订单号'),
            array('mobile', '手机号'),
            array('transaction_id', '微信订单号'),
            array('over_price', '支付金额'),
            array('create_time', '支付时间'),
        );
		$where = 'pay = 1 and is_del = 0';
		$data = M('order')
		//		->field('__AFFIX__order.order_no,__AFFIX__tuiyajin.*,__AFFIX__user.nickname')
		//		->join('left __AFFIX__order','__AFFIX__order.order_id = __AFFIX__tuiyajin.order_id')
		//		->join('left __AFFIX__user','__AFFIX__user.user_id = __AFFIX__tuiyajin.user_id')
				->where($where )
				->select();
		foreach($data as $key => $val){
			$data[$key]['order_no'] = ":".$val['order_no'];
			$data[$key]['transaction_id'] = ":".$val['transaction_id'];
			$data[$key]['create_time'] = date('Y-m-d|H:i:s',$val['create_time']);
		}
		$this->expload($xlsName, $xlsCell, $data);
	}
	
	//订单
	public function order(){
		$xlsName = "订单".date('YmdHis');
		$xlsCell = array(
            array('order_id', '订单id'),
            array('safe_name', '下单人姓名'),
            array('order_no', '订单号'),
            array('mobile', '手机号'),
            array('transaction_id', '微信订单号'),
            array('over_price', '支付金额'),
            array('create_time', '支付时间'),
        );
		$where = 'pay = 1 and is_del = 0 and create_time >'.strtotime($this->ttt_time);
		$data = M('order')
				->where($where )
				->select();
		foreach($data as $key => $val){
			$data[$key]['order_no'] = ":".$val['order_no'];
			$data[$key]['transaction_id'] = ":".$val['transaction_id'];
			$data[$key]['create_time'] = date('Y-m-d|H:i:s',$val['create_time']);
		}
		$this->expload($xlsName, $xlsCell, $data);
	}
	
	//商品
	public function goods(){
		$xlsName = "商品".date('YmdHis');
		$xlsCell = array(
            array('goods_name', '商品名称'),
            array('goods_num', '商品数量'),
            array('price', '单价'),
            array('z_price', '总价'),
            array('out_trade_no', '微信订单号'),
            array('create_time', '时间'),
        );
		$where = array(
			'is_buy' => 1,
			'create_time' => '>'.strtotime($this->ttt_time),
		);
		$data = M('order_goods_buy')
				->field('__AFFIX__goods.goods_name,__AFFIX__order_goods_buy.*')
		//		->join('left __AFFIX__order','__AFFIX__order.order_id = __AFFIX__tuiyajin.order_id')
				->join('left __AFFIX__goods','__AFFIX__goods.goods_id = __AFFIX__order_goods_buy.goods_id')
				->where($where )
				->select();
		foreach($data as $key => $val){
			$data[$key]['out_trade_no'] = ":".$val['out_trade_no'];
			$data[$key]['create_time'] = date('Y-m-d|H:i:s',$val['create_time']);
		}
		$this->expload($xlsName, $xlsCell, $data);
	}
	
	//补单数据
	public function budanshuju(){
		$xlsName = "补单".date('YmdHis');
		$xlsCell = array(
            array('order_id', '订单id'),
            array('safe_name', '下单人姓名'),
            array('order_no', '订单号'),
            array('mobile', '手机号'),
        //    array('transaction_id', '微信订单号'),
        //    array('over_price', '支付金额'),
            array('b_price', '补单价'),
            array('create_time', '创建时间'),
        );
		$where = array(
			'__AFFIX__order_bujia.pay' => 1,
			'__AFFIX__order_bujia.create_time' => '>'.strtotime($this->ttt_time)
		);
		$data = M('order_bujia')
				->field('__AFFIX__order_bujia.*,__AFFIX__order.safe_name,__AFFIX__order.order_no,__AFFIX__order.mobile')
				->join('left __AFFIX__order','__AFFIX__order.order_id = __AFFIX__order_bujia.order_id')
				->where($where)
				->select();
		foreach($data as $key => $val){
			$data[$key]['order_no'] = ":".$val['order_no'];
			$data[$key]['mobile']  = ":".$val['mobile'];
			$data[$key]['create_time'] = date('Y-m-d|H:i:s',$val['create_time']);
		}
		$this->expload($xlsName, $xlsCell, $data); //输出
	}
	
	//商品库存
	public function goods_kucun(){
		$xlsName = "库存".date('YmdHis');
		$xlsCell = array(
            array('goods_id', '商品id'),
            array('goods_name', '商品名称'),
            array('store_name', '店铺名称'),
            array('floor_quantity', '现库存'),
            array('goods_num', '原始库存'),
        //    array('transaction_id', '微信订单号'),
        //    array('over_price', '支付金额'),
            array('goods_price', '单价'),
        );
		$where = array(
			'__AFFIX__goods.store_id' => 5,   //2杭州 5绍兴
 			'__AFFIX__goods.goods_type' => 2
		);
		$data = M('goods')
				->field('__AFFIX__goods.*,__AFFIX__store.store_name')
				->join('left __AFFIX__store','__AFFIX__store.store_id = __AFFIX__goods.store_id')
				->where($where)
				->select();
		foreach($data as $key => $val){
			$data[$key]['order_no'] = ":".$val['order_no'];
			$data[$key]['mobile']  = ":".$val['mobile'];
			$data[$key]['create_time'] = date('Y-m-d|H:i:s',$val['create_time']);
		}
		$this->expload($xlsName, $xlsCell, $data); //输出
	}
	//退押金
	public function tuiyajin(){
		$xlsName = "退押金".date('YmdHis');
		$xlsCell = array(
            array('order_id', '订单id'),
            array('safe_name', '下单人姓名'),
            array('order_no', '订单号'),
            array('t_price', '退款金额'),
            array('mobile', '手机号'),
            array('transaction_id', '微信订单号'),
            array('over_price', '支付金额'),
            array('create_time', '创建时间'),
        );
		$where = array(
			'__AFFIX__tuiyajin.create_time' => '>'.strtotime($this->ttt_time)
		);
		$data = M('tuiyajin')
				->field('__AFFIX__tuiyajin.*,__AFFIX__order.order_id,__AFFIX__order.safe_name,__AFFIX__order.order_no,__AFFIX__order.mobile,__AFFIX__order.transaction_id,__AFFIX__order.over_price')
				->join('left __AFFIX__order','__AFFIX__order.order_id = __AFFIX__tuiyajin.order_id')
				->where($where)
				->select();
		foreach($data as $key => $val){
			$data[$key]['order_no'] = ":".$val['order_no'];
			$data[$key]['transaction_id'] = ":".$val['transaction_id'];
			$data[$key]['mobile']  = ":".$val['mobile'];
			$data[$key]['create_time'] = date('Y-m-d|H:i:s',$val['create_time']);
		}
		$this->expload($xlsName, $xlsCell, $data); //输出
	}
	
	public function baoxiao(){
		$xlsName = "报销";
		$xlsCell = array(
            array('b_id', 'id号'),
            array('b_name', '姓名'),
            array('b_price', '金额'),
            array('b_type', '类别'),
            array('b_beizhu', '备注'),
            array('is_use', '是否通过'),
            array('create_time', '创建时间'),
        );
		$where = array(
			'create_time' => '>'.strtotime(date($this->ttt_time)),
		);
		$data = M('baoxiao')
				->where($where)
				->order('create_time desc')
				->select();
		if(!empty($data)){
			foreach($data as $key => $val){
				$data[$key]['create_time'] = date('Y-m-d|H:i:s',$val['create_time']);
				if($val['is_use'] == 0){
					$data[$key]['is_use'] = '已提交'; 
				}
				if($val['is_use'] == 1){
					$data[$key]['is_use'] = '已通过'; 
				}
				if($val['is_use'] == 2){
					$data[$key]['is_use'] = '未通过'; 
				}
			}
		}
		$this->expload($xlsName, $xlsCell, $data);
	}
	//导出数据
	private function expload($expTitle, $expCellName, $expTableData){
		if(empty($expCellName) || !is_array($expCellName)){
			show_message('请填写字段');
		}
		
		if(empty($expTableData)){
			die('没有数据');
		}
		$xlsTitle = iconv('utf-8', 'gb2312', $expTitle); //文件名称
		header("Content-type:application/vnd.ms-excel"); 
		header("Content-Disposition:filename=".$expTitle.".xls");
		
		foreach($expCellName as $key => $val){
			echo $val[1]."\t";
		}
		/*
		$field_len = count($expCellName);
		for($i = 0 ; $i < $field_len ; $i++){
			echo $expCellName[$i][1];
		}
		*/
		echo "\n";
		foreach($expTableData as $key => $val){
			
			foreach($expCellName as $kk => $vv){
				$val[$vv[0]] = str_replace(array(' ',"\t"),array('',''),$val[$vv[0]]);
				echo $val[$vv[0]]." \t";
			}
			echo "\n";
		}
	}
	
	public function chakan(){
		$res = M('goods_num')->select();
		$order = array();
		foreach($res as $key => $val){
			$order[$val['order_id']] = $val['order_id'];
		}
		$order = implode(',',$order);
		
		$data = M('order_goods_buy')->where('order_id in('.$order.')')->limit(300)->select();
		$d = array();
		foreach($data as $key => $val ){
			$s = M('goods_num')->where(array('goods_id' => $val['goods_id'],'order_id' => $val['order_id']))->find();
			if(empty($s)){
				$d[] = $val;
			}
		}
		var_dump($d);die;
	}
}
?>