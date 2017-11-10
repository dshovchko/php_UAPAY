<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json response contain an error status!
     */
    public function test_constructor_wrong_status()
    {
        $json = '{"status":0}';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage decoding error of the json response
     */
    public function test_constructor_wrong_json()
    {
        $json = '"{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}"';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json response contain an error message!
     */
    public function test_constructor_contain_error()
    {
        $json = '{"error":{"fields":{"params":{"clientId":"REQUIRED"}},"code":"FORMAT_ERROR"}}';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json response!
     */
    public function test_constructor_nostatus_json()
    {
        $json = '{"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );
    }

    public function test_status()
    {
        $json = '{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );

        $this->assertEquals(
            1,
            $stub->status()
        );
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json does not contain the data field!
     */
    public function test_constructor_nodata_json()
    {
        $json = '{"status":1,"dota":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json does not contain the data field!
     */
    public function test_constructor_invaliddata_json()
    {
        $json = '{"status":1,"data":1}';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );
    }
}
