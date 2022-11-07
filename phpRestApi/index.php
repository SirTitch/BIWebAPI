<?php  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("HTTP/1.1 200 OK");
require __DIR__ . "/inc/bootstrap.php";

//Start PHP server
//in phpRestApi/
//php -S localhost:5174
//in vueJSFrontend/
//run npm install
//Start Dev VueJs by npm run dev
//Open MYSQL
//Update phpRestApi/inc/config variables to equal your current mySQL creds
//run the BrokerSchema.sql Commands on the msql command line
//Now the App Should run

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