<?php
namespace ApiConsumer\classes\ApiConsumerClass;

class ApiConsumerClass
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $callType;

    /**
     * @var string
     */
    private $responseType;

    /**
     * @param $variables
     */
    public function __construct($variables)
    {
        $this->params = array();
    }

    /**
     *  Resets all variables to prepare for fresh object creation
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
     * @param string $callType
     */
    public function setCallType($callType = 'get')
    {
        // looking for get, post but for now we only do get
        $this->callType = $callType;
    }

    /**
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
     * @return string
     */
    private function createCurlUrl()
    {
        $curlUrl = $this->url . '?';

        foreach ($this->params as $key => $value) {
            $curlUrl .= $key . '=' . $value;
            $curlUrl .= '&';
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

