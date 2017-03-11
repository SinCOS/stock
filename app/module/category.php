<?php 

/**
* 
*/
class category extends base
{
	
	function add(){
		$uid = check_login();
		$categoryName = Flight::request()->data->key;
		$db = Flight::db();
		if(strlen($category)<0){$this->error('asdfasedf');}
		if($this->check($categoryName,$uid)){
			$this->error('该组已存在');
		}
		$result = $db->insert('user_stockGroup',[
				'attr_name' => $categoryName,
				'status' => 1,
				'create_at' => time(),
			]);
		if($result !== false){
			
			$this->success('保存成功',200);
		}
		$this->error('保存失败',400);

	}
	function check($attr_name,$uid){
		$db = Flight::db();
		return $db->get('user_stockGroup','id',[
				'AND' => [
					'uid' => $uid,
					'status' => 1,
					'attr_name' => $attr_name
				]
		]);
	}
	function edit($id){
		$db = Flight::db();
		
	}
	function list($uid){
		$db = Flight::db();
		$result = $db->select('user_stockGroup','*',[
				'AND' => [
					'uid' => $uid,
					'status' => 1
				]
			]);
		$this->success($result!==false ?'':'error',$result!==false?200:400,$result!==false ?$result:[]);
	}

}