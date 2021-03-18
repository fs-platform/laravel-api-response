<?php

namespace Tests\Unit;

;

use Tests\TestCase;
use Tests\CreatesApplication;

use Aron\Response\Traits\ResponseTrait;

class ApiResponseTest extends TestCase
{
    use ResponseTrait;
    use CreatesApplication;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
    }

    public function testResponse(): void
    {
        $response = $this->response();
        $json = '{"status":"success","code":200,"message":"","data":[],"errors":[]}';
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }

    public function testInternalError(): void
    {
        $response = $this->internalError();
        $json = '{"status":"error","code":500,"message":"Internal Error!","data":[],"errors":[]}';
        $this->assertEquals(500, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }

    public function testBadRequest(): void
    {
        $response = $this->badRequest('1234');
        $json = '{"status":"error","code":400,"message":"1234","data":[],"errors":[]}';
        $this->assertEquals(400, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }

    public function testNotAllow(): void
    {
        $response = $this->notAllow('not Allow');
        $json = '{"status":"error","code":405,"message":"not Allow","data":[],"errors":[]}';
        $this->assertEquals(405, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }

    public function testUnauthorized(): void
    {
        $response = $this->unauthorized('not auth');
        $json = '{"status":"error","code":401,"message":"not auth","data":[],"errors":[]}';
        $this->assertEquals(401, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }

    public function testForbidden(): void
    {
        $response = $this->forbidden('forbidden');
        $json = '{"status":"error","code":403,"message":"forbidden","data":[],"errors":[]}';
        $this->assertEquals(403, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }

    public function testFailed(): void
    {
        $response = $this->badRequest('1234');
        $json = '{"status":"error","code":400,"message":"1234","data":[],"errors":[]}';
        $this->assertEquals(400, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }

    public function testNotFound(): void
    {
        $response = $this->notFound('not found');
        $json = '{"status":"error","code":404,"message":"not found","data":[],"errors":[]}';
        $this->assertEquals(404, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }

    public function testCreated(): void
    {
        $response = $this->created();
        $json = '{"status":"success","code":200,"message":"","data":[],"errors":[]}';
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString($json, $response->content());
    }
}
