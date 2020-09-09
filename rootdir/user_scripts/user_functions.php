<?php
/*
 * this file is part of
 * PHP WebBuilder by Chris van Gorp
 * Version : March 2017
 */
function show_software_list($filename)
{
	//echo 'show_software_list() ' . dirname(__FILE__) . PHP_EOL;
	$apps=array();
	$j=-1;
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
	//	echo 'file : ' . var_dump($lines) . PHP_EOL;
		$match="[Application_";
		$len=strlen($match);
		for($i=0;$i<count($lines);$i++)
		{
			if (substr($lines[$i],0, $len) == $match)
			{
				$pos=strpos($lines[$i],"]",$len);
				if ($pos !== false)
				{
					$j++;
					$lenapp=$pos-$len;
					$apps[$j]=substr($lines[$i],$len,$lenapp);
				}
			}
		}
		$DownloadRoot="http://www.pa7rhm.nl/downloads";
		$ini = parse_ini_file($filename,true);
		//
	    echo '<a id="TopOfPage"></a>'; 
		echo '<TABLE>' . PHP_EOL;
	//	echo '<CAPTION><EM>Downloadable software </EM></CAPTION>' . PHP_EOL;
		echo '<TR>' . PHP_EOL;
		echo '<TH>App</TH>' . PHP_EOL;
		echo '<TH>Version</TH>' . PHP_EOL;
		echo '<TH>Info</TH>' . PHP_EOL;
		echo '<TH>W7 Compatible</TH>' . PHP_EOL;
		echo '<TH>More...</TH>' . PHP_EOL;
		echo '</TR>' . PHP_EOL; 
		for ($i=0;$i<count($apps);$i++)
		{
			//echo nl2br("app = " . $apps[$i] . "\n");
			$Section="Application_" . $apps[$i];
		    $AppName=$ini[$Section]['Name'];
			$Description=$ini[$Section]['Description'];
			$Version=$ini[$Section]['Available_Version'];
			$DownloadPath=$ini[$Section]['DownloadPath'];
			$W7Compatible=$ini[$Section]['W7Compatible'];
			$More='<a href="#App_' . $AppName . '">more ...</a>';

			if ($DownloadPath != "")
			{
				if (substr($DownloadPath,0,7) == "http://")
				{
					$AppURL=$ini[$Section]['DownloadPath']  . $ini[$Section]['InstallFile'];
				} else
				{
					$AppURL=$DownloadRoot . "/" . $ini[$Section]['DownloadPath']  . $ini[$Section]['InstallFile'];
				}
			} else
			{
				$AppURL=$DownloadRoot . "/" . $ini[$Section]['InstallFile'];
			}
			$AppHREF='<a href="' . $AppURL . '" target="_blank">' . $AppName . '</a>';
	 	    echo '<TR>' . PHP_EOL;
			echo  '<TD>' . $AppHREF . '</TD>' . PHP_EOL;
			echo '<TD>' . $Version . '</TD>' . PHP_EOL;
			echo '<TD>' . $Description . '</TD>' . PHP_EOL;
			echo '<TD>' . $W7Compatible . '</TD>' . PHP_EOL;
			echo '<TD>' . $More . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
		}
		echo '</TABLE>' . PHP_EOL;
		
		for ($i=0;$i<count($apps);$i++)
		{
			//echo nl2br("app = " . $apps[$i] . "\n");
			$Section="Application_" . $apps[$i];
		    $AppName=$ini[$Section]['Name'];
			$Description=$ini[$Section]['Description'];
			$Version=$ini[$Section]['Available_Version'];
			$Download="..";
			$DownloadPath=$ini[$Section]['DownloadPath'];
			$W7Compatible=$ini[$Section]['W7Compatible'];
			$Compiler=$ini[$Section]['Compiler'];
			$RequiredOS=$ini[$Section]['Required OS'];
			$RequiredSoftware=$ini[$Section]['Required Software'];
			$Copyright=$ini[$Section]['Copyright'];
			$OnlineInfo=$ini[$Section]['OnlineInfo'];
			$ReleaseNotes=$ini[$Section]['ReleaseNotes'];
			//echo "<BR>";
	        echo '<a href="#TopOfPage">Top</a>' . PHP_EOL;
			echo '<a id="App_' . $AppName . '"></a>' . PHP_EOL; 
			echo "<TABLE>" . PHP_EOL;
			echo "<CAPTION><EM>detailed information on App " . $AppName . "</EM></CAPTION>" . PHP_EOL;
			//echo "<TR><TH>App<TH>Version<TH>Info<TH>W7 Compatible</TR>" . PHP_EOL; 
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>App Name</B></TD>' . PHP_EOL;
			echo '<TD>' . $AppName . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Description</B></TD>' . PHP_EOL;
			echo '<TD>' . $Description . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Online information</B></TD>' . PHP_EOL;
			echo '<TD><a href="' . $DownloadRoot . '/' . $OnlineInfo . '" target="_blank">' . 'Screen-shots' . '</a>' . '</TD>' . PHP_EOL;
			echo '</TR' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Release Notes</B></TD>' . PHP_EOL;
			echo '<TD>' . $ReleaseNotes . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Version</B></TD>' . PHP_EOL;
			echo '<TD>' . $Version . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Download</B></TD>' . PHP_EOL;
			echo '<TD>' . $Download . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Copyright</B></TD>' . PHP_EOL;
			echo '<TD>' . $Copyright . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Windows 7 compatible</B></TD>' . PHP_EOL;
			echo '<TD>' . $W7Compatible . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Compiler</B></TD>' . PHP_EOL;
			echo '<TD>' . $Compiler . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Required OS</B></TD>' . PHP_EOL;
			echo '<TD>' . $RequiredOS . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
	 	    echo '<TR>' . PHP_EOL;
			echo '<TD><B>Required Software</B></TD>' . PHP_EOL;
			echo '<TD>' . $RequiredSoftware . '</TD>' . PHP_EOL;
			echo '</TR>' . PHP_EOL;
			echo '</TABLE>' . PHP_EOL;
		}


	} else
	{
		echo format_error_message('software list file not found ');
	}
}
?>