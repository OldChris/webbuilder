<?php
/*
 * this file is part of
 * PHP WebBuilder by Chris van Gorp
 * Version : March 2017
 */
 

function showDownloadsFolder()
{
	include("appinfo.inc.php");
	//
	$filename=constant('ROOTDIR') . "/_downloads.txt";
	// open file
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		for($i=0;$i<count($lines);$i++)
		{
			$line=$i+1;
			//echo $lines[$i] . '<br>';
			$input=$lines[$i];
			$items = explode(";", $input);
			//echo 'count= ' . count($items);
			switch (count($items))
			{
				case 1:
					echo '<a href="' . constant('ROOTDIR') . '/' . $items[0] . '" target="_blank">' . $items[0] . '</a><br>'; 
					break;
				
				case 2:
					echo '<a href="' . constant('ROOTDIR') . '/' . $items[0] . '" target="_blank">' . $items[1] . '</a><br>'; 
					break;
				default:
					# code...
					break;
			}
		}
//	var_dump($infile);
	}
	else
	{
		echo  formatUserMessage("showDownloadsFolder() : _downloads.txt file not found");
	}


}
?>