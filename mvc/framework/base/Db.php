<?php 
namespace framework\base;
use pdo;
class Db
{
	public $pdo;
    public $tablename;

	public function connect($dbconfig){
		$dsn = "mysql:host=".$dbconfig['db_host'].";dbname=".$dbconfig['db_name'];
		$this->pdo = new PDO($dsn, $dbconfig['db_user'],$dbconfig['db_pwd']);
	}
    //查询一条
	public function findOne($table,$where){
		$sql = 'select * from '.$this->tablename.' where '.$where;
		$data = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
		return $data;
	}
   

    //最后一条id
    public function getLastInsertId()
    {
        $id = $this->pdo->lastInsertId();
        return $id;
    }

    //修改
    public function update($arr = [],$where = '')
    {
        
        $sql = "update $this->tablename set";
       // echo $sql;die;
        $str = '';
        foreach ($this->tableValue as $key => $value) {
            $str.=','."$key='$value'";
            echo $str;
        }die;
        $sql.=substr($str,1)."where $where";
        return $this->pdo->exec($sql);
    }

    //直接使用sql
    public function query($sql)
    {
        return $this->pdo->query($sql)->fetchALL(PDO::FETCH_ASSOC);
    }

    //删除
    public function delete($where = '')
    {
        
        $sql = "delete from $this->tableName where $where";
        return $this->pdo->exec($sql);
    }

    //查询多条
    public function find($field = '*')
    {
        $sql = "select $field from $this->tableName";
        return $this->pdo->query($sql)->fetchALL(PDO::FETCH_ASSOC);
    }


    //添加
    public function insert($arr=[])
    {
        
        $sql="insert into $this->tableName(";
        $k = '';
        $v = '';
        foreach ($this->tableValue as $key => $value) {
            $k.=','.$key;
            $v.=','."'".$value."'";
        }
        $sql = substr($k,1).') values('.substr($v,1).')';
        return $this->pdo->exec($sql);
    }



	
}


