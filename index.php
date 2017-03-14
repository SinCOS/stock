<?php
ini_set('display_errors', 'on');
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define("_DEBUG", true);

session_start();

require ROOT_PATH . "/source/autoload.php";

Flight::set('flight.log_errors', false);
Flight::path(ROOT_PATH . '/Library');
Flight::path(APP_PATH . '/module');
Flight::path(APP_PATH . '/libs');
$cfg_db = require APP_PATH . '/conf/db_cfg.php';
$redis_cfg=require APP_PATH .'/conf/redis_cfg.php';
Flight::register('view', 'Smarty', array(), function ($smarty) use ($_CFG_SMARTY, $_CFG_SYSTEM) {
	$smarty->cache_lifetime = $_CFG_SMARTY['cache_time'] ? $_CFG_SMARTY['cache_time'] : 0;
	$smarty->template_dir = APP_PATH . '/tpl';
	$smarty->compile_dir = APP_PATH . '/tmp/cpl_dir';
	$smarty->cache_dir = APP_PATH . '/tmp/cache_dir';
	$smarty->assign("TPL", APP_PATH . '/tpl/');
	$smarty->left_delimiter = "{{";
	$smarty->right_delimiter = "}}";
});
Flight::register('redis','Redis',array(),function($redis)use($redis_cfg){
	$redis->pconnect($redis_cfg['host'],$redis_cfg['port'],$redis_cfg['timeout']);
});



function check_login(){
	if (isset($_SESSION['user.id'])){
		return intval($_SESSION['user.id']);
	}
	Flight::json(['status'=>0,'message'=>'未登录','result'=>[]]);
}
Flight::register('db', 'Medoo\Medoo', array($cfg_db));
Flight::route('/user/stock/@cid:[0-9]+',function($cid){
	(new StockApi())->stock_list(check_login(),$cid);
});
Flight::route('GET /user/login', function () {
	Flight::view()->display('user/login.tpl');
});
Flight::route('GET /user/info/@id:[0-9]+',function(){
	if (Flight::request()->ajax){
		(new User)->info(check_login());
	}
});
Flight::route('POST /user/login',function(){
	if (Flight::request()->ajax) {
		(new User)->login();
	}
});
Flight::route('/user/favor/@id:[0-9]+',function ($id){
		$request=Flight::request();
		$user=new User;
		$user->favor($request,$id); 
});
Flight::route('/user/logoff',function(){
	session_destroy();
	Flight::redirect('/');
});
Flight::route('GET /user/category',function(){
	(new User)->category_list(check_login());
});
Flight::route('/user/register', function () {
	$request = Flight::request();
	if ($request->method == 'GET') {
		Flight::view()->display('user/register.tpl');
	} elseif ($request->ajax) {
		$user = new User();
		$user->register();
	}
});
Flight::route('/', function () {
	Flight::view()->display('index.tpl');
});
if (_DEBUG) {
	Flight::route('/info', function () {
		phpinfo();
	});
}
Flight::start();
