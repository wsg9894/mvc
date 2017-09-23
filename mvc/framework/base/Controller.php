<?php 
namespace framework\base;

class Controller 
{	
	public $controllername;
	public $actionname;
	public $view;
	public function __construct($controllername,$actionname){
		$this->controllername = $controllername;
		$this->actionname = $actionname;
		$this->view = new View($controllername,$actionname);
	}

	//传值方式
	public function assign($name,$value){
		$this->view->assign($name,$value);
	}

	//指向页面
	public function render(){
		$this->view->render();
	}

	//跳转页面
	public function redirect($url){
		$url = trim($url,'/');
		$uri = explode('/', $url);
		$controller = $uri[0];
		$action = $uri[1];
		// print_r($controller);die;
		$controller = "\\App\\controller\\".ucfirst($controller).'Controller';
		if(class_exists($controller)){
			
			$obj = new $controller($controller,$action);

			if(method_exists($obj,$action)){
				$obj->$action();
			}else{
				die('找不到方法');
			}

		}else{
			die('找不到控制器');
		}
	}
	
}


