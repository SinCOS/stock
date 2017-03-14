<?php 
	/**
	* 
	*/

	class StockApi 
	{
		
	
		function stock_list($uid)
		{

			$db = Flight::db();
			$list = $db->select('user_stock',['id','cpy_id','createtime'],
					['AND' => [
						'uid' => $uid ,
						'status' => 1
					]
				]);
			Flight::json(
				[
				'status' => $list ? 200 : 400,
				'result' => $list!==false ? $list : [] ,
				'message' => microtime(TRUE)  -  $_SERVER['REQUEST_TIME_FLOAT'] 
				]);
		}

	}
	
 ?>