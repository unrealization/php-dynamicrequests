<?php
use PHPUnit\Framework\TestCase;
use unrealization\PHPClassCollection\DynamicRequestHandler;
use unrealization\PHPClassCollection\DynamicResponse;

/**
 * DynamicRequestHandler test case.
 * @covers unrealization\PHPClassCollection\DynamicRequestHandler
 * @uses unrealization\PHPClassCollection\DynamicResponse
 */
class DynamicRequestHandlerTest extends TestCase
{
	public function testAddFunction()
	{
		$handler = new DynamicRequestHandler();
		$handler = $handler->addFunction('dummyFunction');
		$this->assertInstanceOf(DynamicRequestHandler::class, $handler);
	}

	public function testAddFunctionStaticMethod()
	{
		$handler = new DynamicRequestHandler();
		$handler = $handler->addFunction('\DummyClass::dummyFunction');
		$this->assertInstanceOf(DynamicRequestHandler::class, $handler);
	}

	public function testAddFunctionMissing()
	{
		$handler = new DynamicRequestHandler();
		$this->expectException(\Exception::class);
		$handler->addFunction('testFunction');
	}

	public function testAddFunctionDuplicate()
	{
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunction');
		$this->expectException(\Exception::class);
		$handler->addFunction('dummyFunction');
	}

	public function testProcess()
	{
		$_POST['dynamicCall'] = '{"functionName": "dummyFunction", "parameters": {}}';
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunction');
		$response = $handler->process(false);
		$this->assertIsString($response);
		$this->assertSame('[]', $response);
	}

	public function testProcessParameterArray()
	{
		$_POST['dynamicCall'] = '{"functionName": "dummyFunction", "parameters": ["value1", "value2"]}';
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunction');
		$response = $handler->process(false);
		$this->assertIsString($response);
		$this->assertSame('[]', $response);
	}

	public function testProcessParameterObject()
	{
		$_POST['dynamicCall'] = '{"functionName": "dummyFunction", "parameters": {"key1": "value1", "key2": "value2"}}';
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunction');
		$response = $handler->process(false);
		$this->assertIsString($response);
		$this->assertSame('[]', $response);
	}

	public function testProcessParameterString()
	{
		$_POST['dynamicCall'] = '{"functionName": "dummyFunction", "parameters": "Test"}';
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunction');
		$response = $handler->process(false);
		$this->assertIsString($response);
		$this->assertSame('[]', $response);
	}

	public function testProcessNoCalls()
	{
		unset($_POST['dynamicCall']);
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunction');
		$response = $handler->process(false);
		$this->assertIsString($response);
		$this->assertEmpty($response);
	}

	public function testProcessMissingFunction()
	{
		$_POST['dynamicCall'] = '{"functionName": "dummyFunction", "parameters": {}}';
		$handler = new DynamicRequestHandler();
		$this->expectException(\Exception::class);
		$handler->process(false);
	}

	public function testProcessBrokenFunction()
	{
		$_POST['dynamicCall'] = '{"functionName": "dummyFunctionBroken", "parameters": {}}';
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunctionBroken');
		$this->expectException(\Exception::class);
		$handler->process(false);
	}

	public function testProcessMissingFunctionName()
	{
		$_POST['dynamicCall'] = '{"parameters": {}}';
		$handler = new DynamicRequestHandler();
		$this->expectException(\Exception::class);
		$handler->process(false);
	}

	public function testProcessOutput()
	{
		$_POST['dynamicCall'] = '{"functionName": "dummyFunction", "parameters": {}}';
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunction');
		$this->expectOutputString('[]');
		$handler->process(true);
	}

	public function testGetJavaScript()
	{
		$handler = new DynamicRequestHandler();
		$handler->addFunction('dummyFunction');
		$js = $handler->getJavaScript('/test', '', 'tokenTag', 'tokenValue');
		$this->assertIsString($js);
		$this->assertRegExp('@^function dummyFunction.+$@', $js);
	}
}

function dummyFunction()
{
	$response = new DynamicResponse();
	return $response;
}

function dummyFunctionBroken()
{
	return null;
}

class DummyClass
{
	public static function dummyFunction()
	{
		return dummyFunction();
	}
}
