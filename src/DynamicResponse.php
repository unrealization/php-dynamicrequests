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
 * @version 1.2.1
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL 2.1
 */
class DynamicResponse
{
	/**
	 * The list of commands sent back to the client
	 * @var array
	 */
	private $commands = array();

	/**
	 * Return the command list as JSON
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->toJson();
	}

	/**
	 * Return the command list as JSON
	 * @return string
	 */
	public function toJson(): string
	{
		$jsonData = json_encode($this->commands);
		return $jsonData;
	}

	/**
	 * Output the command list as JSON
	 */
	public function output()
	{
		echo $this->toJson();
	}

	/**
	 * Append an element to another element
	 * @param string $parentId
	 * @param string $elementId
	 */
	public function addElement($parentId, string $elementId)
	{
		$this->commands[] = array(
				'command'	=> 'addElement',
				'parentId'	=> $parentId,
				'elementId'	=> $elementId
		);
	}

	/**
	 * Append raw HTML to an element
	 * @param string $elementId
	 * @param string $content
	 */
	public function addHtml($elementId, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'addHtml',
				'elementId'	=> $elementId,
				'content'	=> $content
		);
	}

	/**
	 * Append plain text to an element
	 * @param string $elementId
	 * @param string $content
	 */
	public function addText($elementId, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'addText',
				'elementId'	=> $elementId,
				'content'	=> $content
		);
	}

	/**
	 * Display an alert message
	 * @param string $message
	 */
	public function alert(string $message)
	{
		$this->commands[] = array(
				'command'	=> 'alert',
				'message'	=> $message
		);
	}

	/**
	 * Simulate a click onto an element
	 * @param string $elementId
	 */
	public function click($elementId)
	{
		$this->commands[] = array(
				'command'	=> 'click',
				'elementId'	=> $elementId
		);
	}

	/**
	 * Display a confirmation window
	 * @param string $message
	 * @param string $handlerFunction
	 */
	public function confirm(string $message, string $handlerFunction)
	{
		$this->commands[] = array(
				'command'			=> 'confirm',
				'message'			=> $message,
				'handlerFunction'	=> $handlerFunction
		);
	}

	/**
	 * Create a new element in memory
	 * @param string $elementType
	 * @param string $elementId
	 */
	public function createElement(string $elementType, string $elementId)
	{
		$this->commands[] = array(
				'command'		=> 'createElement',
				'elementType'	=> $elementType,
				'elementId'		=> $elementId
		);
	}

	/**
	 * Delete an element
	 * @param string $elementId
	 */
	public function deleteElement(string $elementId)
	{
		$this->commands[] = array(
				'command'	=> 'deleteElement',
				'elementId'	=> $elementId
		);
	}

	/**
	 * Send a file to the client for download
	 * @param string $fileName
	 * @param string $content
	 * @param string $mimeType
	 * @param string $encoding
	 */
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

	/**
	 * Insert an element into another element
	 * @param string $parentId
	 * @param string $elementId
	 */
	public function insertElement($parentId, string $elementId)
	{
		$this->commands[] = array(
				'command'	=> 'insertElement',
				'parentId'	=> $parentId,
				'elementId'	=> $elementId
		);
	}

	/**
	 * Insert an element after another element
	 * @param string $insertAfterId
	 * @param string $elementId
	 */
	public function insertElementAfter(string $insertAfterId, string $elementId)
	{
		$this->commands[] = array(
				'command'		=> 'insertElementAfter',
				'insertAfterId'	=> $insertAfterId,
				'elementId'		=> $elementId
		);
	}

	/**
	 * Insert an element before another element
	 * @param string $insertBeforeId
	 * @param string $elementId
	 */
	public function insertElementBefore(string $insertBeforeId, string $elementId)
	{
		$this->commands[] = array(
				'command'			=> 'insertElementBefore',
				'insertBeforeId'	=> $insertBeforeId,
				'elementId'			=> $elementId
		);
	}

	/**
	 * Insert raw HTML into an element
	 * @param string $elementId
	 * @param string $content
	 */
	public function insertHtml($elementId, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'insertHtml',
				'elementId'	=> $elementId,
				'content'	=> $content
		);
	}

	/**
	 * Open a URL
	 * @param string $url
	 */
	public function openUrl(string $url)
	{
		$this->commands[] = array(
				'command'	=> 'openUrl',
				'url'		=> $url
		);
	}

	/**
	 * Display a prompt window
	 * @param string $message
	 * @param string $handlerFunction
	 * @param string $defaultValue
	 */
	public function prompt(string $message, string $handlerFunction, string $defaultValue = '')
	{
		$this->commands[] = array(
				'command'			=> 'prompt',
				'message'			=> $message,
				'handlerFunction'	=> $handlerFunction,
				'defaultValue'		=> $defaultValue
		);
	}

	/**
	 * Replace an element
	 * @param string $elementId
	 * @param string $replacementId
	 */
	public function replace(string $elementId, string $replacementId)
	{
		$this->commands[] = array(
				'command'		=> 'replace',
				'elementId'		=> $elementId,
				'replacementId'	=> $replacementId
		);
	}

	/**
	 * Call a function
	 * @param string $function
	 */
	public function runFunction(string $function)
	{
		$this->commands[] = array(
				'command'	=> 'runFunction',
				'function'	=> $function
		);
	}

	/**
	 * Set an element's property
	 * @param string $elementId
	 * @param string $index
	 * @param string $value
	 */
	public function set($elementId, string $index, string $value)
	{
		$this->commands[] = array(
				'command'	=> 'set',
				'elementId'	=> $elementId,
				'index'		=> $index,
				'value'		=> $value
		);
	}

	/**
	 * Set an element's raw HTML content
	 * @param string $elementId
	 * @param string $content
	 */
	public function setHtml($elementId, string $content)
	{
		$this->commands[] = array(
				'command'	=> 'setHtml',
				'elementId'	=> $elementId,
				'content'	=> $content
		);
	}

	/**
	 * Set a variable
	 * @param string $variable
	 * @param string $content
	 */
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