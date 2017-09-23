<?php 
//命名空间 
namespace framework\application;

class Application
{
	public $config;

	public function __construct($config){
		$this->config = $config;
	}
	//框架主要运行方法   加载各种信息
	public function run(){
		//自动加载本类中的方法
		spl_autoload_register([$this,'load']);
		//调用自身的错误级别
		self::debug();
		//路由类中的默认控制器和方法
		$this->setdefault();
		//调用路由类
		$this->route();
	}

	public function setdefault(){
		//config中返回的数组中的db  数据库
		\framework\base\Model::$dbconfig = $this->config['db'];
		//config中返回的数组中的默认控制器 
		\framework\route\route::$defaultController = $this->config['defaultController'];
		//config中返回的数组中的默认方法
		\framework\route\route::$defaultAction = $this->config['defaultAction'];
	}


	public function route()
	{

		$route = new \framework\route\route();
		//$_SERVER里面的三个路由访问模式  兼容 正常 重写
		
		//获取 http://www.mvc.com后面的值，包括/
		$url = $_SERVER['REQUEST_URI'];
		//获取当前脚本的路径，如：index.php
		$url1 = $_SERVER['SCRIPT_NAME'];
		//获取的是?后面的值
		$url2 = $_SERVER['QUERY_STRING'];
		
		//如果$url2不存在 走重写模式
		if(empty($url2)){
			$url = str_replace($url1,'',$url);
			$url = $route->rewrite($url);
		}else{
			$url = $route->normal($url2);
		}
		//规范控制器名
		$controllername = "\\App\\controller\\".ucfirst($url['controller']).'Controller';

		//判断是否存在这个控制器
		if(class_exists($controllername)){
			//规定走的方法
			$actionname = $url['action'];
			//实例化这个控制器的方法
			$obj = new $controllername($url['controller'],$actionname);
			//假如方法存在  走这个方法
			if(method_exists($obj,$actionname)){
				$obj->$actionname();
			}

		}else{
			die('找不到控制器');
		}

	}

	public function load($class){
		//加载类库中的各种类
		$filename = APP_PATH.$class.'.php';
		if(is_file($filename)){
			include $filename;
		}
	}

	//错误级别判断 如果false 调用错误日志执行写入操作
	public static function debug(){
		if(debug){
			error_reporting(E_ALL);
			ini_set('display_errors','on');
		}else{
			error_reporting(0);
			ini_set('display_errors','off');
			self::errorlog();
		}
	}

	//错误日志 执行写入操作
	public static function errorlog(){
		//记录错误日志
		ini_set('log_errors', 'on');
		//错误信息存放地点
		error_log('报错',1,APP_PATH.'log/errors/'.date("YmdHis").'.log');
	}

	
	
}


 ?>