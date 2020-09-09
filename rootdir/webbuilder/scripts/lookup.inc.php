<?php
/*
 * this file is part of
 * PHP WebBuilder by Chris van Gorp
 * Version : March 2017
 */
 
function filename_to_url_menuxxx($filename)
{
	$result="";
    $fullPath=constant('ROOTDIR') . '$filename';
	if (file_exists($fullPath))
	{
		$result='<b>Gevonden</b>';
	}
	else
	{
		format_error_message('file ' . $fullPath . ' not found');
	}
	return $result;
}

function lookup_specs($name)
{
	$output=csv2table(constant('ROOTDIR'). "/specifications.csv","***Key***", $name);
	return $output;
}

function lookup_image($name,$width,$height,$caption="yes" )
{
    $matched=false;
	$description="";
	$image_path_prefix=constant('ROOTDIR');
	$filename=constant('ROOTDIR') . "/_images.txt";
	// open file
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		for($i=0;$i<count($lines);$i++)
		{
			$input=$lines[$i];
			$items = explode(",", $input);
			// search for name
			if ($name == $items[0])
			{
				// get attributes
				$description=$items[1];
				$image_path=$image_path_prefix . "/" . $items[2];
				$matched=true;
				break;
			}
		}
		if  ($matched == true)
		{
			if (! file_exists($image_path))
			{
				$html= format_error_message('The path is not found : ' . $image_path . ' please check spelling.') . PHP_EOL; 
			}
			else
			{
				// format HTML
				if ($width=="" and $height=="")
				{
					$style=' class="img-fluid"';
				}
				elseif ($width=="" and $height!="")
				{
					$style=' style="height:' . $height . 'px;"';
				}
				elseif ($width!="" and $height=="")
				{
					$style=' style="width:' . $width . 'px;"';
				}
				else
				{
					$style=' style="width:' . $width . 'px;height:' . $height . 'px;"';
				}
			    if ($caption == "yes")
				{
					$html='<figure><img src="' . $image_path . '"' . $style . ' alt="' . $description . '"/><figcaption>' . $description . '</figcaption></figure>';
				}
				else
				{
			//		$html='<a title="' . $description . '" ' . '><img src="' . $image_path . '"' . $style . ' border="0" alt="' . $description . '"></a>'; 
					//$html='<div class="container-fluid"><img src="' . $image_path . '"' . $style . ' alt="' . $description . '"></div>'; 
					$html='<img src="' . $image_path . '"' . $style . ' alt="' . $description . '">'; 
				}
			}

		}
		else
		{
			$html=format_error_message('entry ' . $name . ' not found in _images.txt');
		}
	}
	else
	{
		$html=format_error_message('lookup_image() : file _images.txt not found');
	}
	return $html;
}


function lookup_image_url($name,$width,$height,$caption="yes", $url="" )
{
	//echo 'name = ' . $name . ' width=' . $width . ' height=' . $height . ' caption=' . $caption . 'url=' . $url;
	$description="";
	$image_path="";
	$filename=constant('ROOTDIR') . "/_images.txt";
	// open file
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		for($i=0;$i<count($lines);$i++)
		{
			$input=$lines[$i];
			$items = explode(",", $input);
			// search for name
			if ($name == $items[0])
			{
				// get attributes
				$description=$items[1];
				$image_path=$items[2];
				break;
			}
		}
	}
	else
	{
		echo format_error_message("lookup_image() : file not found");
	}
	// format HTML
	if ($width=="" and $height=="")
	{
		$style="";
	}
	elseif ($width=="" and $height!="")
	{
		$style=' style="height:' . $height . 'px;"';
	}
	elseif ($width!="" and $height=="")
	{
		$style=' style="width:' . $width . 'px;"';
	}
	else
	{
		$style=' style="width:' . $width . 'px;height:' . $height . 'px;"';
	}
	if (substr(strtolower($url),0,8) == "https://")
	{
		$target=' target="_blank"';
	}
	else
	{
		$target="";
	}
	if ($url != "")
	{
		if ($caption == "yes")
		{
			$html='<a href="' . $url . '"' . $target . '>';
			$html.='<figure><img src="' . $image_path . '"' . $style . ' alt="' . $description . '"/><figcaption>' . $description . '</figcaption></figure>';
			$html.='</a>';
		}
		else
		{
			$html='<a href="' . $url . '"' . $target ;
			$html.=' title="' . $description . '" ' . '><img src="' . $image_path . '"' . $style . ' border="0" alt="' . $description . '"></a>'; 
			$html.='</a>';
		}
	}
	else
	{
		if ($caption == "yes")
		{
			$html='<figure><img src="' . $image_path . '"' . $style . ' alt="' . $description . '"/><figcaption>' . $description . '</figcaption></figure>';
		}
		else
		{
			$html='<a title="' . $description . '" ' . '><img src="' . $image_path . '"' . $style . ' border="0" alt="' . $description . '"></a>'; 
		}
	}
	return $html;
}

