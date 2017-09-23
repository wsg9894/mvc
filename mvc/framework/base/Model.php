<?php 
namespace framework\base;

class Model extends Db
{
	public static $dbconfig = [];
	// public $tablename = '';
	public function __construct(){
		//config里面的db数组
		$this->connect(self::$dbconfig);
		//表名
		$this->tablename = $this->tablename();
	}

	
	
}


 