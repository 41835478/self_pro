<?php
if(!defined('PROJECT_NAME')) die('project empty');
class regionControl extends systemControl{
	
	//区域更新
	public function update(){
		$path = BasePath.DS.'data'.DS.'region'.DS.'city.php' ;
		$province_name = include_once $path;
		$insert = array(); $province = array(); $city_data = array(); $area_data = array(); $id = 1;
		foreach($province_name as $key => $city){
			$province['region_id'] = $id ; $id++;
			$province['type'] = '1';
			$province['p_id'] = '0';
			$province['name'] = $city['province_name'];
			$insert[] = $province;
			if(isset($city['city']) && !empty($city['city'])){
				foreach($city['city'] as $k => $area){
					$city_data['region_id'] = $id ; $id++;
					$city_data['type'] = '2';
					$city_data['p_id'] = $province['region_id'];
					$city_data['name'] = $area['city_name'];
					$insert[] = $city_data;
					
					if(isset($area['area']) && !empty($area['area'])){
						foreach($area['area'] as $kk => $vv){
							$area_data['region_id'] = $id ; $id++;
							$area_data['type'] = '3';
							$area_data['p_id'] = $city_data['region_id'];
							$area_data['name'] = $vv;
							$insert[] = $area_data;
						}
					}
					
				}
			}
		}
		M('region')->del();
	//	var_dump($insert);die;
		M('region')->insert_all($insert);
		$str = "<?php return '";
		$str .= serialize($insert);
		$str .= "'";
		file_put_contents(BasePath.DS.'data'.DS.'region'.DS.'city_r.php',$str);
		show_message('操作成功','html','-1');
	}
}
?>