<?php

function tp_read($pFile = '')
{
	global $_SERVER;
	global $DOCUMENT_ROOT;

	global $TEMPLATE_VAR;
	global $TEMPLATE_CONTENT;
	global $TEMPLATE_IS_PARSE;
	global $TEMPLATE_CONTENT_DATA;
	global $TEMPLATE_RESULT;
	global $TEMPLATE_PARENT;

	if ($pFile == '')
	{
		//$filename = $DOCUMENT_ROOT . "/template/main" . str_replace(".php", ".htm", $PHP_SELF);
		// $filename = "form/" . str_replace(".php", ".htm", basename($PHP_SELF));
		$filename = str_replace('.php', '.html', basename($_SERVER["PHP_SELF"]));
	}
	else
	{
		$filename = $pFile;
	}

	$TEMPLATE_VAR = null;
	$TEMPLATE_CONTENT = null;
	$TEMPLATE_IS_PARSE = null;
	$TEMPLATE_CONTENT_DATA = null;
	$TEMPLATE_RESULT = null;
	$TEMPLATE_PARENT = null;

	$TEMPLATE_CONTENT["main"] = @file_get_contents($filename);
}
function tp_read_var($pFileContent)
{
	global $PHP_SELF;
	global $DOCUMENT_ROOT;

	global $TEMPLATE_VAR;
	global $TEMPLATE_CONTENT;
	global $TEMPLATE_IS_PARSE;
	global $TEMPLATE_CONTENT_DATA;
	global $TEMPLATE_RESULT;
	global $TEMPLATE_PARENT;

	$TEMPLATE_VAR = null;
	$TEMPLATE_CONTENT = null;
	$TEMPLATE_IS_PARSE = null;
	$TEMPLATE_CONTENT_DATA = null;
	$TEMPLATE_RESULT = null;
	$TEMPLATE_PARENT = null;

	$TEMPLATE_CONTENT["main"] = $pFileContent;
}

function tp_replace($pName, $pContent)
{
	global $TEMPLATE_CONTENT;

	$TEMPLATE_CONTENT = str_replace('{'.$pName.'}', $pContent, $TEMPLATE_CONTENT);
}

function tp_set($pName, $pVarName = "", $pValue = "#@NO@#")
{
	global $TEMPLATE_VAR;

	if (is_array($pVarName))
		foreach($pVarName as $pKey => $pValue)
			$TEMPLATE_VAR[$pName][$pKey] = $pValue;
	else if (is_array($pName))
	{
		foreach($pName as $pKey => $pValue)
			$TEMPLATE_VAR["main"][$pKey] = $pValue;
	}
	else if ($pValue == "#@NO@#")
		$TEMPLATE_VAR["main"][$pName] = $pVarName;
	else
		$TEMPLATE_VAR[$pName][$pVarName] = $pValue;
}

function tp_set_array($a)
{
	tp_set($a);
}

function tp_set_dynamic($a, $b, $c)
{
	tp_set($a, $b, $c);
}

function tp_set_dynamic_array($a, $b)
{
	tp_set($a, $b);
}

function tp_start_dynamic($pName, $pParent = "main")
{
	tp_dynamic($pName, $pParent);
}

function tp_end_dynamic($pName)
{
}

function tp_parse_dynamic($pName)
{
	tp_parse($pName);
}

function tp_dynamic($pName, $pParent = "main")
{
	global $TEMPLATE_VAR;
	global $TEMPLATE_DATA;
	global $TEMPLATE_PARENT;
	global $TEMPLATE_CONTENT;
	global $TEMPLATE_RESULT;

	//$TEMPLATE_VAR[$pParent][$pName] = array();
	$TEMPLATE_DATA[$pName] = &$TEMPLATE_DATA[$pParent][$pName];
	$TEMPLATE_PARENT[$pName] = $pParent;

	if (!$TEMPLATE_CONTENT[$pName])
	{
		$temp = explode('<!-- LOOP START '.$pName.' -->', $TEMPLATE_CONTENT[$pParent]);
		$head = $temp[0];
		$temp = explode('<!-- LOOP END '.$pName.' -->', $temp[1]);
		$content = $temp[0];
		$tail = $temp[1];

		/*
		 $temp = explode('<!-- LOOP '.$pName.' -->', $TEMPLATE_CONTENT[$pParent]);
		 $head = $temp[0];
		 $content = $temp[1];
		 $tail = $temp[2];
		*/

		$TEMPLATE_CONTENT[$pParent] = $head . '{'.$pName.'}' . $tail;

		$TEMPLATE_CONTENT[$pName] = $content;
	}

	//$TEMPLATE_RESULT[$pName] = "";

}

