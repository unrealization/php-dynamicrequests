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

	public function testClick()
	{
		$response = new DynamicResponse();
		$response = $response->click('elementId');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"click","elementId":"elementId"}]', $output);
	}

	public function testConfirm()
	{
		$response = new DynamicResponse();
		$response = $response->confirm('Please confirm.', 'confirmationHandler');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"confirm","message":"Please confirm.","handlerFunction":"confirmationHandler"}]', $output);
	}

	public function testCreateElement()
	{
		$response = new DynamicResponse();
		$response = $response->createElement('div', 'myDiv');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"createElement","elementType":"div","elementId":"myDiv"}]', $output);
	}

	public function testDeleteElement()
	{
		$response = new DynamicResponse();
		$response = $response->deleteElement('elementId');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"deleteElement","elementId":"elementId"}]', $output);
	}

	public function testDownloadFile()
	{
		$response = new DynamicResponse();
		$response = $response->downloadFile('test.txt', 'Test Content', 'text/plain', 'UTF-8');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"downloadFile","fileName":"test.txt","content":"VGVzdCBDb250ZW50","mimeType":"text\/plain","encoding":"UTF-8"}]', $output);
	}

	public function testInsertElement()
	{
		$response = new DynamicResponse();
		$response = $response->insertElement('parentId', 'elementId');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"insertElement","parentId":"parentId","elementId":"elementId"}]', $output);
	}

	public function testInsertElementAfter()
	{
		$response = new DynamicResponse();
		$response = $response->insertElementAfter('insertAfterId', 'elementId');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"insertElementAfter","insertAfterId":"insertAfterId","elementId":"elementId"}]', $output);
	}

	public function testInsertElementBefore()
	{
		$response = new DynamicResponse();
		$response = $response->insertElementBefore('insertBeforeId', 'elementId');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"insertElementBefore","insertBeforeId":"insertBeforeId","elementId":"elementId"}]', $output);
	}

	public function testInsertHtml()
	{
		$response = new DynamicResponse();
		$response = $response->insertHtml('elementId', '<div>Content</div>');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"insertHtml","elementId":"elementId","content":"<div>Content<\/div>"}]', $output);
	}

	public function testInsertHtmlAfter()
	{
		$response = new DynamicResponse();
		$response = $response->insertHtmlAfter('insertAfterId', '<div>Content</div>');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"insertHtmlAfter","insertAfterId":"insertAfterId","content":"<div>Content<\/div>"}]', $output);
	}

	public function testInsertHtmlBefore()
	{
		$response = new DynamicResponse();
		$response = $response->insertHtmlBefore('insertBeforeId', '<div>Content</div>');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"insertHtmlBefore","insertBeforeId":"insertBeforeId","content":"<div>Content<\/div>"}]', $output);
	}

	public function testOpenUrl()
	{
		$response = new DynamicResponse();
		$response = $response->openUrl('https://www.kde.org/');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"openUrl","url":"https:\/\/www.kde.org\/"}]', $output);
	}

	public function testPrompt()
	{
		$response = new DynamicResponse();
		$response = $response->prompt('Input something.', 'promptHandler', 'defaultValue');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"prompt","message":"Input something.","handlerFunction":"promptHandler","defaultValue":"defaultValue"}]', $output);
	}

	public function testReloadPage()
	{
		$response = new DynamicResponse();
		$response = $response->reloadPage();
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"reloadPage"}]', $output);
	}

	public function testReloadUrl()
	{
		$response = new DynamicResponse();
		$response = $response->reloadUrl();
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"reloadUrl"}]', $output);
	}

	public function testReplace()
	{
		$response = new DynamicResponse();
		$response = $response->replace('elementId', 'replacementId');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"replace","elementId":"elementId","replacementId":"replacementId"}]', $output);
	}

	public function testReplaceWithHtml()
	{
		$response = new DynamicResponse();
		$response = $response->replaceWithHtml('elementId', '<div>Content</div>');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"replaceWithHtml","elementId":"elementId","content":"<div>Content<\/div>"}]', $output);
	}

	public function testRunFunction()
	{
		$response = new DynamicResponse();
		$response = $response->runFunction('someFunction');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"runFunction","function":"someFunction"}]', $output);
	}

	public function testSet()
	{
		$response = new DynamicResponse();
		$response = $response->set('elementId', 'index', 'value');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"set","elementId":"elementId","index":"index","value":"value"}]', $output);
	}

	public function testSetHtml()
	{
		$response = new DynamicResponse();
		$response = $response->setHtml('elementId', '<div>Content</div>');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"setHtml","elementId":"elementId","content":"<div>Content<\/div>"}]', $output);
	}

	public function testSetVariable()
	{
		$response = new DynamicResponse();
		$response = $response->setVariable('variable', 'content');
		$this->assertInstanceOf(DynamicResponse::class, $response);
		$output = $response->toJson();
		$this->assertIsString($output);
		$this->assertSame('[{"command":"setVariable","variable":"variable","content":"content"}]', $output);
	}
}
