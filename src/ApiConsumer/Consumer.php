<?php
namespace ApiConsumer;

/**
 * Simple class/wrapper to allows easy creation of a GET url string to be passed
 * via Curl. The class currently assumes a JSON return which will be parsed to an
 * array and returned.
 * 
 * Perhaps in the future I will add in POST capabilities as well as XML parsing
 * and maybe even more Curl capabilities, or add additional classes to do this.
 * 
 * @author Adam Culp http://www.geekyboy.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * 
 */
class Consumer
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
     * @var array
     */
    public $options;

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
        $this->options = array();
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
        $this->options = array();
        $this->callType = null;
        $this->responseType = null;
    }

    /**
     * String to be used as the base URL for a GET call.
     * 
     * @param string $url
     */
    public function setUrl($url)
    {
        // set the url
        $this->url = $url;
    }

    /**
     * Allow retrieval of URL for testing.
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * This function is strictly forward thinking in case I ever allow other request
     * types using curl_setopt($ch, CURLOPT_CUSTOMREQUEST, '???').
     * 
     * @param string $callType
     */
    public function setCallType($callType = 'get')
    {
        // looking for get, post but for now we only do get
        $this->callType = $callType;
    }

    /**
     * Allow retrieval of CallType string for testing.
     *
     * @return string
     */
    public function getCallType()
    {
        return $this->callType;
    }

    /**
     * This function is strictly forward thinking in case I ever create additional
     * parsers.
     * 
     * @param string $responseType
     */
    public function setResponseType($responseType = 'json')
    {
        // looking for json, xml, other but for now we only do json
        $this->responseType = $responseType;
    }

    /**
     * Allow retrieval of params array for testing.
     *
     * @return string
     */
    public function getResponseType()
    {
        return $this->responseType;
    }
    
    /**
     * Expects an array of one or more key=>value pairs of params to later add
     * to the URL string
     * 
     * @param array $params
     */
    public function setParams($params)
    {
        // $param should be a single key => value pair
        if (is_array($params)) {
            foreach ($params as $key => $param) {
                $this->params[$key] = $param;
            }
        }
    }

    /**
     * Allow retrieval of params array for testing.
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Expects an array of one or more key=>value pairs of params to later use
     * as options with curl to alter the way curl is used.
     * 
     * To view a list of potential curl options see: http://php.net/manual/en/function.curl-setopt.php
     * 
     * NOTE: The curl option($key) should not be passed as a string.
     * 
     * @param array $options
     */
    public function setOptions($options)
    {
        // $param should be a single key => value pair
        if (is_array($options)) {
            foreach ($options as $key => $option) {
                $this->options[$key] = $option;
            }
        }
    }

    /**
     * Allow retrieval of options array for testing.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * This is a wrapper to execute the entire process of an API call. It initiates
     * the creation of the URL, and using the returned URL it initiates the curl
     * request, and the resulting JSON is then sent to the parser.  The end result
     * is a usable array.
     * 
     * @return array
     */
    public function doApiCall()
    {
        $parsedResponse = array();
        $jsonResponse = false;

        $curlUrl = $this->createUrl();
        
        if ($curlUrl) {
            $jsonResponse = $this->submitCurlRequest($curlUrl);
        }

        if ($jsonResponse) {
            $parsedResponse = $this->parseJsonResponse($jsonResponse);
        }

        return $parsedResponse;
    }

    /**
     * Create the URL string, complete with any params.
     * 
     * @return string
     */
    public function createUrl()
    {
        $curlUrl = $this->url . '?';

        foreach ($this->params as $key => $value) {
            $curlUrl .= $key . '=' . $value;
            $curlUrl .= '&';
        }

        return $curlUrl;
    }

    /**
     * Build the curl resource and execute it, to return the raw result.
     * 
     * @param string $curlUrl
     * @return mixed
     */
    protected function submitCurlRequest($curlUrl)
    {
        $session = curl_init();
        
        curl_setopt($session, CURLOPT_URL, $curlUrl);
        curl_setopt($session, CURLOPT_HEADER, 0);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
        
        if (!empty($this->options)) {
            foreach ($this->options as $key => $value) {
                curl_setopt($session, $key, $value);
            }
        }
        
        $rawResponse = curl_exec($session);

        curl_close($session);

        return $rawResponse;
    }

    /**
     * Parse a JSON response and return as array.
     * 
     * @param object $jsonResponse
     * @return array
     */
    public function parseJsonResponse($jsonResponse)
    {
        $parsedJson = json_decode($jsonResponse, true);

        return $parsedJson;
    }
}

