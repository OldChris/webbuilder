<?php
/*
 * this file is part of
 * PHP WebBuilder by Chris van Gorp
 * Version : March 2017
 */

//include_once("inc.functions.php");
//


function check_url_pages()
{
	$in_file=array();
	$html="";
	$numGood=0;
	$numBad=0;
	$numWarning=0;
	$description="";
	$filename=constant('ROOTDIR') . "/_links.txt";
	// open file
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		for($i=0;$i<count($lines);$i++)
		{
			$line=$i+1;
			$input=$lines[$i];
			$items = explode(";", $input);
			if (count($items) !=3)
			{
				echo format_error_message('incorrect count= ' . count($items) . ' at line = ' . $line);
			}
			else
			{
				$infile[]=$items[0];
			}
		}
//	var_dump($infile);
	}
	else
	{
		die ("check_url_pages() : _links.txt file not found");
	}
	// look for link tag in all files
	$files=get_file_list();
	if ($files !== false)
	{
		foreach ($files as $filename)
		{
			$filename=constant('ROOTDIR') . '/' . $filename . '.txt';
			$filecontent = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
			$lines = explode("\n", $filecontent);
			//echo 'opened file ' . $filename . '<br>';
			for($i=0;$i<count($lines);$i++)
			{
				$input=$lines[$i];
				$TagContent=get_tag_contents($input,"URL");
				if ($TagContent !== false)
				{
					//echo 'Tag content = [', $TagContent[1] . ']';
					if (in_array($TagContent[1], $infile))
					{
						$html.='OK file ' . $filename . '<br>';
					}
					else
					{
						$html.='ERROR file ' . $filename . ' : ' . $TagContent[1] . ' is not in _links.txt file!<br>';
					}
				}
			}	
		}
	}
	
	
	
	return $html;
    
}

function check_url_internet()
{
	// see also https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
	$html="";
	$numGood=0;
	$numBad=0;
	$numWarning=0;
	$description="";
	$filename=constant('ROOTDIR') . "/_links.txt";
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
			if (count($items) !=3)
			{
				echo '<br>incorrect count= ' . count($items) . ' at line = ' . $line;
			}
			
			// get attributes
			$url=$items[1];
			$description=$items[2];
   			$status = url_exists($url);
			echo $status . ' : ' . $url . '<br>'; 
		}
	}
	else
	{
		die ("check_url_internet() : _links.txt file not found");
	}
	return $html;
}

function check_images_folder($image_folder)
{
    if(is_dir($image_folder)){
    	echo 'scan dir ' . $image_folder . PHP_EOL;
        $files = glob( $image_folder . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file )
        {
	        if(is_dir($file)){
    	        check_images_folder( $file );
    	    }
    	    else
    	    {
    	    	if (strpos($file, ' ') !== false) {
	    	    	echo format_error_message('-- file = ' . $file . ' : filename contains space(s)') . PHP_EOL;
				}
				else
				{
	    	    	echo 'OK -- file = ' . $file . '<br>' . PHP_EOL;
				}
    	    }
        }
    } 
}



function check_image_pages()
{
	$in_file=array();
	$html="";
	$numGood=0;
	$numBad=0;
	$numWarning=0;
	$description="";
	$filename=constant('ROOTDIR') . "/_images.txt";
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
			$items = explode(",", $input);
			//echo 'count= ' . count($items);
			if (count($items) !=3)
			{
				echo format_error_message('<br>_images.txt : incorrect count= ' . count($items) . ' at line = ' . $line);
			}
			else
			{
				if (image_file_exists($items[2]) )
				{
					echo 'OK, image ' . $items[2] . ' exists<br>';
				}
				else
				{
					echo  format_error_message('image '. $items[2] . ' does not exists');
				}
			}
			$infile[]=$items[0];
		}
//	var_dump($infile);
	}
	else
	{
		echo format_error_message('check_image_pages() : _images.txt file not found');
	}
	// look for link tag in all files
	$files=get_file_list();
	if ($files !== false)
	{
		foreach ($files as $filename)
		{
			$filename=constant('ROOTDIR') . '/' . $filename . '.txt';
			$filecontent = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
			$lines = explode("\n", $filecontent);
			//echo 'opened file ' . $filename . '<br>';
			for($i=0;$i<count($lines);$i++)
			{
				$input=$lines[$i];
				$TagContent=get_tag_contents($input,"IMG");
				if ($TagContent !== false)
				{
					$items = explode(",", $TagContent[1]);
					if (count($items) !=4)
					{
						echo '<br>'  . $filename . ' incorrect count= ' . count($items) . ' at line = ' . $line;
					}
					if (in_array($items[0], $infile))
					{
						echo 'OK file ' . $filename . '<br>';
					}
					else
					{
						echo format_error_message(' file ' . $filename . ' : ' . $items[0] . ' is not in _images.txt file!');
					}
				}
			}	

		}
	}
	return $html;
}

function image_file_exists($image_filename)
{
//	echo $image_filename . '<br>';
	$poshttp=strpos($image_filename,'http');
	if ($poshttp !== false)
	{
		$urlstatus=url_exists($image_filename);
		return $urlstatus;
	}
	else
	{
		if ( file_exists(constant('ROOTDIR') . '/' . $image_filename))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function url_exists($url)
{
	//echo 'url = ' . $url . '<br>'; 
	$handle = curl_init($url);
	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
	/* Get the HTML or whatever is linked in $url. */
	$response = curl_exec($handle);
	/* Check for 404 (file not found). */
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	curl_close($handle);

	$status="";
		//echo 'code = ' . $httpCode . '<br>'; 

	switch ($httpCode)
	{
		// first all known good response codes
		case 200:
			$status="OK";
			break;
		// then all warnings (redirects)
		case 300:
		case 301:
		case 302:
		case 303:
			$status="WARNING : site reports redirection (" . $httpCode . ")";
			break;
		// list of all error codes
		case 0:
			$status="ERROR : Server not found (" . $httpCode . ")";
			//echo 'code 0<br>';
			break;
		case 403:
			$status="ERROR : Forbidden (" . $httpCode . ")";
			break;
		case 404:
			$status="ERROR : Not found  (" . $httpCode . ")";
			break;
		case 500:
			$status="ERROR : Internal Server Error (" . $httpCode . ")";
			break;
		case 503:
			$status="ERROR : Service unavailable (" . $httpCode . ")";
			break;
		default:
			$status="ERROR : Unknown error (" . $httpCode . ")";
			break;
	}
	return $status;
}
?>
	