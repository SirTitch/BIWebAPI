<?php  
header('Access-Control-Allow-Origin: *'); 
// header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header("HTTP/1.1 200 OK");
require __DIR__ . "/inc/bootstrap.php";
// https://localhost/index.php/{MODULE_NAME}/{METHOD_NAME}?limit={LIMIT_VALUE} 

//Start PHP server
//php -S 127.0.0.1:8000 -t public
//initialize URI segments into a variable
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
$uri = explode( '/', $uri );
 
//Validate the uri segments
if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

//Initilaize the user controller class, and call the action method that matches the requested api call.
require PROJECT_ROOT_PATH . "/controller/api/userController.php";
 
$objFeedController = new UserController();
$strMethodName = $uri[3] . 'Action';
$strFunctionName = "";
if (count($uri) > 4){
    $strFunctionName = $uri[4];
}
$objFeedController->{$strMethodName}($strFunctionName);
?>