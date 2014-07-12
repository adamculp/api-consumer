<?php

namespace Tests;

use ApiConsumer\Consumer;

class ConsumerTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetUrl()
    {
        $consumer = new Consumer();
        
        $consumer->setUrl('http://uws.net');
        
        $result = $consumer->getUrl();
        
        $this->assertEquals('http://uws.net', $result);
    }
    
}