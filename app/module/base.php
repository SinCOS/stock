<?php 

/**
* 
*/
class base 
{
	/**
	 * [success description]
	 * @param  [type]  $msg  [description]
	 * @param  integer $code [description]
	 * @param  array   $data [description]
	 * @return [type]        [description]
	 */
	function success($msg, $code = 1,$data = []) {
		Flight::json(['message' => $msg, 'status' => $code,'result' => $data]);
	}
	function error($msg,$code = -1) {
		$this->success($msg, $code);
	}
}