<?php

use WPMVC\Response;
use PHPUnit\Framework\TestCase;

/**
 * Tests response class.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC
 * @version 3.1.16
 */
class ResponseTest extends TestCase
{
    /**
     * Test response.
     * @group response
     */
    function testDefaultFalse()
    {
        // Prepare
        $response = new Response;

        // Assert
        $this->assertFalse($response->success);
        $this->assertTrue($response->passes);
    }
    /**
     * Test response.
     * @group response
     */
    function testDefaultTrue()
    {
        // Prepare
        $response = new Response(true);

        // Assert
        $this->assertTrue($response->success);
        $this->assertTrue($response->passes);
    }
    /**
     * Test response.
     * @group response
     */
    function testError()
    {
        // Prepare
        $response = new Response;

        // Execute
        $response->error('field', 'Error');

        // Assert
        $this->assertTrue($response->fails);
        $this->assertFalse($response->passes);
        $this->assertArrayHasKey('field', $response->errors);
        $this->assertIsArray($response->errors['field']);
        $this->assertEquals('Error', $response->errors['field'][0]);
    }
    /**
     * Test response.
     * @group response
     */
    function testCastingFail()
    {
        // Prepare
        $response = new Response;
        $response->message = 'An error';
        $response->error('field', 'Error');

        // Execute
        $r = $response->to_array();

        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('error', $r);
        $this->assertArrayHasKey('errors', $r);
        $this->assertArrayHasKey('status', $r);
        $this->assertArrayHasKey('message', $r);
        $this->assertTrue($r['error']);
        $this->assertArrayHasKey('field', $r['errors']);
        $this->assertEquals($response->message, $r['message']);
        $this->assertEquals(500, $r['status']);
    }
    /**
     * Test response.
     * @group response
     */
    function testCastingSuccess()
    {
        // Prepare
        $response = new Response;
        $response->message = 'An error';
        $response->success = true;
        // Execute
        $r = $response->to_array();
        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('error', $r);
        $this->assertArrayHasKey('status', $r);
        $this->assertArrayHasKey('message', $r);
        $this->assertFalse($r['error']);
        $this->assertEquals($response->message, $r['message']);
        $this->assertEquals(200, $r['status']);
    }
    /**
     * Test response.
     * @group response
     */
    function testDataNumeric()
    {
        // Prepare
        $response = new Response;
        $response->data = 2;
        $response->success = true;
        // Execute
        $r = $response->to_array();
        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('data', $r);
        $this->assertEquals($response->data, $r['data']);
    }
    /**
     * Test response.
     * @group response
     */
    function testDataString()
    {
        // Prepare
        $response = new Response;
        $response->data = 'A message';
        $response->success = true;
        // Execute
        $r = $response->to_array();
        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('data', $r);
        $this->assertEquals($response->data, $r['data']);
    }
    /**
     * Test response.
     * @group response
     */
    function testDataBool()
    {
        // Prepare
        $response = new Response;
        $response->data = false;
        $response->success = true;
        // Execute
        $r = $response->to_array();
        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('data', $r);
        $this->assertEquals($response->data, $r['data']);
    }
    /**
     * Test response.
     * @group response
     */
    function testDataArray()
    {
        // Prepare
        $response = new Response;
        $response->data = [1,2,3];
        $response->success = true;
        // Execute
        $r = $response->to_array();
        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('data', $r);
        $this->assertEquals($response->data, $r['data']);
    }
    /**
     * Test response.
     * @group response
     */
    function testDataObject()
    {
        // Prepare
        $response = new Response;
        $response->data = new stdClass;
        $response->data->prop1 = 123;
        $response->data->prop2 = 'ABC';
        $response->success = true;
        // Execute
        $r = $response->to_array();
        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('data', $r);
        $this->assertIsArray($r['data']);
        $this->assertArrayHasKey('prop1', $r['data']);
        $this->assertArrayHasKey('prop2', $r['data']);
        $this->assertEquals($response->data->prop1, $r['data']['prop1']);
        $this->assertEquals($response->data->prop2, $r['data']['prop2']);
    }
    /**
     * Test response.
     * @group response
     */
    function testDataModel()
    {
        // Prepare
        $data = [
            'prop1' => 123,
            'prop2' => 'ABC',
        ];
        $response = new Response;
        $response->data = new Model($data);
        $response->success = true;
        // Execute
        $r = $response->to_array();
        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('data', $r);
        $this->assertIsArray($r['data']);
        $this->assertEquals($data, $r['data']);
    }
    /**
     * Test response.
     * @group response
     */
    function testDataObjectClass()
    {
        // Prepare
        $data = [
            'prop1' => 123,
            'prop2' => 'ABC',
        ];
        $response = new Response;
        $response->data = new ObjectClass($data);
        $response->success = true;
        // Execute
        $r = $response->to_array();
        // Assert
        $this->assertIsArray($r);
        $this->assertArrayHasKey('data', $r);
        $this->assertIsArray($r['data']);
        $this->assertEquals($data, $r['data']);
    }
}