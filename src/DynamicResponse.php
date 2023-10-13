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
 * @version 3.0.0-beta-2.99.2
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
	 * @return void
	 */
	public function output(): void
	{
		echo $this->toJson();
	}

	/**
	 * Add a CSS class to an element
	 * @param string $elementId
	 * @param string $className
	 * @return DynamicResponse
	 */
	public function addClass(string $elementId, string $className): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'addClass',
			'elementId'	=> $elementId,
			'className'	=> $className
		);
		return $this;
	}

	/**
	 * Append an element to another element
	 * @param string $parentId
	 * @param string $elementId
	 * @return DynamicResponse
	 */
	public function addElement(?string $parentId, string $elementId): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'addElement',
			'parentId'	=> $parentId,
			'elementId'	=> $elementId
		);
		return $this;
	}

	/**
	 * Append raw HTML to an element
	 * @param string $elementId
	 * @param string $content
	 * @return DynamicResponse
	 */
	public function addHtml(?string $elementId, string $content): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'addHtml',
			'elementId'	=> $elementId,
			'content'	=> $content
		);
		return $this;
	}

	/**
	 * Append plain text to an element
	 * @param string $elementId
	 * @param string $content
	 * @return DynamicResponse
	 */
	public function addText(?string $elementId, string $content): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'addText',
			'elementId'	=> $elementId,
			'content'	=> $content
		);
		return $this;
	}

	/**
	 * Display an alert message
	 * @param string $message
	 * @return DynamicResponse
	 */
	public function alert(string $message): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'alert',
			'message'	=> $message
		);
		return $this;
	}

	/**
	 * Simulate a click onto an element
	 * @param string $elementId
	 * @return DynamicResponse
	 */
	public function click(?string $elementId): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'click',
			'elementId'	=> $elementId
		);
		return $this;
	}

	/**
	 * Display a confirmation window
	 * @param string $message
	 * @param string $handlerFunction
	 * @return DynamicResponse
	 */
	public function confirm(string $message, string $handlerFunction): DynamicResponse
	{
		$this->commands[] = array(
			'command'			=> 'confirm',
			'message'			=> $message,
			'handlerFunction'	=> $handlerFunction
		);
		return $this;
	}

	/**
	 * Create a new element in memory
	 * @param string $elementType
	 * @param string $elementId
	 * @return DynamicResponse
	 */
	public function createElement(string $elementType, string $elementId): DynamicResponse
	{
		$this->commands[] = array(
			'command'		=> 'createElement',
			'elementType'	=> $elementType,
			'elementId'		=> $elementId
		);
		return $this;
	}

	/**
	 * Delete an element
	 * @param string $elementId
	 * @return DynamicResponse
	 */
	public function deleteElement(string $elementId): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'deleteElement',
			'elementId'	=> $elementId
		);
		return $this;
	}

	/**
	 * Send a file to the client for download
	 * @param string $fileName
	 * @param string $content
	 * @param string $mimeType
	 * @param string $encoding
	 * @return DynamicResponse
	 */
	public function downloadFile(string $fileName, string $content, string $mimeType, string $encoding = 'UTF-8'): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'downloadFile',
			'fileName'	=> $fileName,
			'content'	=> base64_encode($content),
			'mimeType'	=> $mimeType,
			'encoding'	=> $encoding
		);
		return $this;
	}

	/**
	 * Insert an element into another element
	 * @param string $parentId
	 * @param string $elementId
	 * @return DynamicResponse
	 */
	public function insertElement(?string $parentId, string $elementId): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'insertElement',
			'parentId'	=> $parentId,
			'elementId'	=> $elementId
		);
		return $this;
	}

	/**
	 * Insert an element after another element
	 * @param string $insertAfterId
	 * @param string $elementId
	 * @return DynamicResponse
	 */
	public function insertElementAfter(string $insertAfterId, string $elementId): DynamicResponse
	{
		$this->commands[] = array(
			'command'		=> 'insertElementAfter',
			'insertAfterId'	=> $insertAfterId,
			'elementId'		=> $elementId
		);
		return $this;
	}

	/**
	 * Insert an element before another element
	 * @param string $insertBeforeId
	 * @param string $elementId
	 * @return DynamicResponse
	 */
	public function insertElementBefore(string $insertBeforeId, string $elementId): DynamicResponse
	{
		$this->commands[] = array(
			'command'			=> 'insertElementBefore',
			'insertBeforeId'	=> $insertBeforeId,
			'elementId'			=> $elementId
		);
		return $this;
	}

	/**
	 * Insert raw HTML into an element
	 * @param string $elementId
	 * @param string $content
	 * @return DynamicResponse
	 */
	public function insertHtml(?string $elementId, string $content): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'insertHtml',
			'elementId'	=> $elementId,
			'content'	=> $content
		);
		return $this;
	}

	/**
	 * Insert raw HTML after an element
	 * @param string $insertAfterId
	 * @param string $content
	 * @return DynamicResponse
	 */
	public function insertHtmlAfter(string $insertAfterId, string $content): DynamicResponse
	{
		$this->commands[] = array(
			'command'		=> 'insertHtmlAfter',
			'insertAfterId'	=> $insertAfterId,
			'content'		=> $content
		);
		return $this;
	}

	/**
	 * Insert raw HTML before an element
	 * @param string $insertBeforeId
	 * @param string $content
	 * @return DynamicResponse
	 */
	public function insertHtmlBefore(string $insertBeforeId, string $content): DynamicResponse
	{
		$this->commands[] = array(
			'command'			=> 'insertHtmlBefore',
			'insertBeforeId'	=> $insertBeforeId,
			'content'			=> $content
		);
		return $this;
	}

	/**
	 * Open a URL
	 * @param string $url
	 * @return DynamicResponse
	 */
	public function openUrl(string $url): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'openUrl',
			'url'		=> $url
		);
		return $this;
	}

	/**
	 * Display a prompt window
	 * @param string $message
	 * @param string $handlerFunction
	 * @param string $defaultValue
	 * @return DynamicResponse
	 */
	public function prompt(string $message, string $handlerFunction, string $defaultValue = ''): DynamicResponse
	{
		$this->commands[] = array(
			'command'			=> 'prompt',
			'message'			=> $message,
			'handlerFunction'	=> $handlerFunction,
			'defaultValue'		=> $defaultValue
		);
		return $this;
	}

	/**
	 * Reload the current page. May re-send POST variables.
	 * @return DynamicResponse
	 */
	public function reloadPage(): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'reloadPage'
		);
		return $this;
	}

	/**
	 * Reload the current URL. Will not re-send POST variables.
	 * @return DynamicResponse
	 */
	public function reloadUrl(): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'reloadUrl'
		);
		return $this;
	}

	/**
	 * Remove a CSS class from an element
	 * @param string $elementId
	 * @param string $className
	 * @return DynamicResponse
	 */
	public function removeClass(string $elementId, string $className): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'removeClass',
			'elementId'	=> $elementId,
			'className'	=> $className
		);
		return $this;
	}

	/**
	 * Replace an element
	 * @param string $elementId
	 * @param string $replacementId
	 * @return DynamicResponse
	 */
	public function replace(string $elementId, string $replacementId): DynamicResponse
	{
		$this->commands[] = array(
			'command'		=> 'replace',
			'elementId'		=> $elementId,
			'replacementId'	=> $replacementId
		);
		return $this;
	}

	/**
	 * Replace an element with raw HTML
	 * @param string $elementId
	 * @param string $content
	 * @return DynamicResponse
	 */
	public function replaceWithHtml(string $elementId, string $content): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'replaceWithHtml',
			'elementId'	=> $elementId,
			'content'	=> $content
		);
		return $this;
	}

	/**
	 * Call a function
	 * @param string $function
	 * @return DynamicResponse
	 */
	public function runFunction(string $function): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'runFunction',
			'function'	=> $function
		);
		return $this;
	}

	/**
	 * Set an element's property
	 * @param string $elementId
	 * @param string $index
	 * @param string $value
	 * @return DynamicResponse
	 */
	public function set(?string $elementId, string $index, string $value): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'set',
			'elementId'	=> $elementId,
			'index'		=> $index,
			'value'		=> $value
		);
		return $this;
	}

	/**
	 * Set an element's raw HTML content
	 * @param string $elementId
	 * @param string $content
	 * @return DynamicResponse
	 */
	public function setHtml(?string $elementId, string $content): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'setHtml',
			'elementId'	=> $elementId,
			'content'	=> $content
		);
		return $this;
	}

	/**
	 * Set a variable
	 * @param string $variable
	 * @param string $content
	 * @return DynamicResponse
	 */
	public function setVariable(string $variable, string $content): DynamicResponse
	{
		$this->commands[] = array(
			'command'	=> 'setVariable',
			'variable'	=> $variable,
			'content'	=> $content
		);
		return $this;
	}
}
?>