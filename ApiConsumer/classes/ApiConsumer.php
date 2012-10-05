<?php
namespace ApiConsumer\classes\ApiConsumerClass;

/**
 * Simple class that allows easy creation of a GET url string to be passed via
 * Curl. The class currently assumes a JSON return which will be parsed to an array
 * and returned.
 * 
 * Perhaps in the future I will add in POST capabilities as well as XML parsing
 * and maybe even more Curl capabilities, or add additional classes to do this.
 * 
 * @author Adam Culp http://www.geekyboy.com
 * @version 0.1
 * @license MIT
 * 
 */
class ApiConsumerClass
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var array
     */
    public $params;

    /**
     * @var string
     */
    public $callType;

    /**
     * @var string
     */
    public $responseType;

    /**
     * 
     */
    public function __construct()
    {
        $this->params = array();
    }

    /**
     * Resets all variables to prepare for fresh object creation if needed for
     * looping.
     * 
     */
    public function reset()
    {
        // clears the object entirely
        $this->url = null;
        $this->params = array();
        $this->callType = null;
        $this->responseType = null;
    }

    /**
     * String to be used for GET call
     * 
     * @param string $url
     */
    public function setUrl($url)
    {
        // set the url
        $this->url = $url;
    }

    /**
     * This function is strictly forward thinking
     * 
     * @param string $callType
     */
    public function setCallType($callType = 'get')
    {
        // looking for get, post but for now we only do get
        $this->callType = $callType;
    }

    /**
     * This function is strictly forward thinking
     * 
     * @param string $responseType
     */
    public function setResponseType($responseType = 'json')
    {
        // looking for json, xml, other but for now we only do json
        $this->responseType = $responseType;
    }

    /**
     * @param array $param
     */
    public function setParam($param)
    {
        // $param should be a single key => value pair
        if (is_array($param)) {
            $this->params[] = $param;
        }
    }

    /**
     * @return array
     */
    public function doApiCall()
    {
        $parsedResponse = array();
        $jsonResponse = false;

        $curlUrl = $this->createCurlUrl();

        if ($curlUrl) {
            $jsonResponse = $this->submitCurlRequest($curlUrl);
        }

        if ($jsonResponse) {
            $parsedResponse = $this->parseJsonResponse($jsonResponse);
        }

        return $parsedResponse;
    }

    /**
     * @return string
     */
    private function createCurlUrl()
    {
        $curlUrl = $this->url . '?';

        foreach ($this->params as $param) {
            foreach ($param as $key => $value) {
                $curlUrl .= $key . '=' . $value;
                $curlUrl .= '&';
            }
        }

        return $curlUrl;
    }

    /**
     * @param string $curlUrl
     * @return mixed
     */
    private function submitCurlRequest($curlUrl)
    {
        $session = curl_init();
        curl_setopt($session, CURLOPT_URL, $curlUrl);
        curl_setopt($session, CURLOPT_HEADER, 0);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);

        $rawResponse = curl_exec($session);

        curl_close($session);

        return $rawResponse;
    }

    /**
     * @param object $jsonResponse
     * @return array
     */
    public function parseJsonResponse($jsonResponse)
    {
        $parsedJson = json_decode($jsonResponse, true);

        return $parsedJson;
    }
}

