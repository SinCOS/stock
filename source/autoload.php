<?
    require __DIR__ .'/flight/Flight.php';
    Flight::Path(__DIR__);

    require __DIR__ ."/library/db/medoo.php";
    require __DIR__ ."/library/template/Smarty.class.php";

    function load_config($file){
        return require APP_PATH."/conf/".$file."_cfg.php";    	
    }
    
