<?php

/* * *********************************************
 * @类名:   page
 * @参数:   $myde_total - 总记录数
 *          $myde_size - 一页显示的记录数
 *          $myde_page - 当前页
 *          $myde_url - 获取当前的url
 * @功能:   分页实现
 * @作者:   宋海阁
 */

class page {

    private $myde_total;          //总记录数
    private $myde_size;           //一页显示的记录数
    private $myde_page;           //当前页
    private $myde_page_count;     //总页数
    private $myde_i;              //起头页数
    private $myde_en;             //结尾页数
    private $myde_url;            //获取当前的url
    private $attr = '';            //获取当前的url
	public $conf = 1234567; 				  //显示位置
    /*
     * $show_pages
     * 页面显示的格式，显示链接的页数为2*$show_pages+1。
     * 如$show_pages=2那么页面上显示就是[首页] [上页] 1 2 3 4 5 [下页] [尾页] 
     */
    private $show_pages;

    public function __construct($myde_total = 1, $myde_size = 1, $myde_page = 1, $myde_url, $show_pages = 2) {
        $this->myde_total = $this->numeric($myde_total);
        $this->myde_size = $this->numeric($myde_size);
        $this->myde_page = $this->numeric($myde_page);
        $this->myde_page_count = ceil($this->myde_total / $this->myde_size);
        $this->myde_url = $myde_url;
        if ($this->myde_total < 0)
            $this->myde_total = 0;
        if ($this->myde_page < 1)
            $this->myde_page = 1;
        if ($this->myde_page_count < 1)
            $this->myde_page_count = 1;
        if ($this->myde_page > $this->myde_page_count)
            $this->myde_page = $this->myde_page_count;
        $this->limit = ($this->myde_page - 1) * $this->myde_size;
        $this->myde_i = $this->myde_page - $show_pages;
        $this->myde_en = $this->myde_page + $show_pages;
        if ($this->myde_i < 1) {
            $this->myde_en = $this->myde_en + (1 - $this->myde_i);
            $this->myde_i = 1;
        }
        if ($this->myde_en > $this->myde_page_count) {
            $this->myde_i = $this->myde_i - ($this->myde_en - $this->myde_page_count);
            $this->myde_en = $this->myde_page_count;
        }
        if ($this->myde_i < 1)
            $this->myde_i = 1;
    }

    //检测是否为数字
    private function numeric($num) {
        if (strlen($num)) {
            if (!preg_match("/^[0-9]+$/", $num)) {
                $num = 1;
            } else {
                $num = substr($num, 0, 11);
            }
        } else {
            $num = 1;
        }
        return $num;
    }
	public function page_attr($attr = array(
			'onclick' => 'search_keyword(__PAGE__)',
		)){
			
		if(!empty($attr) && is_array($attr)){
			$str = '';
			foreach($attr as $key => $val){
				$str .= $key.'="'.$val.'"';
			}
			$this->attr = $str ;
		}
	}
    //地址替换
    private function page_replace($page) {
        return str_replace("{page}", $page, $this->myde_url);
    }

    //首页
    private function myde_home() {
        if ($this->myde_page != 1) {
			$attr = str_replace('__PAGE__',1,$this->attr);
            return "<a ".$attr." href='" . $this->page_replace(1) . "' data='1' title='首页'>首页</a>";
        } else {
            return "<span>首页</span>";
        }
    }

    //上一页
    private function myde_prev() {
        if ($this->myde_page != 1) {
			$p = ($this->myde_page - 1);
			$attr = str_replace('__PAGE__',$p,$this->attr);
            return "<a ".$attr." href='" . $this->page_replace($p) . "' data='".$p."' title='上一页'>上一页</a>";
        } else {
            return "<span>上一页</span>";
        }
    }

    //下一页
    private function myde_next() {
        if ($this->myde_page != $this->myde_page_count) {
			$p = ($this->myde_page + 1);
			$attr = str_replace('__PAGE__',$p,$this->attr);
            return "<a ".$attr ." href='" . $this->page_replace($this->myde_page + 1) . "' data='".($this->myde_page + 1)."' title='下一页'>下一页</a>";
        } else {
            return"<span>下一页</span>";
        }
    }

