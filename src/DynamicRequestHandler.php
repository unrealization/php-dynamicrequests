<?php
declare(strict_types=1);
/**
 * @package PHPClassCollection
 * @subpackage DynamicRequests
 * @link http://php-classes.sourceforge.net/ PHP Class Collection
 * @author Dennis Wronka <reptiler@users.sourceforge.net>
 */
namespace unrealization;
/**
 * @package PHPClassCollection
 * @subpackage DynamicRequests
 * @link http://php-classes.sourceforge.net/ PHP Class Collection
 * @author Dennis Wronka <reptiler@users.sourceforge.net>
 * @version 5.99.0
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL 2.1
 */
class DynamicRequestHandler
{
	/**
	 * The list of functions registered to handle dynamic calls
	 * @var array
	 */
	private array $dynamicFunctions = array();

	/**
	 * Get an alias for a function name
	 * @param callable $function
	 * @return string
	 */
	private function getFunctionAlias(callable $function): string
	{
		if (is_array($function))
		{
			return $function[1];
		}

		$alias = preg_replace('@^(?|(?|.+)(?|::|\\\))?([^\(]+)$@', '\\1', $function);
		return $alias;
	}

	/**
	 * Register a function to handle dynamic calls
	 * @param callable $function
	 * @throws \Exception
	 * @return DynamicRequestHandler
	 */
	public function addFunction(callable $function): DynamicRequestHandler
	{
		$alias = $this->getFunctionAlias($function);

		if (isset($this->dynamicFunctions[$alias]))
		{
			throw new \Exception('The alias '.$alias.' is taken already.');
		}

		$this->dynamicFunctions[$alias] = $function;
		return $this;
	}

	/**
	 * Process a dynamic request
	 * @param bool $output
	 * @throws \Exception
	 * @return string
	 */
	public function process(bool $output = true): string
	{
		if (empty($_POST['dynamicCall']))
		{
			return '';
		}

		$dynamicCall = json_decode($_POST['dynamicCall']);

		if (empty($dynamicCall->functionName))
		{
			throw new \Exception('No function name.');
		}

		$parameters = array();

		if (!empty($dynamicCall->parameters))
		{
			if (is_array($dynamicCall->parameters))
			{
				$parameters = $dynamicCall->parameters;
			}
			elseif (is_object($dynamicCall->parameters))
			{
				foreach ($dynamicCall->parameters as $key => $value)
				{
					$parameters[$key] = $value;
				}
			}
			else
			{
				$parameters = array($dynamicCall->parameters);
			}
		}

		if (!array_key_exists($dynamicCall->functionName, $this->dynamicFunctions))
		{
			throw new \Exception('Dynamic call '.$dynamicCall->functionName.' is not registered');
		}

		$functionName = $this->dynamicFunctions[$dynamicCall->functionName];

		if (!is_callable($functionName))
		{
			throw new \Exception('Dynamic call '.$functionName.' does not exist.');
		}

		$response = $functionName($parameters);

		if (!($response instanceof DynamicResponse))
		{
			throw new \Exception('Dynamic call '.$functionName.' did not return a DynamicResponse object.');
		}

		$jsonResponse = $response->toJson();

		if ($output == true)
		{
			echo $jsonResponse;
		}

		return $jsonResponse;
	}

	/**
	 * Get the JavaScript code needed to execute dynamic calls on the client side
	 * @param string $url
	 * @param string $prefix
	 * @param string $metaTokenTagName
	 * @param string $metaTokenSendName
	 * @return string
	 */
	public function getJavaScript(string $url, string $prefix = '', ?string $metaTokenTagName = null, ?string $metaTokenSendName = null): string
	{
		$output = '';
		$aliasList = array_keys($this->dynamicFunctions);

		foreach ($aliasList as $alias)
		{
			$output .= 'function '.$prefix.$alias.'(params, async) { new DynamicRequest(\''.$url.'\', \''.$alias.'\', params, async';

			if (!is_null($metaTokenTagName))
			{
				$output .= ', \''.$metaTokenTagName.'\'';
			}

			if (!is_null($metaTokenSendName))
			{
				$output .= ', \''.$metaTokenSendName.'\'';
			}

			$output .= '); }'.PHP_EOL;
		}

		return $output;
	}
}