function lookup_link_url($input)
{
	$description="";
	$image_path="";
	$filename=constant('ROOTDIR') . "/_links.txt";
	$search_string=$input;
	$search_length=strlen($input);
	$url="";
	// open file
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		for($i=0;$i<count($lines);$i++)
		{
			$input=$lines[$i];
			$items = explode(";", $input);
			// search for name
			if ($search_string == $items[0])
			{
				$url=$items[1];
				$description=$items[2];
				break;
			}
		}
	}
	else
	{
		echo format_error_message("lookup_url() : file not found");
	}
    return $url;
}

function lookup_url($input)
{
	$description="";
	$image_path="";
	$filename=constant('ROOTDIR') . "/_links.txt";
	$wilcard=false;
	$wilcard_char="*";
	$StartPos=strpos($input,$wilcard_char);
	if ($StartPos !== false)
	{
		$wildcard=true;
		$search_string=substr($input,0,$StartPos);
		$search_length=$StartPos;
	}
	else
	{
		$wildcard=false;
		$search_string=$input;
		$search_length=strlen($input);
	}
	$html="";
	// open file
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		for($i=0;$i<count($lines);$i++)
		{
			$input=$lines[$i];
			$items = explode(";", $input);
			// search for name
			if ($wildcard == true)
			{
				$to_match=substr($items[0],0,$search_length);
				if ($search_string == $to_match)
				{
					$url=$items[1];
					$description=$items[2];
					$html.='<a href="' . $url . '" target="_blank">' . $description . '</a><br>'; 
				}
			}
			else
			{
				if ($search_string == $items[0])
				{
					$url=$items[1];
					$description=$items[2];
					$html='<a href="' . $url . '" target="_blank">' . $description . '</a>'; 
					break;
				}
			}
		}
	}
	else
	{
		echo format_error_message("lookup_url() : file not found");
	}
    return $html;
}


function csv2table($filename, $key, $value, $header=false)
{
//	echo 'Key = ' . $key . ', value = ' . $value;
	$result="";
	$started=false;
	$row = 1;
	if (($handle = fopen(constant('ROOTDIR') . "/_specificaties.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
		{
			$num = count($data);
			$row++;
			for ($c=0; $c < $num; $c++)
			{
			//	echo $data[$c] . "<br />\n";
			}
			if ($data[0] == $key and $data[1] == $value)
			{
				$started = true;
				$result.='<table class="table table-hover">' .PHP_EOL;
				$result.='<thead>' .PHP_EOL;
				$result.='<tr>' .PHP_EOL;
				$result.='<th>onderwerp</th>' .PHP_EOL;
				$result.='<th>detail</th>' .PHP_EOL;
				$result.='</tr>' .PHP_EOL;
				$result.='</thead>' .PHP_EOL;
				$result.='<tbody>' .PHP_EOL;
				$started= true;
			}
			if ($started == true)
			{
				if ($data[0] == $key and $data[1] != $value)
				{
					$started = false;
					// close table
					$result.='</tbody>' .PHP_EOL;
					$result.='</table>' .PHP_EOL;
				} 
				elseif ($data[0] == $key and $data[1] == $value)
				{
					// do nothing, skip Key record from being output
				}
				else
				{
					// add data to table
					$result.='<tr>' .PHP_EOL;
					$result.='<td>' . $data[0] . '</td>' .PHP_EOL;
					$result.='<td>' . $data[1] . '</td>' .PHP_EOL;
					$result.='</tr>' .PHP_EOL;
				}
			}
		}
		fclose($handle);
		if ($started == true)
		{
			//have to close table
			$result.='</tbody>' .PHP_EOL;
			$result.='</table>' .PHP_EOL;

			
		}
	}
	return $result;
}
?>