    //尾页
    private function myde_last() {
        if ($this->myde_page != $this->myde_page_count) {
			$p = $this->myde_page_count;
			$attr = str_replace('__PAGE__',$p,$this->attr);
            return "<a ".$attr ." href='" . $this->page_replace($this->myde_page_count) . "' data='".$this->myde_page_count."' title='尾页'>尾页</a>";
        } else {
            return "<span>尾页</span>";
        }
    }

    //输出
    public function show($id = 'page') {
		$str = "<div id=" . $id . ">";
		$len = strlen($this->conf)-1;
		$strstr = (string)$this->conf;
		for($a=0;$a<=$len;$a++){
			switch($strstr{$a}){
				case '1':
				$str.="<span class='pageRemark'>共<b>" . $this->myde_page_count .
                "</b>页<b>" . $this->myde_total . "</b>条记录</span>";
					break;
					
				case '2':
				$str.=$this->myde_home();
				break;
				case '3';
				$str.=$this->myde_prev();
				break;
				case '4':
				if ($this->myde_i > 1) {
					$str.="<span class='pageEllipsis'>...</span>";
				}
				for ($i = $this->myde_i; $i <= $this->myde_en; $i++) {
					$attr = str_replace('__PAGE__',$i,$this->attr);
					if ($i == $this->myde_page) {
						$str.="<a ".$attr ." href='" . $this->page_replace($i) . "' title='第" . $i . "页' data='".$i."' class='cur'> $i </a>";
					} else {
						$str.="<a ".$attr ." href='" . $this->page_replace($i) . "' title='第" . $i . "页' data='".$i."' > $i </a>";
					}
				}
				if ($this->myde_en < $this->myde_page_count) {
					$str.="<span class='pageEllipsis'>...</span>";
				}
				break;
				case '5':
				$str.=$this->myde_next();
				break;
				case '6':
				$str.=$this->myde_last();
				break;
				case '7':
				$str.="<span class='pageRemark'>共<b>" . $this->myde_page_count .
                "</b>页<b></b></span>";
				break;
			}
		}
        $str.="</div>";
        return $str;
    }
	
	public function new_show($id = 'page'){
		$str = "<div id=" . $id . ">";
		$len = strlen($this->conf)-1;
		$strstr = (string)$this->conf;
		for($a=0;$a<=$len;$a++){
			switch($strstr{$a}){
				case '1';
				$str.="<span class='pageRemark'>共<b>" . $this->myde_page_count .
                "</b>页<b>" . $this->myde_total . "</b>条记录</span>";
					break;
					
				case '2';
				$str.=$this->myde_home();
				break;
				case '3';
				$str.=$this->myde_prev();
				break;
				case '4';
				if ($this->myde_i > 1) {
					$str.="<span class='pageEllipsis'>...</span>";
				}
				for ($i = $this->myde_i; $i <= $this->myde_en; $i++) {
					if ($i == $this->myde_page) {
						$str.="<a href='" . $this->page_replace($i) . "' title='第" . $i . "页' class='cur'> $i </a>";
					} else {
						$str.="<a href='" . $this->page_replace($i) . "' title='第" . $i . "页'> $i </a>";
					}
				}
				if ($this->myde_en < $this->myde_page_count) {
					$str.="<span class='pageEllipsis'>...</span>";
				}
				break;
				case '5';
				$str.=$this->myde_next();
				break;
				case '6';
				$str.=$this->myde_last();
				case '7';
				$str.="<span class='pageRemark'>共<b>" . $this->myde_page_count .
                "</b>页<b></b></span>";
					break;
				break;
			}
		}
		/*
        $str.="<span class='pageRemark'>总计<b>" . $this->myde_page_count .
                "</b>页<b>" . $this->myde_total . "</b>条记录</span>";
				*/
        $str.="</div>";
        return $str;
	}
	public function len(){
		return $this->myde_page_count;
	}
	
	public function get_current_page(){
		return $this->myde_page;
	}
}

?>