function tp_dynamic_replace($pName, $pContent, $pParent = "main")
{
	global $TEMPLATE_VAR;
	global $TEMPLATE_DATA;
	global $TEMPLATE_PARENT;
	global $TEMPLATE_CONTENT;
	global $TEMPLATE_RESULT;

	//$TEMPLATE_VAR[$pParent][$pName] = array();
	//$TEMPLATE_DATA[$pName] = &$TEMPLATE_DATA[$pParent][$pName];
	//$TEMPLATE_PARENT[$pName] = $pParent;

	if (!$TEMPLATE_CONTENT[$pName])
	{
		$temp = explode('<!-- LOOP START '.$pName.' -->', $TEMPLATE_CONTENT[$pParent]);
		$head = $temp[0];
		$temp = explode('<!-- LOOP END '.$pName.' -->', $temp[1]);
		$content = $temp[0];
		$tail = $temp[1];

		/*
		 $temp = explode('<!-- LOOP '.$pName.' -->', $TEMPLATE_CONTENT[$pParent]);
		 $head = $temp[0];
		 $content = $temp[1];
		 $tail = $temp[2];
		*/
		if($tail)
			$TEMPLATE_CONTENT[$pParent] = $head . $pContent . $tail;

		//$TEMPLATE_CONTENT[$pName] = $content;
	}

	//$TEMPLATE_RESULT[$pName] = "";
}

function tp_dynamic_replace_file($pName, $filename, $pParent = "main")
{
	global $TEMPLATE_VAR;
	global $TEMPLATE_DATA;
	global $TEMPLATE_PARENT;
	global $TEMPLATE_CONTENT;
	global $TEMPLATE_RESULT;

	//$TEMPLATE_VAR[$pParent][$pName] = array();
	//$TEMPLATE_DATA[$pName] = &$TEMPLATE_DATA[$pParent][$pName];
	//$TEMPLATE_PARENT[$pName] = $pParent;

	if (!$TEMPLATE_CONTENT[$pName])
	{
		$temp = explode('<!-- LOOP START '.$pName.' -->', $TEMPLATE_CONTENT[$pParent]);
		$head = $temp[0];
		$temp = explode('<!-- LOOP END '.$pName.' -->', $temp[1]);
		$content = $temp[0];
		$tail = $temp[1];

		/*
		 $temp = explode('<!-- LOOP '.$pName.' -->', $TEMPLATE_CONTENT[$pParent]);
		 $head = $temp[0];
		 $content = $temp[1];
		 $tail = $temp[2];
		*/
		if($tail)
			$TEMPLATE_CONTENT[$pParent] = $head . file_get_contents($filename) . $tail;

		//$TEMPLATE_CONTENT[$pName] = $content;
	}

	//$TEMPLATE_RESULT[$pName] = "";
}

