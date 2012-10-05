<?php

use ApiConsumer\classes\ApiConsumerClass\ApiConsumerClass as ApiConsumer;

/**
 * The example below uses the API at Active.com to query "Running" activities in
 * Florida with a start date within the next month that meet the query string of
 * "ultra marathon". It will return a result set of 25 records,
 * 
 */
require_once 'ApiConsumer/classes/ApiConsumer.php';
$apiConsumer = new ApiConsumer();
$url = 'http://api.amp.active.com/search?';
$meta = 'meta:channel=Running+meta:startDate:daterange:today..' . date('Y-m-d', strtotime('next month'));

$apiConsumer->setResponseType('json');
$apiConsumer->setCallType('get');
$apiConsumer->setUrl($url);

$apiConsumer->setParam(array('k' => 'ultra+marathon'));
$apiConsumer->setParam(array('v' => 'json'));
$apiConsumer->setParam(array('l' => 'Florida'));
$apiConsumer->setParam(array('r' => '25'));
$apiConsumer->setParam(array('m' => $meta));
$apiConsumer->setParam(array('s' => 'date_asc'));
$apiConsumer->setParam(array('api_key' => '{api_key_here}'));

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
        <?php print_r($result); ?>
    </pre>
</div>

</body>
</html>