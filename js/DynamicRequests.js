function DynamicResponseHandler(jsonData)
{
	this.createdElementPrefix = 'createdElement_';

	this.findElement = function(elementId)
	{
		var regEx = new RegExp('^((mem(ory)?|disp(lay)?):)?(.+)$');
		var parts = elementId.match(regEx);

		if (parts == null)
		{
			return null;
		}

		if (typeof parts[5] == 'undefined')
		{
			return null;
		}

		var element;

		if (typeof parts[2] == 'undefined')
		{
			element = document.getElementById(parts[5]);

			if (element != null)
			{
				return element;
			}

			element = window[this.createdElementPrefix + parts[5]];

			if (typeof element != 'undefined')
			{
				return element;
			}

			return null;
		}
		else if ((parts[2] == 'mem') || (parts[2] == 'memory'))
		{
			element = window[this.createdElementPrefix + parts[5]];

			if (typeof element == 'undefined')
			{
				return null;
			}

			return element;
		}
		else if ((parts[2] == 'disp') || (parts[2] == 'display'))
		{
			element = document.getElementById(parts[5]);

			if (element == null)
			{
				return null;
			}

			return element;
		}

		return null;
	};

	this.htmlToElement = function(content)
	{
		var element = document.createElement('template');
		element.innerHTML = content;
		return element.content.firstChild;
	};

	this.addClass = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.className == 'undefined')
		{
			throw 'className is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		element.classList.add(command.className);
	};

	this.addElement = function(command)
	{
		if (typeof command.parentId == 'undefined')
		{
			throw 'parentId is undefined';
		}

		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		var parentElement;

		if (command.parentId == null)
		{
			parentElement = document.body;
		}
		else
		{
			parentElement = this.findElement(command.parentId);

			if (parentElement == null)
			{
				throw 'parentId is invalid';
			}
		}

		parentElement.appendChild(element);
	};

	this.addHtml = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		var element;

		if (command.elementId == null)
		{
			element = document.body;
		}
		else
		{
			element = this.findElement(command.elementId);

			if (element == null)
			{
				throw 'elementId is invalid';
			}
		}

		element.appendChild(this.htmlToElement(command.content));
	};

	this.addText = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		var element;

		if (command.elementId == null)
		{
			element = document.body;
		}
		else
		{
			element = this.findElement(command.elementId);

			if (element == null)
			{
				throw 'elementId is invalid';
			}
		}

		var textNode = document.createTextNode(command.content);
		element.appendChild(textNode);
	};

	this.alert = function(command)
	{
		if (typeof command.message == 'undefined')
		{
			throw 'message is undefined';
		}

		alert(command.message);
	};

	this.click = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		var element;

		if (command.elementId == null)
		{
			element = document.body;
		}
		else
		{
			element = this.findElement(command.elementId);

			if (element == null)
			{
				throw 'elementId is invalid';
			}
		}

		element.click();
	};

	this.confirm = function(command)
	{
		if (typeof command.message == 'undefined')
		{
			throw 'message is undefined';
		}

		if (typeof command.handlerFunction == 'undefined')
		{
			throw 'handlerFunction is undefined';
		}

		if (typeof window[command.handlerFunction] != 'function')
		{
			throw command.handlerFunction + ' is not a function';
		}

		window[command.handlerFunction](confirm(command.message));
	};

	this.createElement = function(command)
	{
		if (typeof command.elementType == 'undefined')
		{
			throw 'elementType is undefined';
		}

		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		var element = document.createElement(command.elementType);
		element.id = command.elementId;

		window[this.createdElementPrefix + element.id] = element;
	};

	this.deleteElement = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		element.parentNode.removeChild(element);
	};

	this.downloadFile = function(command)
	{
		if (typeof command.fileName == 'undefined')
		{
			throw 'fileName is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		if (typeof command.mimeType == 'undefined')
		{
			throw 'mimeType is undefined';
		}

		if (typeof command.encoding == 'undefined')
		{
			throw 'encoding is undefined';
		}

		var fileBlob = new Blob([atob(command.content)], { type: command.mimeType }));
		var fileUrl = window.URL.createObjectURL(fileBlob);
		var element = document.createElement('a');
		element.href = fileUrl;
		element.download = command.fileName;
		element.style.display = 'none';
		document.body.appendChild(element);
		element.click();
		element.parentNode.removeChild(element);
		window.URL.revokeObjectURL(fileUrl);
	};

	this.insertElement = function(command)
	{
		if (typeof command.parentId == 'undefined')
		{
			throw 'parentId is undefined';
		}

		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		var parentElement;

		if (command.parentId == null)
		{
			parentElement = document.body;
		}
		else
		{
			parentElement = this.findElement(command.parentId);

			if (parentElement == null)
			{
				throw 'parentId is invalid';
			}
		}

		parentElement.insertBefore(element, parentElement.firstChild);
	};

	this.insertElementAfter = function(command)
	{
		if (typeof command.insertAfterId == 'undefined')
		{
			throw 'insertAfterId is undefined';
		}

		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		var insertAfterElement = this.findElement(command.insertAfterId);

		if (insertAfterElement == null)
		{
			throw 'insertAfterId is invalid';
		}

		insertAfterElement.parentNode.insertBefore(element, insertAfterElement.nextSibling);
	};

	this.insertElementBefore = function(command)
	{
		if (typeof command.insertBeforeId == 'undefined')
		{
			throw 'insertBeforeId is undefined';
		}

		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		var insertBeforeElement = this.findElement(command.insertBeforeId);

		if (insertBeforeElement == null)
		{
			throw 'insertBeforeId is invalid';
		}

		insertBeforeElement.parentNode.insertBefore(element, insertBeforeElement);
	};

	this.insertHtml = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		var element;

		if (command.elementId == null)
		{
			element = document.body;
		}
		else
		{
			element = this.findElement(command.elementId);

			if (element == null)
			{
				throw 'elementId is invalid';
			}
		}

		element.insertBefore(this.htmlToElement(command.content), element.firstChild);
	};

	this.insertHtmlAfter = function(command)
	{
		if (typeof command.insertAfterId == 'undefined')
		{
			throw 'insertAfterId is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		var insertAfterElement = this.findElement(command.insertAfterId);

		if (insertAfterElement == null)
		{
			throw 'insertAfterId is invalid';
		}

		insertAfterElement.parentNode.insertBefore(this.htmlToElement(command.content), insertAfterElement.nextSibling);
	};

	this.insertHtmlBefore = function(command)
	{
		if (typeof command.insertBeforeId == 'undefined')
		{
			throw 'insertBeforeId is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		var insertBeforeElement = this.findElement(command.insertBeforeId);

		if (insertBeforeElement == null)
		{
			throw 'insertBeforeId is invalid';
		}

		insertBeforeElement.parentNode.insertBefore(this.htmlToElement(command.content), insertBeforeElement);
	};

	this.openUrl = function(command)
	{
		if (typeof command.url == 'undefined')
		{
			throw 'url is undefined';
		}

		window.location.href = command.url;
	};

	this.prompt = function(command)
	{
		if (typeof command.message == 'undefined')
		{
			throw 'message is undefined';
		}

		if (typeof command.handlerFunction == 'undefined')
		{
			throw 'handlerFunction is undefined';
		}

		if (typeof command.defaultValue == 'undefined')
		{
			throw 'defaultValue is undefined';
		}

		if (typeof window[command.handlerFunction] != 'function')
		{
			throw command.handlerFunction + ' is not a function';
		}

		var defaultValue = '';

		if (typeof command.defaultValue != 'undefined')
		{
			defaultValue = command.defaultValue;
		}

		window[command.handlerFunction](prompt(command.message, defaultValue));
	};

	this.reloadPage = function(command)
	{
		window.location.reload(true);
	};

	this.reloadUrl = function(command)
	{
		window.location.href = window.location.href;
	};

	this.removeClass = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.className == 'undefined')
		{
			throw 'className is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		element.classList.remove(command.className);
	};

	this.replace = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.replacementId == 'undefined')
		{
			throw 'replacementId is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		var replacementElement = this.findElement(command.replacementId);

		if (replacementElement == null)
		{
			throw 'replacementId is invalid';
		}

		element.parentNode.replaceChild(replacementElement, element);
	};

	this.replaceWithHtml = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		var element = this.findElement(command.elementId);

		if (element == null)
		{
			throw 'elementId is invalid';
		}

		element.parentNode.replaceChild(this.htmlToElement(command.content), element);
	};

	this.runFunction = function(command)
	{
		if (typeof command.function == 'undefined')
		{
			throw 'function is undefined';
		}

		if (typeof window[command.function] != 'function')
		{
			throw command.function + ' is not a function';
		}

		window[command.function]();
	};

	this.set = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.index == 'undefined')
		{
			throw 'index is undefined';
		}

		if (typeof command.value == 'undefined')
		{
			throw 'value is undefined';
		}

		var element;

		if (command.elementId == null)
		{
			element = document.body;
		}
		else
		{
			element = this.findElement(command.elementId);

			if (element == null)
			{
				throw 'elementId is invalid';
			}
		}

		var indexList = command.index.split('.');
		var index;

		while (index = indexList.shift())
		{
			if (indexList.length > 0)
			{
				element = element[index];

				if (typeof element == 'undefined')
				{
					throw 'Error';
				}

				continue;
			}

			if (typeof element[index] == 'undefined')
			{
				throw 'Error';
			}

			element[index] = command.value;
		}
	};

	this.setHtml = function(command)
	{
		if (typeof command.elementId == 'undefined')
		{
			throw 'elementId is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		var element;

		if (command.elementId == null)
		{
			element = document.body;
		}
		else
		{
			element = this.findElement(command.elementId);

			if (element == null)
			{
				throw 'elementId is invalid';
			}
		}

		element.innerHTML = command.content;
	};

	this.setVariable = function(command)
	{
		if (typeof command.variable == 'undefined')
		{
			throw 'variable is undefined';
		}

		if (typeof command.content == 'undefined')
		{
			throw 'content is undefined';
		}

		window[command.variable] = command.content;
	};

	for (var commandIndex = 0; commandIndex < jsonData.length; commandIndex++)
	{
		var command = jsonData[commandIndex];

		switch (command.command)
		{
			case 'addClass':
				this.addClass(command);
				break;
			case 'addElement':
				this.addElement(command);
				break;
			case 'addHtml':
				this.addHtml(command);
				break;
			case 'addText':
				this.addText(command);
				break;
			case 'alert':
				this.alert(command);
				break;
			case 'click':
				this.click(command);
				break;
			case 'confirm':
				this.confirm(command);
				break;
			case 'createElement':
				this.createElement(command);
				break;
			case 'deleteElement':
				this.deleteElement(command);
				break;
			case 'downloadFile':
				this.downloadFile(command);
				break;
			case 'insertElement':
				this.insertElement(command);
				break;
			case 'insertElementAfter':
				this.insertElementAfter(command);
				break;
			case 'insertElementBefore':
				this.insertElementBefore(command);
				break;
			case 'insertHtml':
				this.insertHtml(command);
				break;
			case 'insertHtmlAfter':
				this.insertHtmlAfter(command);
				break;
			case 'insertHtmlBefore':
				this.insertHtmlBefore(command);
				break;
			case 'openUrl':
				this.openUrl(command);
				break;
			case 'prompt':
				this.prompt(command);
				break;
			case 'reloadPage':
				this.reloadPage(command);
				break;
			case 'reloadUrl':
				this.reloadUrl(command);
				break;
			case 'removeClass':
				this.removeClass(command);
				break;
			case 'replace':
				this.replace(command);
				break;
			case 'replaceWithHtml':
				this.replaceWithHtml(command);
				break;
			case 'runFunction':
				this.runFunction(command);
				break;
			case 'set':
				this.set(command);
				break;
			case 'setHtml':
				this.setHtml(command);
				break;
			case 'setVariable':
				this.setVariable(command);
				break;
			default:
				throw 'Unknown command: ' + command.command;
				break;
		}
	}
}

