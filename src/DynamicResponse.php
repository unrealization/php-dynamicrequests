<?php
declare(strict_types=1);
/**
 * @package PHPClassCollection
 * @subpackage DynamicRequests
 * @link http://php-classes.sourceforge.net/ PHP Class Collection
 * @author Dennis Wronka <reptiler@users.sourceforge.net>
 */
namespace unrealization\PHPClassCollection;
/**
 * @package PHPClassCollection
 * @subpackage DynamicRequests
 * @link http://php-classes.sourceforge.net/ PHP Class Collection
 * @author Dennis Wronka <reptiler@users.sourceforge.net>
 * @version 0.9.9
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL 2.1
 */
class DynamicResponse
{
	private $commands = array();

	public function __toString(): string
	{
		$jsonData = $this->output(true);
		return $jsonData;
	}

	public function output(bool $return = false): string
	{
		$jsonData = json_encode($this->commands);

		if ($return == true)
		{
			return $jsonData;
		}

		echo $jsonData;
		return '';
	}

	public function addElement($parentId, string $elementId)
	{
		$this->commands[] = array(
				'command'	=> 'addElement',
				'parentId'	=> $parentId,
				'elementId'	=> $elementId
		);
	}

	public function addHtml(string $elementId, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'addHtml',
				'elementId'	=> $elementId,
				'content'	=> $content
		);
	}

	public function addText(string $elementId, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'addText',
				'elementId'	=> $elementId,
				'content'	=> $content
		);
	}

	public function alert(string $message)
	{
		$this->commands[] = array(
				'command'	=> 'alert',
				'message'	=> $message
		);
	}

	public function click(string $elementId)
	{
		$this->commands[] = array(
				'command'	=> 'click',
				'elementId'	=> $elementId
		);
	}

	public function confirm(string $message, string $handlerFunction)
	{
		$this->commands[] = array(
				'command'			=> 'confirm',
				'message'			=> $message,
				'handlerFunction'	=> $handlerFunction
		);
	}

	public function createElement(string $elementType, string $elementId)
	{
		$this->commands[] = array(
				'command'		=> 'createElement',
				'elementType'	=> $elementType,
				'elementId'		=> $elementId
		);
	}

	public function deleteElement(string $elementId)
	{
		$this->commands[] = array(
				'command'	=> 'deleteElement',
				'elementId'	=> $elementId
		);
	}

	public function downloadFile(string $fileName, string $content, string $mimeType, string $encoding = 'UTF-8')
	{
		$this->commands[] = array(
				'command'	=> 'downloadFile',
				'fileName'	=> $fileName,
				'content'	=> $content,
				'mimeType'	=> $mimeType,
				'encoding'	=> $encoding
		);
	}

	public function insertElement($parentId, string $elementId)
	{
		$this->commands[] = array(
				'command'	=> 'insertElement',
				'parentId'	=> $parentId,
				'elementId'	=> $elementId
		);
	}

	public function insertElementAfter(string $insertAfterId, string $elementId)
	{
		$this->commands[] = array(
				'command'		=> 'insertElementAfter',
				'insertAfterId'	=> $insertAfterId,
				'elementId'		=> $elementId
		);
	}

	public function insertElementBefore(string $insertBeforeId, string $elementId)
	{
		$this->commands[] = array(
				'command'			=> 'insertElementBefore',
				'insertBeforeId'	=> $insertBeforeId,
				'elementId'			=> $elementId
		);
	}

	public function insertHtml(string $elementId, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'insertHtml',
				'elementId'	=> $elementId,
				'content'	=> $content
		);
	}

	public function prompt(string $message, string $handlerFunction, string $defaultValue = '')
	{
		$this->commands[] = array(
				'command'			=> 'prompt',
				'message'			=> $message,
				'handlerFunction'	=> $handlerFunction,
				'defaultValue'		=> $defaultValue
		);
	}

	public function replace(string $replaceId, string $elementId)
	{
		$this->commands[] = array(
				'command'	=> 'replace',
				'replaceId'	=> $replaceId,
				'elementId'	=> $elementId
		);
	}

	public function runFunction(string $function)
	{
		$this->commands[] = array(
				'command'	=> 'runFunction',
				'function'	=> $function
		);
	}

	public function set(string $elementId, string $index, string $value)
	{
		$this->commands[] = array(
				'command'	=> 'set',
				'elementId'	=> $elementId,
				'index'		=> $index,
				'value'		=> $value
		);
	}

	public function setHtml(string $elementId, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'setHtml',
				'elementId'	=> $elementId,
				'content'	=> $content
		);
	}

	public function setVariable(string $variable, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'setVariable',
				'variable'	=> $variable,
				'content'	=> $content
		);
	}
}
?>