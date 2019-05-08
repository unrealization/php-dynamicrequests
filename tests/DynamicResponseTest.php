<?php
use PHPUnit\Framework\TestCase;
use unrealization\PHPClassCollection\DynamicResponse;

/**
 * DynamicResponse test case.
 * @covers unrealization\PHPClassCollection\DynamicResponse
 */
class DynamicResponseTest extends TestCase
{
	public function test__toString()
	{
		$response = new DynamicResponse();
		$output = (string)$response;
		$this->assertIsString($output);
		$this->assertSame('[]', $output);
	}

	public function testToJson()
	{
		$response = new DynamicResponse();
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[]', $output);
	}

	public function testOutput()
	{
		$response = new DynamicResponse();
		$this->expectOutputString('[]');
		$response->output();
	}

	public function testAddElement()
	{
		$response = new DynamicResponse();
		$response = $response->addElement('parentId', 'elementId');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"addElement","parentId":"parentId","elementId":"elementId"}]', $output);
	}

	public function testAddHtml()
	{
		$response = new DynamicResponse();
		$response = $response->addHtml('elementId', '<div>HTML Content</div>');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"addHtml","elementId":"elementId","content":"<div>HTML Content<\/div>"}]', $output);
	}

	public function testAddText()
	{
		$response = new DynamicResponse();
		$response = $response->addText('elementId', 'Text Content');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"addText","elementId":"elementId","content":"Text Content"}]', $output);
	}

	public function testAlert()
	{
		$response = new DynamicResponse();
		$response = $response->alert('Test');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"alert","message":"Test"}]', $output);
	}
}
