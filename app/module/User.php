<?php

class User extends base {

	/**
	 * [login 用户登录]
	 * @return [void] [nothing]
	 */
	function login() {
		$req = Flight::request();
		if ($req->method == "POST") {
			$username = $req->data->username;
			$pass_t = $req->data->password;
			if (strlen($username) < 3) {$this->error('用户名长度太短');}
			if (strlen($pass_t) < 6) {$this->error('密码长度太短');}
			$password = md5($pass_t);
			$db = Flight::db();
			$res = $db->get('user', '*', ['AND' =>
				[
					'username' => $username,
					'password' => $password,
				],
			]);
			if ($res) {
				$status = intval($res['status']);
				if ($status == 1) {
					$_SESSION['user.id'] = $res['id'];
					$_SESSION['user.username'] = $res['username'];
					$token = md5(uniqid() . $res['id'] );

					setcookie('token', $token);
					$cache = Flight::redis();
					$cache->set("token:{$token}:uid:{$res['id']}",json_encode($res));
					$cache->incr("uid:{$res['id']}",1);
					$db->update("user", [
						'login_time' => time(),
						'login_ip' => $req->ip,
						'total_login[+]' => 1,
					], ['id' => $res['id']]);
					$this->success('登录成功',200,['token' => $token,'userID' => $res['id']]);
				}
			} else {
				$this->error('登录失败');
			}

		}

	}

	function info($uid) {
		$db = Flight::db();
		$user = $db->get('user', ['id','username', 'reg_time'], [
			'AND' => [
				'id' => $uid,
				'status' => 1,
			],
		]);
		if ($user) {
			$this->success('ok', 200, $user);
		}
		$this->error('error');
	}

	/**
	 * [register 用户注册]
	 * @return [type] [description]
	 */
	function register() {
		$req = Flight::request();
		$arr['message'] = '';
		$arr['status'] = '';
		if ($req->method == 'POST') {
			$username = $req->data->username;
			$pass_t = $req->data->password;
			if (strlen($username) < 3) {$this->error('用户名长度太短');}
			if (strlen($pass_t) < 6) {$this->error('密码长度太短');}
			$password = md5($pass_t);
			$db = Flight::db();
			if ($db->has("user", ['username' => $username])) {
				$this->error("此用户名已存在");
			}
			$res = $db->insert('user', ['username' => $username,
				'password' => $password,
				'reg_time' => date("Y-m-d H:i:m"),
				'status' => 1,
			]);
			if ($res) {
				$this->success('注册成功');
			}
			$this->error("注册失败");
		}
		Flight::halt(200, '非法访问');
	}

	function favor($request, $id) {
		$uid = check_login();
		switch ($request->method) {
		case 'POST':
			{
				$db = Flight::db();
				$exists = $db->get('user_stock', 'id', [
					'AND' => [
						'uid' => $uid,
						'cpy_id' => $id,
						'status' => 1],
				]);
				if ($exists) {$this->error('已添加');}
				$result = $db->insert('user_stock', [

					'uid' => $uid,
					'cpy_id' => $id,
					'status' => 1,
					'createtime' => time(),

				]);
				if ($result) {
					$this->success('保存成功');
				}
				$this->error("保存失败");
			}
			break;
		case 'DELETE':
			{
				$db = Flight::db();
				$result = $db->update('user_stock', [
					'status' => 0,
				], [
					'uid' => $uid,
					'cpy_id' => $id,
				]);
				if ($result) {
					$this->success("已删除",200);
				}
				$this->error("删除失败",401);
			}
		default:
			#code...#
			break;
		}
	}
	private function _category_list_cache($uid){
			$db = Flight::db();
			$result = $db->select('stockGroup',['id','name'],[
				'AND' => [
					'status' => 1,
					'uid' => $uid
				]
			]);
			$cache->setEx("uid:{$uid}:skgrp",7*24*3600,json_encode($result));
			return $result;

	}
	function category_list($uid){
		
		$cache = Flight::redis();
		if(!$cache->exists("uid:{$uid}:skgrp")){
			$result = $this->_category_list_cache($uid);
		}else{
			$res = $cache->get("uid:{$uid}:skgrp");

			$result = json_decode($res);
		}
		
		if($result !== false){
			$this->success('ok',200,$result);
		}
		$this->success('ok',200,[]);
	}
	function category_del($id,$uid){
		$db = Flight::db();
		$res = $db->update('stockGroup',[
			'status' => 0
			],[
				'uid' => $uid
			]);
		if($res){
			$this->_category_list_cache($uid);
			$this->success('',200);
		}
		$this->error('失败',401);
	}
	function category_add(){
		$uid = check_login();
		$name = Flight::request()->data->name;
		$db = Flight::db();
		$res = $db->insert('stockGroup',[
			'name' => $name,
			'uid' => $uid,
			'public' => 1,
			'create_at' => date("Y-m-d H:i:m")
			]);
		$cache = Flight::redis();
		$result = $this->_category_list_cache($uid);
		if($res){
			$this->success('',200);
		}else{
			$this->success('fail',401);
		}
	}

}
