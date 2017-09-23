<?php 
namespace framework\base;

class View
{
	public $controllername;
	public $actionname;
	public $data = [];
	public function __construct($controllername,$actionname){
		$this->controllername = $controllername;
		$this->actionname = $actionname;
	}

	public function assign($name,$value){
		$this->data[$name] = $value;
	}

	public function render(){
		$url = APP_PATH.'App/view/'.$this->controllername.'/'.$this->actionname.'.php';
		//接到方法对应的视图的名称
		extract($this->data);
		include $url;

	}
	
}
