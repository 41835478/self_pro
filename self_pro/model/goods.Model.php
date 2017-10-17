<?php
if(!defined('PROJECT_NAME')) die('project empty');
class goodsModel{
	
	//首页获取精品资源
	public function get_boutique($w = array()){
		$data = array();
		$where = array(
			'__AFFIX__goods.is_del' 	=> '0',
			'__AFFIX__goods.is_show' 	=> '1',
		//	'__AFFIX__goods.boutique' 	=> '1',  //精品
		);
		$goods = M('goods')
				->field('__AFFIX__goods.*,__AFFIX__user.name as nickname')
				->where($where)
				->join('left __AFFIX__user','__AFFIX__goods.u_id = __AFFIX__user.id')
				->limit(4)
				->order('update_time desc')
				->select();
		if(!empty($goods)){
			foreach($goods as & $val){
				$time = $val['create_time'];
				$val['create_time'] = date('Y-m-d H:i:s',$time);
				$val['create_time2'] = date('Y年m月d日',$time);
			}
		}
		$data = $goods;
		return $data;
	}
}