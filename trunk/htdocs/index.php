<?php
define('WEBROOT',dirname(dirname(__FILE__)));
define('APP_ROOTPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app');
set_include_path('.'.PATH_SEPARATOR.WEBROOT.'/'.src.PATH_SEPARATOR.WEBROOT.'/'.libs);
header('Content-Type: text/html; charset=UTF-8');

$route = $_GET['q'];

$route = explode('/', $route);

if (count($route) > 2) {
    exit('route error');
}

if (count($route) == 1) {
    $action = 'default';
    if (!empty($route[0]) && ctype_alpha($route[0])) {
        $controller = $route[0];
    } else {
        $controller = 'default';
    }
}


if (count($route) == 2) {
    if (empty($route[0]) || !ctype_alpha($route[0]) || empty($route[1]) || !ctype_alpha($route[1])) {
        exit('route error');
    }
    
    $controller = $route[0];
    $action = $route[1];
}

$actionClassName = ucfirst($controller) . ucfirst($action) . 'Action';
$actionFileName = $actionClassName . '.php';

$actionFilePath = APP_ROOTPATH . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . strtolower($controller) . DIRECTORY_SEPARATOR . $actionFileName;

if (!file_exists($actionFilePath)) {
    exit('route not exist.');
}

require $actionFilePath;
$action = new $actionClassName();

if (!($action instanceof BaseAction) ) {
    throw new Exception("The '$actionClassName' class must extends from BaseAction.");
}

$action->execute();

function url($uri, array $param) {
	$extra = '';
	if(!empty($param)){
		foreach($param as $k=>$v){
			$extra .= '&'.$k.'='.$v;
		}
	}
	return '?q=' . $uri . $extra;
}

