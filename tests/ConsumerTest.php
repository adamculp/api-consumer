<?php

namespace Tests;

use ApiConsumer\Consumer;

class ConsumerTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetAndGetUrl()
    {
        $consumer = new Consumer();

        $consumer->setUrl('http://uws.net');

        $result = $consumer->getUrl();

        $this->assertEquals('http://uws.net', $result);
    }
    
    public function testSetAndGetParams()
    {
        $consumer = new Consumer();
        
        $testParams = array('k' => 'ultra+marathon','v' => 'json','l' => 'Florida');
        
        $consumer->setParams($testParams);
        
        $result = $consumer->getParams();
        
        foreach ($testParams as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($value, $result[$key]);
        }
    }
}
