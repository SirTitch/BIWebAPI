<?php
header('Access-Control-Allow-Origin: *'); 
class BaseController
{
    /**
     * Get URI elements.
     *  Splits up the URI and returns as an array to allow for
     *  the validation of the REST endpoint
     * @return array
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
 
        return $uri;
    }
 
    /**
     * Get querystring params.
     * returns an array of string variables to be passed along with
     * the incoming request.
     * @return array
     */
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }
 
    /**
     * Send API output.
     * Sends the API response, called to send the api response to the user.
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
 
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
 
        echo $data;
        exit;
    }

    /**
     * __call magic method.
     * Error handler, called when a call to the api is made whih
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
}