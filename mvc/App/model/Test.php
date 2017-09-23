<?php
namespace App\model;
use framework\base\Model;
class Test extends Model
{
	public function tablename()
	{
		return 'test';
	}

	public function sel($id)
	{
		$where = 'id = '.$id;
		$data = $this->findOne($this->tablename(),$where);
		print_r($data);die;
		return $data;
	}

}