function tp_parse($pName = "")
{
	global $TEMPLATE_VAR;
	global $TEMPLATE_CONTENT;
	global $TEMPLATE_IS_PARSE;
	global $TEMPLATE_CONTENT_DATA;
	global $TEMPLATE_RESULT;
	global $TEMPLATE_PARENT;

	if ($pName == "")
	{
		$temp = explode('{', $TEMPLATE_CONTENT["main"]);

		$data[] = $temp[0];
		$count = count($temp);
		for($i = 1; $i < $count; $i++)
		{
			$temp2 = explode('}', $temp[$i], 2);

			if (preg_match('/^[a-z0-9_-]+$/i', $temp2[0]))
			{
				$data[] = $temp2[0];
				$data[] = $temp2[1];
			}
			else
			{
				$data[] = '';
				$data[] = '{'.$temp[$i];
			}
		}

		$TEMPLATE_CONTENT["main"] = '';
		$count = count($data);
		for($i = 0; $i < $count; $i+=2)
		{
			$TEMPLATE_CONTENT["main"] .= $data[$i];
			if (is_array($TEMPLATE_VAR["main"][$data[$i+1]]))
				$TEMPLATE_CONTENT["main"] .=  implode("", $TEMPLATE_VAR["main"][$data[$i+1]]);
			else
				$TEMPLATE_CONTENT["main"] .= $TEMPLATE_VAR["main"][$data[$i+1]];
		}
	}
	else
	{

		if (!$TEMPLATE_IS_PARSE[$pName])
		{
			$content = $TEMPLATE_CONTENT[$pName];

			$temp = explode('{', $content);

			$TEMPLATE_CONTENT_DATA[$pName][] = $temp[0];
			$count = count($temp);
			for($i = 1; $i < $count; $i++)
			{
				$temp2 = explode('}', $temp[$i], 2);

				if (preg_match('/^[-_a-zA-Z0-9]+$/i', $temp2[0]))
				{
					$TEMPLATE_CONTENT_DATA[$pName][] = $temp2[0];
					$TEMPLATE_CONTENT_DATA[$pName][] = $temp2[1];
				}
				else
				{
					$TEMPLATE_CONTENT_DATA[$pName][] = $temp2[0];
					$TEMPLATE_CONTENT_DATA[$pName][] = '{'.$temp[$i];
				}
			}


			$TEMPLATE_IS_PARSE[$pName] = true;

		}

		$count = count($TEMPLATE_CONTENT_DATA[$pName]);

		for($i = 0; $i < $count; $i+=2)
		{
			$result .= $TEMPLATE_CONTENT_DATA[$pName][$i];

			if (is_array($TEMPLATE_VAR[$pName][$TEMPLATE_CONTENT_DATA[$pName][$i+1]]))
			{
				$result .= implode("", $TEMPLATE_VAR[$pName][$TEMPLATE_CONTENT_DATA[$pName][$i+1]]);
				$TEMPLATE_VAR[$pName][$TEMPLATE_CONTENT_DATA[$pName][$i+1]] = null;
			}
			else

				$result .= $TEMPLATE_VAR[$pName][$TEMPLATE_CONTENT_DATA[$pName][$i+1]];
		}

		$TEMPLATE_VAR[$TEMPLATE_PARENT[$pName]][$pName][] = $result;

	}
}

function tp_get($pName = "")
{
	global $TEMPLATE_CONTENT;

	return $TEMPLATE_CONTENT[$pName];
}

function tp_fetch()
{
	global $TEMPLATE_CONTENT;

	tp_parse();
	return $TEMPLATE_CONTENT["main"];
}
function tp_print()
{
	echo tp_fetch();
}

function tp_file($pFile = '')
{
	tp_read($pFile);
	tp_print();
}

function tp_check_dynamic($template, $value)
{
	tp_dynamic($template);
	if ($value)
		tp_parse($template);
}

function tp_explode($pName)
{
	global $TEMPLATE_CONTENT;
	$temp = explode('<!-- LOOP START '.$pName.' -->', $TEMPLATE_CONTENT["main"]);
	$head = $temp[0];
	$temp = explode('<!-- LOOP END '.$pName.' -->', $temp[1]);
	$content = $temp[0];
	$tail = $temp[1];


	$TEMPLATE_CONTENT["main"] = '<!-- LOOP START '.$pName." -->\n" . $content . '<!-- LOOP END '.$pName.' -->';
}

function tp_add_content($content)
{
	global $TEMPLATE_CONTENT;
	$TEMPLATE_CONTENT["main"] .= $content;
}
function tp_add_content_head($content)
{
	global $TEMPLATE_CONTENT;
	$TEMPLATE_CONTENT["main"] = $content.$TEMPLATE_CONTENT["main"];
}

function tp_stripscript()
{
	global $TEMPLATE_CONTENT;

	$TEMPLATE_CONTENT["main"] = stripscript($TEMPLATE_CONTENT["main"]);
}
function tp_restore($pKey)
{
	tp_set($pKey, '{'.$pKey.'}');
}

function tp_parse_inline($template, $pValue)
{
	if (is_array($pValue))
		foreach($pValue as $key => $value)
			$template = str_replace('{'.$key.'}', $value, $template);

	return $template;
}

function tp_parse_content($pName, $content)
{
	global $TEMPLATE_VAR;
	global $TEMPLATE_CONTENT;
	global $TEMPLATE_IS_PARSE;
	global $TEMPLATE_CONTENT_DATA;
	global $TEMPLATE_RESULT;
	global $TEMPLATE_PARENT;

	$TEMPLATE_VAR[$TEMPLATE_PARENT[$pName]][$pName][] = $content;
}

?>
