<?php
/*
 * this file is part of
 * PHP WebBuilder by Chris van Gorp
 * Version : March 2017
 */
 

function search_site($search_text)
{
	include("inc.appinfo.php");
	//
	$directory=constant('ROOTDIR');
	$result=array();
	$menu=array();
	$output="";
	$files=get_file_list();
    // add other files
	$files[]= '_contact';
	$files[]= '_disclaimer';
	if ($files !== false)
	{
		foreach ($files as $filename)
		{
			$result_file=search_file($directory . '/' . $filename . '.txt', $search_text);
			if ($result_file !== false)
			{
				//echo 'filename = ' . $filename . '<br>';
				$result[]=$result_file;
				$menu[]=filename_to_href_menu(pathinfo($filename, PATHINFO_FILENAME));
			}
		}
	}
	
	// now do some formatting.

	if (count($result) >0 )
	{
		for ($i=0; $i < count($result); $i++)
		{
			$output.=$menu[$i] . '<br>'; 
			$output.=$result[$i] . '<br><br>'; 
		}
		return $output;
	}
	else
	{
		return false;
	}
}

function search_file($filename, $search_text)
{
	//echo 'filename ' . $filename . ',  search text ' . $search_text . '<br>';
	$output="";
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		if (count($lines) > 0)
		{
			for ($i=0;$i < count($lines); $i++)
			{
				$regel=strtolower($lines[$i]);
				$zoek=strtolower($search_text);
				$pos = strpos($regel, $zoek);
				if ($pos !== false)
				{
					$output.=put_bold($lines[$i],$search_text);			
				}
			}
		}

		if (strlen($output) > 0 )
		{
			return $output;
		}
		else
		{
			return false;
		}
	}
	else
	{
	//	echo 'file ' . $filename . ' does not exist. <br>'; 
	}
	
}

function put_bold($input, $search_text)
{
	$output="";
	
	$len_search=strlen($search_text);
	$pos=strpos(strtolower($input),strtolower($search_text));
	if ($pos !== false)
	{
		$output=substr($input,0, $pos) . '<b>' ;
		$output.=substr($input, $pos,$len_search) . '</b>';
		$output.=substr($input, $pos + $len_search);
		return $output;
	}
	else
	{
		return $input;
	}
}
?>