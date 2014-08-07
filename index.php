<?php
require_once 'src/ApiConsumer/Consumer.php';
//require_once 'vendor/autoload.php'; // if using Composer autoloader and psr-0
use ApiConsumer\Consumer;

/**
 * The example below uses the API at Active.com to query "Running" activities in
 * Florida with a start date within the next month that meet the query string of
 * "ultra marathon". It will return a result set of 25 records as set.
 * 
 * @author Adam Culp http://www.geekyboy.com
 */

$apiConsumer = new Consumer();
$url = 'http://api.amp.active.com/search?';
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

$options = array(
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_PORT => 8080
            );

$apiConsumer->setParams($params);

$apiConsumer->setOptions($options);

$apiConsumer->setResponseType('json');
$apiConsumer->setCallType('get');
$apiConsumer->setUrl($url);

$result = $apiConsumer->doApiCall();
?>
<!DOCTYPE html>
<html>
<head>
    <title>API Consumer Example</title>
</head>
<body>
<h1>API Consumer Example (output parsed JSON result array)</h1>

<div style="width:960px;">
    <pre>
        <?php foreach ($result as $key => $value): ?>
        
            <strong><?php echo $key; ?>:</strong> <?php echo $value; ?><br />
            
        <?php endforeach; ?>
    </pre>
</div>

</body>
</html>
