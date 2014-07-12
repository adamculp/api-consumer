[![Build Status](https://travis-ci.org/adamculp/api-consumer.svg?branch=master)](https://travis-ci.org/adamculp/api-consumer)

About
-----

Simple PHP 5.3 class/wrapper to consume an API through GET using Curl. (created to consume some Mashery APIs, but could be used for others) Methods build API URL params, connection url, and parse expected JSON response.

In the future I intend to add the possibility of an XML return as well, and may even break out the limited Curl functionality to another class.

Requirements
------------

Requires PHP version 5.3+ if namespaces are desired.

Installation
------------

This class can be used directly from a GIT clone:

    git clone https://github.com/adamculp/api-consumer.git

You could also download the ApiConsumer package and move the directory to a desired location where your scripts can then call it.  Alternatively you could simply copy the ApiConsumer.php file to a desired location and call it that way as well.

Non-Composer Usage
------------------

This class was written using namespaces available via PHP 5.3+, and if left unchanged would be used in the following manner:
NOTE: This class contains information needed to utilize a certain Mashery API at Active.com, but you can change the URL and params as needed for other APIs that return JSON.

    require_once 'path/to/src/ApiConsumer/Consumer.php';
    use ApiConsumer\Consumer;
    
    $apiConsumer = new Consumer();
    $url = 'http://api.amp.active.com/search?';
    
    $apiConsumer->setUrl($url);
    
    $meta = 'meta:channel=Running+meta:startDate:daterange:today..' . date('Y-m-d', strtotime('next month'));
    $params = array(
                    'k' => 'ultra+marathon',
                    'v' => 'json',
                    'l' => 'Florida',
                    'r' => '25',
                    's' => 'date_asc',
                    'api_key' => '{Add API Key Here}',
                    'm' => $meta
                );
                
    $options = array(); // key=>value pairs can be added here to alter the curl call
    
    $apiConsumer->setParams($params);
    
    $apiConsumer->setOptions($options);
    
    $apiConsumer->setResponseType('json');
    $apiConsumer->setCallType('get');
    
    $result = $apiConsumer->doApiCall();

Composer Usage
------------------

After either installing Composer using one of the two methods shown at http://getcomposer.org the composer.json would look like:

    {
        "require": {
            "adamculp/api-consumer": "dev-master"
        }
    }

Then you'll need to alter the require_once in the sample above to point to the Composer autoload instead of to the class itself.

    require_once 'vendor/autoload.php'; // to include the composer autoloader


From there you can use the $result array as you see fit.

Please use the /api-consumer/index.php as a working example (minus the API key) of how the class can be included and used.
