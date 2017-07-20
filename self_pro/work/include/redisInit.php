<?php
if(!defined('PROJECT_NAME')) die('project empty'); 
class redisInit {  
      
    private $redis; //redis����  
      
    /** 
     * ��ʼ��Redis 
     * $config = array( 
     *  'server' => '127.0.0.1' ������ 
     *  'port'   => '6379' �˿ں� 
     * ) 
     * @param array $config 
     */  
    public function init($config = array()) {  
        if ($config['server'] == '')  $config['server'] = '127.0.0.1';  
        if ($config['port'] == '')  $config['port'] = '6379';  
        $this->redis = new Redis();  
        $this->redis->connect($config['server'], $config['port']);  
        return $this->redis;  
    }  
      
    /** 
     * ����ֵ 
     * @param string $key KEY���� 
     * @param string|array $value ��ȡ�õ������� 
     * @param int $timeOut ʱ�� 
     */  
    public function set($key, $value, $timeOut = 0) {  
        $value = json_encode($value, TRUE);  
        $retRes = $this->redis->set($key, $value);  
        if ($timeOut > 0) $this->redis->setTimeout($key, $timeOut);  
        return $retRes;  
    }  
  
    /** 
     * ͨ��KEY��ȡ���� 
     * @param string $key KEY���� 
     */  
    public function get($key) {  
        $result = $this->redis->get($key);  
        return json_decode($result, TRUE);  
    }  
      
    /** 
     * ɾ��һ������ 
     * @param string $key KEY���� 
     */  
    public function delete($key) {  
        return $this->redis->delete($key);  
    }  
      
    /** 
     * ������� 
     */  
    public function flushAll() {  
        return $this->redis->flushAll();  
    }  
      
    /** 
     * ��������� 
     * @param string $key KEY���� 
     * @param string|array $value ��ȡ�õ������� 
     * @param bool $right �Ƿ���ұ߿�ʼ�� 
     */  
    public function push($key, $value ,$right = true) {  
        $value = json_encode($value);  
        return $right ? $this->redis->rPush($key, $value) : $this->redis->lPush($key, $value);  
    }  
      
    /** 
     * ���ݳ����� 
     * @param string $key KEY���� 
     * @param bool $left �Ƿ����߿�ʼ������ 
     */  
    public function pop($key , $left = true) {  
        $val = $left ? $this->redis->lPop($key) : $this->redis->rPop($key);  
        return json_decode($val);  
    }  
      
    /** 
     * �������� 
     * @param string $key KEY���� 
     */  
    public function increment($key) {  
        return $this->redis->incr($key);  
    }  
  
    /** 
     * �����Լ� 
     * @param string $key KEY���� 
     */  
    public function decrement($key) {  
        return $this->redis->decr($key);  
    }  
      
    /** 
     * key�Ƿ���ڣ����ڷ���ture 
     * @param string $key KEY���� 
     */  
    public function exists($key) {  
        return $this->redis->exists($key);  
    }  
      
    /** 
     * ����redis���� 
     * redis�зǳ���Ĳ�������������ֻ��װ��һ���� 
     * �����������Ϳ���ֱ�ӵ���redis������ 
     */  
    public function redis() {  
        return $this->redis;  
    }  
}  
?>