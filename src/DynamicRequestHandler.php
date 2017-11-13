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
 * @version 0.9.0
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL 2.1
 */
class DynamicRequestHandler
{
	private $dynamicFunctions = array();

	private function getFunctionAlias(string $function, bool $classless): string
	{
		$matches = array();

		if (preg_match('@^(.+)(?|->|::)(.+)$@U', $function, $matches))
		{
			if ($classless == true)
			{
				return $matches[2];
			}

			return $matches[1].'_'.$matches[2];
		}

		return $function;
	}

	private function findFunction(string $function): bool
	{
		$className = '';
		$matches = array();

		if (preg_match('@^(.+)(?|->|::)(.+)$@U', $function, $matches))
		{
			$className = $matches[1];
			$function = $matches[2];
		}

		if (empty($className))
		{
			return function_exists($function);
		}
		else
		{
			return is_callable(array($className, $function));
		}
	}

	public function addFunction(string $function, bool $classlessAlias = true)
	{
		if (!$this->findFunction($function))
		{
			throw new \Exception('Dynamic call '.$function.' does not exist.');
		}

		$alias = $this->getFunctionAlias($function, $classlessAlias);

		if (isset($this->dynamicFunctions[$alias]))
		{
			throw new \Exception('The alias '.$alias.' is taken already.');
		}

		$this->dynamicFunctions[$alias] = $function;
	}

	public function process(): bool
	{
		if (empty($_POST['dynamicCall']))
		{
			return false;
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

		if (!$this->findFunction($functionName))
		{
			throw new \Exception('Dynamic call '.$functionName.' does not exist.');
		}

		$response = $functionName($parameters);

		if (!($response instanceof DynamicResponse))
		{
			throw new \Exception('Dynamic call '.$functionName.' did not return a DynamicResponse object.');
		}

		echo $response->output();
		return true;
	}

	public function getJavaScript(string $url, string $metaTokenTagName = null, string $metaTokenSendName = null): string
	{
		$output = '';

		foreach ($this->dynamicFunctions as $alias => $function)
		{
			$output .= 'function '.$alias.'(params) { var request = new DynamicRequest(\''.$url.'\', \''.$alias.'\', params';

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
?>