<?php
/**
 * The userController Class will extend form the baseController
 * Contains the action methods associated with the REST endpoints that are defined for the user entity
 */
header('Access-Control-Allow-Origin: *'); 
require_once PROJECT_ROOT_PATH . "/controller/api/baseController.php";
class UserController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function listAction( $listType )
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams(); //Split up the request
        // $this->test();
        if (strtoupper($requestMethod) == 'GET') { // Check if the request is a GET
            try {
                $userModel = new UserModel();
 
                // $intLimit = 10;
                $initSearch ="";
                $initOrderBy = "";
                // if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                //     print($arrQueryStringParams['limit']);
                //     $initSearch = $arrQueryStringParams['limit'];
                // }
                // print($arrQueryStringParams['search']);
                if (isset($arrQueryStringParams['searchTerm']) && $arrQueryStringParams['searchTerm']) {
                    $initSearch = $arrQueryStringParams['searchTerm'];
                }
                
                if (isset($arrQueryStringParams['orderBy']) && $arrQueryStringParams['orderBy']) {
                    $initOrderBy = $arrQueryStringParams['orderBy'];
                }

                // Handle which function to run based on the url request made
                $listFunction = "getCustomers";
                if ($listType == "policy"){
                    $listFunction = "getPolicies";
                } else  if ($listType == "client"){
                    $listFunction = "getClient";
                } else if ($listType == "clientPolicy"){
                    $listFunction = "getClientPolocies";
                }
                // print($initOrderBy);
                $arrUsers = $userModel->$listFunction($initSearch, $initOrderBy);
                $responseData = json_encode($arrUsers);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            //If there is no error, send the response, making sure the header is set depending on the data being set
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}