function DynamicRequest(url, callFunction, params, async, metaTokenTagName, metaTokenSendName)
{
	this.readyStateListener = function()
	{
		if ((this.readyState == 4) && (this.status == 200))
		{
			try
			{
				var data = JSON.parse(this.responseText);
				new DynamicResponseHandler(data);
			}
			catch (exception)
			{
				throw 'Error: ' + exception;
			}
		}
	};

	this.findMeta = function(name)
	{
		var metaFields = document.getElementsByTagName('meta');

		for (var index = 0; index < metaFields.length; index++)
		{
			if (metaFields[index].name == name)
			{
				return metaFields[index].content;
			}
		}

		return null;
	};

	if (typeof url == 'undefined')
	{
		throw 'url is undefined';
	}

	if (typeof callFunction == 'undefined')
	{
		throw 'callFunction is undefined';
	}

	var parameters = {
			functionName: callFunction,
			parameters: params
	};

	var request = new XMLHttpRequest();
	request.onreadystatechange = this.readyStateListener;

	if (async == false)
	{
		request.open('POST', url, false);
	}
	else
	{
		request.open('POST', url, true);
	}

	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	if (typeof metaTokenTagName == 'undefined')
	{
		request.send('dynamicCall=' + JSON.stringify(parameters));
	}
	else
	{
		var tokenValue = this.findMeta(metaTokenTagName);

		if (typeof metaTokenSendName == 'undefined')
		{
			metaTokenSendName = metaTokenTagName;
		}

		request.send('dynamicCall=' + JSON.stringify(parameters) + '&' + metaTokenSendName + '=' + tokenValue);
	}
}
