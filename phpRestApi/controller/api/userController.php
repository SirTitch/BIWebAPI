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

                $initSearch ="";
                $initOrderBy = "";
                $initFilterBy = "";
                $initFilterValue = "";
                $paramForFilter = "";
                if (isset($arrQueryStringParams['searchTerm']) && $arrQueryStringParams['searchTerm']) {
                    $initSearch = $arrQueryStringParams['searchTerm'];
                }
                
                if (isset($arrQueryStringParams['orderBy']) && $arrQueryStringParams['orderBy']) {
                    $initOrderBy = $arrQueryStringParams['orderBy'];
                }

                if (isset($arrQueryStringParams['filterBy']) && $arrQueryStringParams['filterBy']) {
                    $initFilterBy = $arrQueryStringParams['filterBy'];
                }
                
                if (isset($arrQueryStringParams['filterValue']) && $arrQueryStringParams['filterValue']) {
                    $initFilterValue = $arrQueryStringParams['filterValue'];
                }

                // Handle which function to run based on the url request made
                $listFunction = "getCustomers";
                if ($listType == "policy"){
                    $listFunction = "getPolicies";
                } else  if ($listType == "client"){
                    $listFunction = "getClient";
                } else if ($listType == "clientPolicy"){
                    $listFunction = "getClientPolicies";
                }  else if ($listType == "clientPolicyFilter"){
                    $listFunction = "getClientPoliciesFilter"; 
                } else if ($listType == "allCustomers"){
                    $listFunction = "getAllCustomers";
                }  else if ($listType == "allClient"){
                    $listFunction = "getAllClients";
                }  else if ($listType == "allPolicies"){
                    $listFunction = "getAllPolicies";
                } else if ($listType == "allPoliciesFilter"){
                    $listFunction = "getAllPoliciesFilter";
                }

                //Extend for other types
                if (gettype($initFilterValue) == "string"){
                    $paramForFilter = "s";
                } else if (gettype($initFilterValue) == "integer"){
                    $paramForFilter = "i";
                }
                // print($initOrderBy);
                $arrUsers = $userModel->$listFunction($initSearch, $initOrderBy, $initFilterBy, $initFilterValue, $paramForFilter);
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

    public function insertAction( $listType )
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams(); //Split up the request
        // $this->test();
        if (strtoupper($requestMethod) == 'POST') { // Check if the request is a POST
            try {
                $userModel = new UserModel();
                $valuesArray = []; // Get the array of values this way
                // Handle which function to run based on the url request made
                $insertFunction = "insterClient";
                if ($listType == "policy"){
                    $insertFunction = "insertPolicy";
                } else  if ($listType == "client"){
                    $insertFunction = "insertClient";
                } else if ($listType == "customer"){
                    $insertFunction = "insertCustomer";
                } else if ($listType == "clientPolicy"){
                    $insertFunction = "insertClientPolicy";
                }
                // print( $arrQueryStringParams['customerName'] . $arrQueryStringParams["customerAddress"]);
                // print($initOrderBy);
                $arrUsers = $userModel->$insertFunction( $arrQueryStringParams );
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

    public function updateAction( $listType )
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams(); //Split up the request
        // $this->test();
        if (strtoupper($requestMethod) == 'PUT' || strtoupper($requestMethod) == 'OPTIONS') { // Check if the request is a PUT
            try {
                $userModel = new UserModel();
                $valuesArray = []; // Get the array of values this way
                // Handle which function to run based on the url request made
                $updateFunction = "updateClient";
                if ($listType == "policy"){
                    $updateFunction = "updatePolicy";
                } else  if ($listType == "client"){
                    $updateFunction = "updateClient";
                } else if ($listType == "customer"){
                    $updateFunction = "updateCustomer";
                } else if ($listType == "clientPolicy"){
                    $updateFunction = "updateClientPolicy";
                }
                // print( $arrQueryStringParams['customerName'] . $arrQueryStringParams["customerAddress"]);
                // print($initOrderBy);
                $arrUsers = $userModel->$updateFunction( $arrQueryStringParams );
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