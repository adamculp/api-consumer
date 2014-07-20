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

    public function testSetAndGetCallType()
    {
        $consumer = new Consumer();

        $consumer->setCallType('post');

        $result = $consumer->getCallType();

        $this->assertEquals('post', $result);
    }

    public function testSetAndGetResponseType()
    {
        $consumer = new Consumer();

        $consumer->setResponseType('xml');

        $result = $consumer->getResponseType();

        $this->assertEquals('xml', $result);
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

    public function testSetAndGetOptions()
    {
        $consumer = new Consumer();

        $testOptions = array('k' => 'ultra+marathon','v' => 'json','l' => 'Florida');

        $consumer->setOptions($testOptions);

        $result = $consumer->getOptions();

        foreach ($testOptions as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($value, $result[$key]);
        }
    }
    
    public function testJsonParser()
    {
        $consumer = new Consumer();

        $testArray = array('k' => 'ultra+marathon','v' => 'json','l' => 'Florida');
        
        $json = json_encode($testArray);
        
        $this->assertJson($json);
        
        $result = $consumer->parseJsonResponse($json);
        
        foreach ($testArray as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($value, $result[$key]);
        }
    }
    
    public function testCreateUrl()
    {
        $consumer = new Consumer();
        $testParams = array('k' => 'ultra+marathon','v' => 'json','l' => 'Florida');
        
        $consumer->setUrl('http://uws.net');
        
        $consumer->setParams($testParams);
        
        $url = $consumer->createUrl();
        
        $this->assertContains('http://uws.net', $url);
        $this->assertContains('ultra+marathon',$url);
        $this->assertContains('json',$url);
        $this->assertContains('Florida',$url);
    }
    
    public function testReset()
    {
        $consumer = new Consumer();
        $testParams = array('k' => 'ultra+marathon','v' => 'json','l' => 'Florida');

        $consumer->setUrl('http://uws.net');
        $consumer->setParams($testParams);
        $consumer->setOptions($testParams);
        $consumer->setCallType('post');
        $consumer->setResponseType('xml');
        
        $this->assertEquals($consumer->getUrl(), 'http://uws.net');
        $this->assertEquals($consumer->getParams(), $testParams);
        $this->assertEquals($consumer->getOptions(), $testParams);
        $this->assertEquals($consumer->getCallType(), 'post');
        $this->assertEquals($consumer->getResponseType(), 'xml');
        
        $consumer->reset();

        $this->assertNull($consumer->getUrl());
        $this->assertEmpty($consumer->getParams());
        $this->assertEmpty($consumer->getOptions());
        $this->assertNull($consumer->getCallType());
        $this->assertNull($consumer->getResponseType());
    }
}
