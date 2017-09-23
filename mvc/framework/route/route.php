<?php 

namespace framework\route;


class route 
{
	public static $defaultController = '';
	public static $defaultAction = '';
	//重写模式
	public function rewrite($url){
		//取出空格
		$new_url = trim($url,'/');
		//将字符串转为数组
		$uri = explode('/', $new_url);
		if(empty($uri[0])){
			//假如控制器不存在  走默认的控制器和方法
			$arr['controller'] = self::$defaultController;
			$arr['action'] = self::$defaultAction;
		}else if(count($uri)<2){
			//假如方法不存在  走对应的控制器和index方法
			$arr['controller'] = $uri[0];
			$arr['action'] = self::$defaultAction;
		}else{
			//
			$arr['controller'] = $uri[0];
			$arr['action'] = $uri[1];
		}
		return $arr;

	}
	//正常模式
	public function normal($url)
	{
		//获取?后面第一个字符
		$str = substr($url,0,1);

		if($str == 'c'){
			//假如控制器不存在  走默认的控制器和方法
			if(empty(substr($url,2))){
				
					$arr['controller'] = self::$defaultController;
					$arr['action'] = self::$defaultAction;
			}else{
				//将传过来的url以&符号分割为数组
				$new_url = explode('&',$url);
				$new_url[0] = substr($new_url[0],2);
				
				//假如方法不存在  走对应的控制器和默认方法
				if(empty($new_url[1])){
					$new_url[1] = self::$defaultAction;
				}else{
					$new_url[1] = substr($new_url[1],2);
				}
			}
			if (isset($new_url[0])) {
				//如果标识是c  并且不存在控制器走默认控制器 和对应的方法
				if (empty($new_url[0]) &&!empty($new_url[1])) {
					$arr['controller'] = self::$defaultController;
					$arr['action'] = $new_url[1];
				}elseif (empty($new_url[0]) &&empty($new_url[1])){
					//如果标识是c  并且两个不存在 控制器 方法 都走默认
					$arr['controller'] = self::$defaultController;
					$arr['action'] = self::$defaultAction;
				}elseif (!empty($new_url[0]) &&empty($new_url[1])) {
					//如果标识是c  并且不存在方法走对应的controller 和默认的方法
					$arr['controller'] = $new_url[0];
					$arr['action'] = self::$defaultAction;
				}else{
					$arr['controller']=$new_url[0];
					$arr['action'] = $new_url[1];
				}
			}
		}else if($str == 'r'){
			$arr = [];
			$new_url = substr($url,2);
			$uri = explode('/',$new_url);
			if (isset($uri[0])){
				if (empty($uri[0]) && empty($uri[1])) {
					//如果标识是r  并且不存在控制器和方法走默认控制器和方法
					$arr['controller']= self::$defaultController;
					$arr['action'] = self::$defaultAction;
				}elseif (empty($uri[0]) && !empty($uri[1])) {
					//如果标识是r  并且不存在控制器走默认控制器 走对应的方法
					$arr['controller'] = self::$defaultController;
					$arr['action'] = $uri[1];
				}else if(!empty($uri[0]) && empty($uri[1])){
					//如果标识是r  并且不存在方法走对应的controller 走默认的方法
						$arr['controller']= $uri[0];
						$arr['action'] = self::$defaultAction;
				}else{
					$arr['controller'] = $uri[0];
					$arr['action'] = $uri[1];
				}
		
			}
		}else{
			echo "404 not found";
		}
		
		return $arr;
	}
}

 ?>