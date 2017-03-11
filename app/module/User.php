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
					setcookie('token', md5($res['id']), time() + 30 * 60);
					$db->update("user", [
						'login_time' => time(),
						'login_ip' => $req->ip,
						'total_login[+]' => 1,
					], ['id' => $res['id']]);
					$this->success('登录成功');
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
				'reg_time' => time(),
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
					$this->success("已删除");
				}
				$this->error("删除失败");
			}
		default:
			#code...#
			break;
		}
	}

}
