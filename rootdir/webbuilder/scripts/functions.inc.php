<?php
/*
 * this file is part of
 * PHP WebBuilder by Chris van Gorp
 * Version : March 2017
 */

include constant('SCRIPTSDIR') . "/appinfo.inc.php";
include constant('SCRIPTSDIR') . "/lookup.inc.php";
include constant('SCRIPTSDIR') . "/search.inc.php";
include constant('SCRIPTSDIR') . "/downloads.inc.php";
include constant('USERSCRIPTSDIR') . "/user_functions.php";

global $menucontext_level1;
global $menucontext_level2;
global $blnPassThrough;
global $sitemap;
global $externalURLs;
global $num_URL;
global $newsitems;
global $menuitems;

$blnPassThrough=false;
//
function read_defaults()
{
	include constant('SCRIPTSDIR') . "/appinfo.inc.php";

	global $DefaultErrors;
	// set initial values
	$Def_App_Name="Undefined name of website";
	$Def_App_Tagline="Undefined tagline";
	$Def_App_Icon="favicon.png";
	$Def_App_Logo="default_logo.png";
	$Def_App_Version="Undefined version";
	$Def_App_Copyright="Undefined copyright message";
	$Def_App_Contact="Undefined Contact details";
	$Def_App_Disclaimer="Undefined disclaimer text";
	$Def_App_Description="Undefined description of website";
	$Def_App_Keywords="Undefined website keywords";
	$Def_App_Home="Home";
	$Def_App_Bootstrap_local=true;

	//
	$App_Name="";
	$App_Tagline="";
	$App_Icon="";
	$App_Logo="";
	$App_Version="";
	$App_Copyright="";
	$App_Contact="";
	$App_Disclaimer="";
	$App_Description="";
	$App_Keywords="";
	$App_Home="";
	$App_Bootstrap_local="";
	// 
	$DefaultErrors="";
	// locate file
	$App_DataDir=constant('ROOTDIR');
	$directory=$App_DataDir;
	$filename=$directory . "/_defaults.txt";
	if (is_dir($directory))
	{
		if (file_exists($filename))
		{
			$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
			$lines = explode("\n", $file);
			for($i=0;$i<count($lines);$i++)
			{
				// get 'keyword=value' from textline
				$posequal=strpos($lines[$i],"=");
				if ($posequal !== false)
				{
					$keyword=substr($lines[$i],0,strpos($lines[$i],"="));
					$value=substr($lines[$i],strpos($lines[$i],"=")+1);
					$value=remove_cr($value);
				//	echo nl2br("keyword = " . $keyword . ", value = " . $value . "\n");
					switch (strtoupper($keyword))
					{
						case "APP_NAME" :
							$App_Name=$value;
							break;
						case "APP_TAGLINE" :
							$App_Tagline=$value;
							break;
						case "APP_ICON" :
							$App_Icon=$value;
							break;
						case "APP_LOGO" :
							$App_Logo=$value;
							break;
						case "APP_VERSION" :
							$App_Version=$value;
							break;
						case "APP_COPYRIGHT" :
							$App_Copyright=$value;
							break;
						case "APP_CONTACT" :
							$App_Contact=$value;
							break;
						case "APP_DISCLAIMER" :
							$App_Disclaimer=$value;
							break;
						case "APP_DESCRIPTION" :
							$App_Description=$value;
							break;
						case "APP_KEYWORDS" :
							$App_Keywords=$value;
							break;
						case "APP_HOME" :
							$App_Home=$value;
							break;
						case "APP_BOOTSTRAP_LOCAL" :
							if (strtolower($value) == "true")
							{
								$value=true;
							}
							else
							{
								$value=false;
							}
							$App_Bootstrap_local=$value;
							break;
					}
				} 
			}
			// check if all variable have a value assigned.
			if ($App_Name=="")
			{
				$App_Name=$Def_App_Name;
				$DefaultErrors.='no value present for App_Name in ' . $filename . ', ';
			}
			if ($App_Tagline=="")
			{
				$App_Tagline=$Def_App_Tagline;
				$DefaultErrors.='no value present for App_Tagline in ' . $filename . ', ';
			}
			if ($App_Icon=="")
			{
				$App_Icon=$Def_App_Icon;
				$DefaultErrors.='no value present for App_Icon in ' . $filename . ', ';
			}
			if ($App_Logo=="")
			{
				$App_Logo=$Def_App_Logo;
				$DefaultErrors.='no value present for App_Logo in ' . $filename . ', ';
			}
			if ($App_Version=="")
			{
				$App_Version=$Def_App_Version;
				$DefaultErrors.='no value present for App_Version in ' . $filename . ', ';
			}
			if ($App_Copyright=="")
			{
				$App_Copyright=$Def_App_Copyright;
				$DefaultErrors.='no value present for App_Copyright in ' . $filename . ', ';
			}
			if ($App_Contact=="")
			{
				$App_Contact=$Def_App_Contact;
				$DefaultErrors.='no value present for App_Contact in ' . $filename . ', ';
			}
			if ($App_Disclaimer=="")
			{
				$App_Disclaimer=$Def_App_Disclaimer;
				$DefaultErrors.='no value present for App_Disclaimer in ' . $filename . ', ';
			}
			if ($App_Description=="")
			{
				$App_Description=$Def_App_Description;
				$DefaultErrors.='no value present for App_Description in ' . $filename . ', ';
			}
			if ($App_Keywords=="")
			{
				$App_Keywords=$Def_App_Keywords;
				$DefaultErrors.='no value present for App_Keywords in ' . $filename . ', ';
			}
			if ($App_Home=="")
			{
				$App_Home=$Def_App_Home;
				$DefaultErrors.='no value present for App_Home in ' . $filename . ', ';
			}
			if ($App_Bootstrap_local=="")
			{
				$App_Bootstrap_local=$Def_App_Bootstrap_local;
				$DefaultErrors.='no value present for App_Bootstrap_local in ' . $filename . ', ';

			}

		} else
		{
			echo nl2br("\n". constant('SCRIPT_TITLE') . " Fatal error: file with default values not found! (" . $filename . ")\n");
			echo nl2br("\n\nscript died....\n\n");
			show_footer();
			die;
		}
	} else
	{
		echo nl2br("\n". constant('SCRIPT_TITLE') . " Fatal error: directory with data files not found! (" . $directory . ")\n");
		echo nl2br("\n\nscript died....\n\n");
		show_footer();
		die;
	}
	 //echo nl2br("Globals: \n");
	// var_dump($GLOBALS);
}
function inline_function($functionname, $argument="")
{
	//echo 'function name= ' . $functionname . ', arguments= ' . $argument . PHP_EOL;
	$param_arr=[$argument];
	//var_dump($param_arr);
	//echo '';
	if (function_exists($functionname))
	{
		call_user_func_array($functionname, $param_arr);

	}
	else
	{
		echo format_error_message('Inline-function "' . $functionname . '" not found');		
		die;
	}
}
function the_inline_test_function()
{
     echo 'hello from the inline test function';
     echo 'hello from the inline test function';
     echo 'hello from the inline test function';
     echo 'hello from the inline test function';
     echo 'hello from the inline test function';
     echo 'hello from the inline test function';
     echo 'hello from the inline test function';
     echo 'hello from the inline test function';
     echo 'hello from the inline test function';

}
//


function show_menu($menu_level1,$menu_level2="")
{
	include(constant('SCRIPTSDIR') . "/appinfo.inc.php");
	global $menucontext_level1;
	global $menucontext_level2;
	global $menuitems;
	$menucontext_level1=$menu_level1;
	$menucontext_level2=$menu_level2;
	if ($menucontext_level1=="")   // make sure that we have a menucontext for level 1
	{
		$menucontext_level1=$App_Home;
	}
	// Now build the menu bar
	echo '<nav class="navbar navbar-expand-md navbar-light" style="background-color: #e3f2fd;">' . PHP_EOL;
    echo '  <a class="navbar-brand" href="index.php">' . PHP_EOL;
	echo '    <img src="'. $App_DataDir . '/images/' . $App_Logo . '" height="50" loading="lazy">' .PHP_EOL;
	echo '  </a>' . PHP_EOL;
 	//
 	echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">' .PHP_EOL;
    echo '<span class="navbar-toggler-icon"></span>' . PHP_EOL;
    echo '</button>' . PHP_EOL;
	//
    echo '<div class="collapse navbar-collapse" id="myNavbar">' . PHP_EOL;
	echo '<ul class="navbar-nav  mr-auto">' . PHP_EOL;
//
	$menuitems[]="";
	$menuitems=get_file_list();
  //  var_dump($menuitems);
	$level1_list=get_level1_list();
	//var_dump($level1_list);
	foreach ($level1_list as $level1_menuitem)
	{
	//	echo $level1_menuitem . PHP_EOL;
	//	echo $menucontext_level1 . PHP_EOL;
		if ($level1_menuitem == $menucontext_level1) $isActive=true; else $isActive=false;
		$level2_list=get_level2_list($level1_menuitem);
		//var_dump($level2_list);
        if (count($level2_list) > 0) $hasDropdown=true; else $hasDropdown=false;
 		if ($hasDropdown) $dropdown=' dropdown'; else $dropdown='';
 		if ($isActive)
 		{
 			echo '<li class="nav-item active' . $dropdown . '">' . PHP_EOL;
 		}
 		else
 		{
 			echo '<li class="nav-item' . $dropdown . '">' . PHP_EOL;
 		}
 		if ($hasDropdown)
 		{
 			echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . PHP_EOL;
 			echo $level1_menuitem . PHP_EOL;
 			echo '</a>' . PHP_EOL;
 		}
 		else
 		{
 			if ($isActive)
 			{
 				echo '<a class="nav-link" href="#">' . $level1_menuitem . '</a>' . PHP_EOL;
 			}
 			else
 			{
 				echo '<a class="nav-link" href="index.php?menu=' . $level1_menuitem . '">' . $level1_menuitem . '</a>' . PHP_EOL;
			}
 		}
        if ($hasDropdown == true)
        {
        	echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">' . PHP_EOL;
			foreach ($level2_list as $level2_menuitem)
			{
				echo '<a class="dropdown-item" href="index.php?menu=' . $level1_menuitem . '&amp;submenu=' . $level2_menuitem . '">' . $level2_menuitem . '</a>' . PHP_EOL;
			}
			echo '</div>' .PHP_EOL;
        }
		echo '</li>' .PHP_EOL;
	}
	echo '</ul>' . PHP_EOL;

	// search option

	echo '<form class="form-inline my-2 my-lg-0">' . PHP_EOL;
    echo '<input class="form-control mr-sm-2" name="srch-term" type="search" placeholder="Search" aria-label="Search">' . PHP_EOL;
    echo '<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>' . PHP_EOL;
    echo '</form>' . PHP_EOL;


	echo '</div>' . PHP_EOL;
	echo '</nav>' . PHP_EOL;

}



function show_search($search_text)
{
	start_page();
	echo '<h2>Search results for : "' . $search_text . '"</h2>' . PHP_EOL;
	$result = search_site($search_text);
	if ($result !== false)
	{
		echo $result;
	}
	else
	{
		echo '<p class="text-danger">sorry nothing found for : "' . $search_text . '"</p>' . PHP_EOL;
	}
	end_page();
}
function get_level1_from_level1_file()
{
	$level1_list=array();
	$filename=constant('ROOTDIR') . "/_menu_order.txt";
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		if (count($lines) > 0)
		{
			for ($i=0;$i < count($lines); $i++)
			{
				$level1_list[]=	preg_replace('/[\x0D]/', '', $lines[$i]);
			}
		}
		return $level1_list;
	}
	return false;
}

function get_level1_list()
{
	$level1_list=array();
	$level1_list=get_level1_from_level1_file();
	if ($level1_list == false)
	{
		global $menuitems;
		$menu_count=count($menuitems);
		$match='1_' ;
		$match_length=strlen($match);
		for ($i=0; $i < $menu_count; $i++)
		{
			if (substr($menuitems[$i], 0, $match_length) == $match)
			{
				$level1_list[]=substr($menuitems[$i],$match_length);
			}
		}
		asort($level1_list);
	}
	return $level1_list; 
}

function get_level2_list($level1_menu)
{
	$level2_list=array();
	global $menuitems;
	$menu_count=count($menuitems);
	$match='2_' . $level1_menu . '_';
	$match_length=strlen($match);
	for ($i=0; $i < $menu_count; $i++)
	{
		if (substr($menuitems[$i], 0, $match_length) == $match)
		{
			$level2_list[]=substr($menuitems[$i],$match_length);
		}
	}
	asort($level2_list);
	return $level2_list; 
}

function get_level3_list($level1_menu, $level2_menu)
{
	$level3_list=array();
	global $menuitems;
	$menu_count=count($menuitems);
	$match='3_' . $level1_menu . '_' . $level2_menu . '_';
	$match_length=strlen($match);
	for ($i=0; $i < $menu_count; $i++)
	{
		if (substr($menuitems[$i], 0, $match_length) == $match)
		{
			$level3_list[]=substr($menuitems[$i],$match_length);
		}
	}
	asort($level3_list);
	return $level3_list; 
}
	
function show_page($level1_menu, $level2_menu=Null, $level3_menu=Null)
{
	start_page();
	breadcrumbsBS($level1_menu, $level2_menu, $level3_menu);
	//
	// now check if level 3 menu items are available...
	$level3_list="";
	if ($level2_menu != "")
	{
		$level3_list=get_level3_list($level1_menu, $level2_menu);
		$list_count=count($level3_list);
		if ($list_count > 0)
		{
			// create row
			echo '<div class="row"><!-- BEGIN ROW for selection -->' . PHP_EOL;

			// create column
			echo '<div class="col-sm-6"><!-- BEGIN COL for selection -->'. PHP_EOL;
			// create list
			echo '<h2>Maak een keuze voor ' . $level2_menu . '</h2>' . PHP_EOL;
			echo '<div class="list-group">' . PHP_EOL;
			for ($i=0; $i <$list_count; $i++)
			{
				$mi='<A HREF="index.php?menu=' . $level1_menu . '&amp;submenu=' . $level2_menu . '&amp;menul3=' . $level3_list[$i] .'"' ;
				echo $mi . ' class="list-group-item">' . $level3_list[$i] . '</a>' . PHP_EOL;
			}
			echo '</div><!-- END LISTGROUP -->' . PHP_EOL;
			// end column
			echo '</div><!-- END COL for selection-->'. PHP_EOL; // close col
			// end row
			echo '</div><!-- END ROW for selection-->'. PHP_EOL; // close row,
		}
	}
	
	//
	if ($level1_menu != "") 
	{
		readfilexx(constant('ROOTDIR') . "/" . "1_" . $level1_menu . ".txt");
	}
	if ($level2_menu != "") 
	{
		readfilexx(constant('ROOTDIR') . "/" . "2_" . $level1_menu . "_" . $level2_menu . ".txt");
	}
	if ($level3_menu != "") 
	{
		echo '<!-- start readfilexx for level3 -->' .PHP_EOL;
		readfilexx(constant('ROOTDIR') . "/" . "3_" . $level1_menu . "_" . $level2_menu . '_' . $level3_menu . ".txt");
	}
	

	end_page(); 
	
	
}

function breadcrumbsBS($mLevel1, $mLevel2, $mLevel3)
{
	$href="index.php";
	$href1="index.php?menu=" . $mLevel1;
	$href2="&amp;submenu=" . $mLevel2;
	echo '<nav aria-label="breadcrumb">' . PHP_EOL;
	echo '  <ol class="breadcrumb">' . PHP_EOL;

	if ($mLevel3 != "")
	{
		echo '    <li class="breadcrumb-item"><a href="' . $href . '">Home</a></li>' . PHP_EOL;	
		echo '    <li class="breadcrumb-item"><a href="' . $href1 . '">' . $mLevel1 . '</a></li>' . PHP_EOL;	
		echo '    <li class="breadcrumb-item"><a href="' . $href1 . $href2 .'">' . $mLevel2 . '</a></li>' . PHP_EOL;
		echo '    <li class="breadcrumb-item active" aria-current="page">' . $mLevel3 . '</li>' . PHP_EOL;
	}
	elseif ($mLevel2 != "")
	{
		echo '    <li class="breadcrumb-item"><a href="' . $href . '">Home</a></li>' . PHP_EOL;	
		echo '    <li class="breadcrumb-item"><a href="' . $href1 . '">' . $mLevel1 . '</a></li>' . PHP_EOL;	
		echo '    <li class="breadcrumb-item active" aria-current="page">' . $mLevel2 . '</li>' . PHP_EOL;
	}
	elseif ($mLevel1 != "Home")
	{
		echo '    <li class="breadcrumb-item"><a href="' . $href . '">Home</a></li>' . PHP_EOL;
		echo '    <li class="breadcrumb-item active" aria-current="page">' . $mLevel1 . '</li>' . PHP_EOL;
	}
	else
	{
		echo '    <li class="breadcrumb-item active" aria-current="page">Home</li>' . PHP_EOL;
	}
	echo '  </ol>' . PHP_EOL;
	echo '</nav>' . PHP_EOL;

}


function readfilexx($filename)
{
 global $menucontext_level1;
 global $menucontext_level2;
 global $blnPassThrough;
 //
 $row_started=false;
 $col_started=false;
 $col_count=0;
 $maxCols=2;
 $row_count=0;
	if (file_exists($filename))
	{
	//	echo 'file does exist : ' . $filename . PHP_EOL;
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		//echo 'Count of lines ' . count($lines) . PHP_EOL;
		//echo 'filename ' . $filename . ' has ' . count($lines) . ' lines.<br>' . PHP_EOL;
		if (count($lines) > 1)
		{
			if ($lines[0] != "")
			{
			//	echo "<H3><samp>" . $menucontext_level1 . ": </samp><EM>" . $lines[0] . "</EM></H3>" .PHP_EOL;
				echo "<H2><EM>" . $lines[0] . "</EM></H2>" .PHP_EOL;
			}
			$bookmark_list=build_bookmark_list($filename);
			//var_dump($bookmark_list);
			$row_count+=1;
			echo '<div class="row"><!-- BEGIN first ROW -->' . PHP_EOL;
			for($i=1;$i<count($lines);$i++)
			{
				if (substr($lines[$i],0,1) == ".")
				{
					// $heading=substr($lines[$i],1);
					// $heading=extended_ascii_html($heading);
					 $heading=macros(substr($lines[$i],1));
					 //echo 'heading = ' . $heading . PHP_EOL;
					// echo 'line = ' . $lines[$i];
					// echo 'col count = ' . $col_count;
					 if ($col_count >= $maxCols)
					 {
						echo '</div><!-- END COL ' . $col_count . '-->'. PHP_EOL; // close col
						echo '</div><!-- END ROW ' . $row_count . '-->'. PHP_EOL; // close row,
						 // start new row
						$row_count+=1; 
						echo '<div class="row"><!-- BEGIN ROW ' . $row_count . '-->'. PHP_EOL;
						 // create new column
						$col_count=1;
						echo '<div class="col-sm-6"><!-- BEGIN COL ' . $col_count . ' -->'. PHP_EOL;
						if ($heading != "")
						{
							echo '<h3>'. $heading . '</h3>' . PHP_EOL; // heading of column
						}
					 }
					 else
					 {
						if ($col_started == true)
						{
							echo '</div><!-- END COL ' . $col_count . '-->'. PHP_EOL; // close col
						}
						$col_count+=1;
						echo '<div class="col-sm-6"><!-- BEGIN COL ' . $col_count . '-->'. PHP_EOL;
						$col_started=true;
						if ($heading != "")
						{
							echo '<h3>'. $heading . '</h3>' . PHP_EOL; // heading of column
						}
					 }
				}
 				elseif (substr($lines[$i],0,1) == "=")
				{
					$bookmark_heading="";
					if (strlen($lines[$i]) > 1)
					{
							$bookmark_heading=substr($lines[$i],1);
					}
					$list_count=count($bookmark_list);
					if ($list_count == 0)
					{
						echo format_error_message('no bookmarks found on this page') . PHP_EOL;
					} else
					{
						echo '<span class="anchor" id="BM_"></span>' .PHP_EOL;
						echo '<div class="section"></div>' . PHP_EOL;
						//
					//	echo '<h3>' . $bookmark_heading . '</h3>' . PHP_EOL;
						echo '<div class="panel-group">' . PHP_EOL;
						echo '<div class="panel panel-default">' . PHP_EOL;
						echo '<div class="panel-heading">' . PHP_EOL;
						echo '<h4 class="panel-title">' . PHP_EOL;
//						echo '<a data-toggle="collapse" href="#collapse1">Click to expand / collapse</a>' . PHP_EOL;

						echo '<a class="btn btn-primary" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="true" aria-controls="collapse1">&emsp;' . $bookmark_heading . '&emsp;</a>' . PHP_EOL;					
						echo '</h4>' . PHP_EOL;
						echo '</div><!-- END Panel Title -->' . PHP_EOL;
						echo '<div id="collapse1" class="panel-collapse collaps.show">' . PHP_EOL;
						echo '<ul class="list-group">' . PHP_EOL;
						for ($j=0; $j <$list_count; $j++)
						{
							echo '<A HREF="#BM_' . $bookmark_list[$j] . '" class="list-group-item">' . $bookmark_list[$j] . '</a>' . PHP_EOL;
						}
						echo '</ul>' . PHP_EOL;
						echo '</div><!-- END collaps -->' . PHP_EOL;
						echo '</div><!-- END LISTGroup -->' . PHP_EOL;
						echo '</div><!-- END Panel -->' . PHP_EOL;
					}
				}
				else
				{
					echo macros($lines[$i]) . PHP_EOL; 
					if ($blnPassThrough  ==false)
					{
						echo '<br>';
					}
				}
		    }
			echo '</div><!-- END COL  ' . $col_count . ' (EOF)-->'. PHP_EOL; // end column
			echo '</div><!-- END ROW  ' . $row_count . ' (EOF)-->'. PHP_EOL; // end row
		}
	} 
	else
	{
	   echo 'file does not exist : ' . $filename . PHP_EOL;
	}
}

function build_bookmark_list($filename)
{
	$StartTag="<!--BM>";
	$EndTag="</BM-->";
	$SepTag="|";
	$LenStart=strlen($StartTag);
	$LenEnd=strlen($EndTag);
	$LenSep=strlen($SepTag);
	//
	$bookmark_list=array();
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		if (count($lines) > 1)
		{
			for($i=1;$i<count($lines);$i++)
			{
				$input=$lines[$i];
				$StartPos=strpos($input,$StartTag);
				if ($StartPos !== false)
				{
					$LeadText=substr($input,0,$StartPos);
					$EndPos=strpos($input,$EndTag, $StartPos+$LenStart);
					if ($EndPos !== false)
					{
						$TrailText=substr($input,$EndPos+$LenEnd);
						$TagContent=substr($input,$StartPos+$LenStart,$EndPos-($StartPos+$LenStart));
						$output=$TagContent;
						$bookmark_list[]=extended_ascii_html($output);
					}
				}
			}
		}
	}
	return $bookmark_list;
}

function get_file_list()
{
	$file_list=array();
	$directory=constant('ROOTDIR');
	$extension="";
	if (is_dir($directory))
	{
		if ($dirhandler = opendir($directory))
		{
			while (false !== ($file = readdir($dirhandler)))
			{
				if (($file != '.') && ($file != '..') && (!is_dir($file)))
				{
					//echo 'file = ' . $file . '<br>';
//					$num_files++;
//					$files[$num_files]=$file;  
					$path_parts = pathinfo($file);
					if (isset($path_parts['extension']))
					{
						$extension=$path_parts['extension'];
					}
					$filename=$directory . '/' . $file; 
					//echo 'filename = ' . $filename . '<br>';
					$level=substr($file,0,1);
					// only extention .txt
					if ($extension == "txt")
					{
						if ($level == "1" or $level == "2" or $level == "3")
						{
							$file_list[]=$path_parts['filename'];
						}
					}
				}
			}
		}
	}
	else
	{
		return false;		
	}
	return $file_list;
}

function get_tag_contents($input, $tag)
{
	//echo 'Tag = ' . $tag . ', input=' . $input . '<br>';
	$output=array();
	$StartTag="<!--" . $tag . ">";
	$EndTag="</" . $tag . "-->";
	$LenStart=strlen($StartTag);
	$LenEnd=strlen($EndTag);
	//
	$StartPos=strpos($input,$StartTag);
	if ($StartPos !== false)
	{
		$LeadText=substr($input,0,$StartPos);
		$EndPos=strpos($input,$EndTag, $StartPos+$LenStart);
		if ($EndPos !== false)
		{
			$TrailText=substr($input,$EndPos+$LenEnd);
			$TagContent=substr($input,$StartPos+$LenStart,$EndPos-($StartPos+$LenStart));
			$output[]=$LeadText;
			$output[]=$TagContent;
			$output[]=$TrailText;
			return $output;
		}
		else
		{
			return false;
		}
	}
    else
	{
		return false;
	}
	
}
function macros($input)
{
	global $blnPassThrough;
	$result = get_tag_contents($input, "PASS");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		if ($TagContent == "TRUE")
		{
			$blnPassThrough=true;
		} else
		{
			$blnPassThrough=false;
		}
	}
	if ($blnPassThrough==true)
	{
		return $input;
	}
    $output=$input;
	$LeadText="";
	$TrailText="";
	$ReturnText="";
	//
	$result = get_tag_contents($input, "INLINE");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
			//	echo 'INLINE Tag content = ' . $TagContent . '<br>'; 
				$items=explode(",", $TagContent);
		$function_name=$items[0];
		$argument="";
		if (count($items) >1)
		{
			$argument=$items[1];
		}

		inline_function($function_name, $argument);
	}

	//

	//
	//
	$result = get_tag_contents($input, "URL");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$output=lookup_url($TagContent);
	}
	//

	//
	$result = get_tag_contents($input, "IMG");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
//		$output=lookup_url($TagContent);
		// look for seperator in contents
		$items=explode(",", $TagContent);
		$name=$items[0];
		$width=$items[1];
		$height=$items[2];
		$caption="yes";
		if (count($items) >3)
		{
			$caption=$items[3];
		}
		
		$output=lookup_image($name,$width,$height, $caption);
	}
	//
	$result = get_tag_contents($input, "IMGPAGE");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
//		$output=lookup_url($TagContent);
		// look for seperator in contents
		$items=explode(",", $TagContent);
		$name=$items[0];
		$width=$items[1];
		$height=$items[2];
		$caption="yes";
		if (count($items) >4)
		{
			$caption=$items[3];
			$filename=$items[4];
		}
		$url=filename_to_url_menu($filename);
		$output=lookup_image_url($name,$width,$height, $caption, $url);
	}
	//
	$result = get_tag_contents($input, "IMGLINK");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		//$output=lookup_url($TagContent);
		// look for seperator in contents
		$items=explode(",", $TagContent);
		$name=$items[0];
		$width=$items[1];
		$height=$items[2];
		$caption="yes";
		if (count($items) >4)
		{
			$caption=$items[3];
			$link=$items[4];
		}
		//qqqqq
		//echo 'link = ' . $link;
		$url=lookup_link_url($link);
		//echo 'url = ' . $url;
		$output=lookup_image_url($name,$width,$height, $caption, $url);
	}
	//
	$result = get_tag_contents($input, "LINKPAGE");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$items=explode(",", $TagContent);
		if (count($items) >1)
		{
			$filename=$items[0];
			$text=$items[1];
		}
		else
		{
			$filename=$TagContent;
			$text=$filename;
		}
		$output='<a href="' . filename_to_url_menu($filename) . '">' . $text . '</a>';
//				$output=filename_to_href_menu($filename);
//		$output=lookup_image_url($name,$width,$height, $caption, $url);
	}
	//
	$result = get_tag_contents($input, "SPECS");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$output=lookup_specs($TagContent);
	}
	//
	$result = get_tag_contents($input, "CCT");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$output=lookup_cct($TagContent);
	}
//
	$result = get_tag_contents($input, "BM");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$output.='<a name="BM_' . $TagContent . '" href="#BM_" >' . $TagContent . '</a>';
	}

	//

 
	$ReturnText=extended_ascii_html($LeadText);
	$ReturnText.=extended_ascii_html($output);
	if ($TrailText != "")
	{
		$TrailText=macros($TrailText);
		$ReturnText.=extended_ascii_html($TrailText);
	}
	//echo "done with macros()";
	return $ReturnText;
}


function format_error_message($text)
{
	$errText='<p class="text-danger"><b>Error : ' .  $text . '</b></p>';
	return $errText;

}
function extended_ascii_html($extended_ascii_text)
{
	$ReturnText="";
	for ($i=0; $i < strlen($extended_ascii_text); $i++)
	{
	$ReturnText .= replace_8bit_html($extended_ascii_text[$i]);
	}
	return $ReturnText;
}

function replace_8bit_html($character)
{
	$ascii_value=ord($character);
	switch($ascii_value)
	{
		case 128: return '&#128;'; break;
		case 129: return ' '; break;
		case 130: return '&#130;'; break;
		case 131: return '&#131;'; break;
		case 132: return '&#132;'; break;
		case 133: return '&#133;'; break;
		case 134: return '&#134;'; break;
		case 135: return '&#135;'; break;
		case 136: return '&#136;'; break;
		case 137: return '&#137;'; break;
		case 138: return '&#138;'; break;
		case 139: return '&#139;'; break;
		case 140: return '&#140;'; break;
		case 141: return ' '; break;
		case 142: return '&#142;'; break;
		case 143: return ' '; break;
		case 144: return ' '; break;
		case 145: return '&#145;'; break;
		case 146: return '&#146;'; break;
		case 147: return '&#147;'; break;
		case 148: return '&#148;'; break;
		case 149: return '&#149;'; break;
		case 150: return '&#150;'; break;
		case 151: return '&#151;'; break;
		case 152: return '&#152;'; break;
		case 153: return '&#153;'; break;
		case 154: return '&#154;'; break;
		case 155: return '&#155;'; break;
		case 156: return '&#156;'; break;
		case 157: return ' '; break;
		case 158: return '&#158;'; break;
		case 159: return '&#159;'; break;
		case 160: return '&#160;'; break;
		case 161: return '&#161;'; break;
		case 162: return '&#162;'; break;
		case 163: return '&#163;'; break;
		case 164: return '&#164;'; break;
		case 165: return '&#165;'; break;
		case 166: return '&#166;'; break;
		case 167: return '&#167;'; break;
		case 168: return '&#168;'; break;
		case 169: return '&#169;'; break;
		case 170: return '&#170;'; break;
		case 171: return '&#171;'; break;
		case 172: return '&#172;'; break;
		case 173: return '&#173;'; break;
		case 174: return '&#174;'; break;
		case 175: return '&#175;'; break;
		case 176: return '&#176;'; break;
		case 177: return '&#177;'; break;
		case 178: return '&#178;'; break;
		case 179: return '&#179;'; break;
		case 180: return '&#180;'; break;
		case 181: return '&#181;'; break;
		case 182: return '&#182;'; break;
		case 183: return '&#183;'; break;
		case 184: return '&#184;'; break;
		case 185: return '&#185;'; break;
		case 186: return '&#186;'; break;
		case 187: return '&#187;'; break;
		case 188: return '&#188;'; break;
		case 189: return '&#189;'; break;
		case 190: return '&#190;'; break;
		case 191: return '&#191;'; break;
		case 192: return '&#192;'; break;
		case 193: return '&#193;'; break;
		case 194: return '&#194;'; break;
		case 195: return '&#195;'; break;
		case 196: return '&#196;'; break;
		case 197: return '&#197;'; break;
		case 198: return '&#198;'; break;
		case 199: return '&#199;'; break;
		case 200: return '&#200;'; break;
		case 201: return '&#201;'; break;
		case 202: return '&#202;'; break;
		case 203: return '&#203;'; break;
		case 204: return '&#204;'; break;
		case 205: return '&#205;'; break;
		case 206: return '&#206;'; break;
		case 207: return '&#207;'; break;
		case 208: return '&#208;'; break;
		case 209: return '&#209;'; break;
		case 210: return '&#210;'; break;
		case 211: return '&#211;'; break;
		case 212: return '&#212;'; break;
		case 213: return '&#213;'; break;
		case 214: return '&#214;'; break;
		case 215: return '&#215;'; break;
		case 216: return '&#216;'; break;
		case 217: return '&#217;'; break;
		case 218: return '&#218;'; break;
		case 219: return '&#219;'; break;
		case 220: return '&#220;'; break;
		case 221: return '&#221;'; break;
		case 222: return '&#222;'; break;
		case 223: return '&#223;'; break;
		case 224: return '&#224;'; break;
		case 225: return '&#225;'; break;
		case 226: return '&#226;'; break;
		case 227: return '&#227;'; break;
		case 228: return '&#228;'; break;
		case 229: return '&#229;'; break;
		case 230: return '&#230;'; break;
		case 231: return '&#231;'; break;
		case 232: return '&#232;'; break;
		case 233: return '&#233;'; break;
		case 234: return '&#234;'; break;
		case 235: return '&#235;'; break;
		case 236: return '&#236;'; break;
		case 237: return '&#237;'; break;
		case 238: return '&#238;'; break;
		case 239: return '&#239;'; break;
		case 240: return '&#240;'; break;
		case 241: return '&#241;'; break;
		case 242: return '&#242;'; break;
		case 243: return '&#243;'; break;
		case 244: return '&#244;'; break;
		case 245: return '&#245;'; break;
		case 246: return '&#246;'; break;
		case 247: return '&#247;'; break;
		case 248: return '&#248;'; break;
		case 249: return '&#249;'; break;
		case 250: return '&#250;'; break;
		case 251: return '&#251;'; break;
		case 252: return '&#252;'; break;
		case 253: return '&#253;'; break;
		case 254: return '&#254;'; break;
		case 255: return '&#255;'; break;
        default: return  $character;
		
	}
	
	
}
function check()
{
	start_page();
	//set_time_limit(0);
	echo '<h2>Check of your URL links as used in the pages</h2><br>please wait ....<br>';
	$html=check_url_pages();
	echo $html;
	echo '<br><h2>Check of your external URL links</h2><br>please wait ....<br>';
	$html=check_url_internet();
	echo $html;
	echo '<br><h2>Check of your images</h2><br>please wait ....<br>';
	$html=check_image_pages();
	echo $html;
	echo '<br><h2>Check images in image folder</h2><br>please wait ....<br>';
	$html=check_images_folder(constant('ROOTDIR') . '/images');
	echo $html;
	echo '<br><br><br><br>' .PHP_EOL;
}

function display_sitemap()
{
	include(constant('SCRIPTSDIR') . "/appinfo.inc.php");
	global $sitemap;
	global $externalURLs;
	global $num_URL;
	//
	$externalURLs="";
	$num_URL=-1;
	$num_files_home=-1;
	$files_home=array();
	$LenHome=strlen("1_" . $App_Home);
	$num_files=-1;
	$num_files_rest=-1;
	$files_rest = array();
	$directory=constant('ROOTDIR');
	start_page();
	$files=get_file_list();
    // add other files
	$files[]= '_contact';
	$files[]= '_disclaimer';
	foreach ($files as $filename)
	{
		if (($filename == "1_" . $App_Home) || (substr($filename,$LenHome) == "2_" . $App_Home))
		{
			$num_files_home++;
			$files_home[$num_files_home]=$filename;
			//echo nl2br("[". $filename . "]\n");							}
	    } else
		{
			$num_files_rest++;
			$files_rest[]=$filename;
		}
	}
	// sort , then join 2 arrays
	$num_files=-1;
	sort($files_home);
	sort($files_rest);
	$files=$files_home + $files_rest;
	//
	echo "<H3>Site Map</H3>";
	foreach ($files as $filename)
	{
		//echo $filename . '<br>';
		$title=sitemap_getheading_from_file($directory . "/" . $filename . ".txt");
 		$url=filename_to_url_menu($filename);
		$level=substr($filename,0, 2);
		switch ($level)
		{
		 	case '1_':
				$level1=substr($filename,2,strlen($filename)-2);
				$len_level1=2 + strlen($level1);
				echo '<a href="' . $url . '">' . $level1 . '</a><I>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $title . '</i><br>' . PHP_EOL;

				for ($j=0;$j<count($files);$j++)
				{
					$filename=$files[$j];
					//echo nl2br("Filename 2= [". $filename . "]\n");
					if (substr($filename,0, $len_level1) == "2_" . $level1)
					{
						$title=sitemap_getheading_from_file($directory . "/" . $filename . ".txt");
				 		$url=filename_to_url_menu($filename);
						$level2=substr($filename,$len_level1+1);
						echo '...<a href="' . $url . '">' . $level2 . '</a><I>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $title . '</i><br>' . PHP_EOL;
					}
				}
		 		break;
		 		case '2_':
		 		break;
		 		case '3_':
		 		break;
		 	default:
				echo '<a href="' .  $url . '">' . $filename . '</a><I>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $title . '</i><br>' . PHP_EOL;
		 		break;
		 } 
	}

	end_page();
}

function sitemap_getheading_from_file($filename)
{
//
$heading="";
	if (file_exists($filename))
	{
		$file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$lines = explode("\n", $file);
		if ($lines[0] != "")
		{
			$heading=$lines[0];
		}
	}
	$heading = remove_cr($heading);
	return $heading;
}

function remove_cr($input)
{
	return(preg_replace("/[\\n\\r]+/", "", $input));
}


function show_header()
{
	
	include(constant('SCRIPTSDIR') . "/appinfo.inc.php");
	global $menucontext_level1;
	global $menucontext_level2;
	global $DefaultErrors;
	$PageTitle=$App_Name . ' : ' . $App_Description; //. ", " . $menucontext_level1;
	echo '<!doctype html>' . PHP_EOL;
	echo '<!-- Created by Webbuilder Chris van Gorp -->' . PHP_EOL;
	echo '<!--      based on BootStrap 4 -->' . PHP_EOL;
	echo '<html lang="en">' . PHP_EOL;
	echo '<head>' . PHP_EOL;
	echo '<meta charset="utf-8">' . PHP_EOL;
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">' . PHP_EOL;
    echo '<!-- Bootstrap CSS -->' . PHP_EOL;
    echo '<link rel="stylesheet" type="text/css" href="' . constant('CSSDIR') . '/bootstrap.min.css">' . PHP_EOL; 
    echo '<link rel="stylesheet" type="text/css" href="' . constant('CSSDIR') . '/webbuilder.css"><!-- Cascading Webbuilder style elements -->' . PHP_EOL;  // cascading our own style elements.
    echo '<link rel="stylesheet" type="text/css" href="' . constant('USERCSSDIR') . '/custom.css"><!-- Cascading user style elements -->' . PHP_EOL;  // cascading our own style elements.
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . constant('ROOTDIR') . '/images/' . $App_Icon . '">' . PHP_EOL;

	echo '<meta name="generator" content="Webbuilder, Chris van Gorp">' . PHP_EOL;
	echo '<meta name="rights" content="' . $App_Copyright . '"/>' . PHP_EOL;
	echo '<meta name="description" content="' . $App_Description . '">' . PHP_EOL;
	echo '<meta name="keywords" content="' . $App_Keywords . '">' . PHP_EOL;
	if ($DefaultErrors != "")
	{
		echo '<!--  found some errors in configuration file -->' . PHP_EOL;
		echo '<!--  ' . $DefaultErrors . ' -->' . PHP_EOL;
	}
	echo  '<title>' . $PageTitle . '</title>' . PHP_EOL;  // " " . $App_Version . " " . $App_Copyright . 
	echo '</HEAD>' . PHP_EOL;
	echo '<BODY>' . PHP_EOL;
	echo '<a id="TopOfPage"></a>' . PHP_EOL; 
}

function start_page()
{
	echo '<div class="container-fluid" style="margin-bottom:30px;"><!-- START CONTAINER -->' . PHP_EOL;  
}

function end_page()
{
	echo '</div><!-- END CONTAINER -->' . PHP_EOL;
}

function show_footer()
{
	include(constant('SCRIPTSDIR') . "/appinfo.inc.php");
	//echo  "<HR>";
	$home='<a href="index.php">Home</a>';
	$disclaimer='<a href="https://pa7rhm.nl/index.php?disclaimer=1">Disclaimer</a>';
	$sitemap='<a href="index.php?sitemap=1">Site Map</a>';
	$contact='<a href="index.php?contact=1">Contact</a>';
	$copyrightscripting='(' . constant('SCRIPT_TITLE') . ' by Chris van Gorp)';
	$spacing='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<nav class="navbar fixed-bottom navbar-solid navbar-expand-md navbar-light"  style="background-color: #e3f2fd;">' . PHP_EOL;
    echo '  <a class="navbar-brand" href="#TopOfPage">' . $App_Name . ' : <small class="text-muted">' . $App_Tagline . '</small></a>' . PHP_EOL;
 	echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myFooterNavbar" aria-controls="myFooterNavbar" aria-expanded="false" aria-label="Toggle navigation">' .PHP_EOL;
    echo '<span class="navbar-toggler-icon"></span>' . PHP_EOL;
    echo '</button>' . PHP_EOL;
	//
    echo '<div class="collapse navbar-collapse" id="myFooterNavbar">' . PHP_EOL;
	echo '<ul class="navbar-nav  mr-auto">' . PHP_EOL;
	echo '<li class="nav-item">' . PHP_EOL;
	echo '<a class="nav-link" href="index.php?disclaimer=1">Disclaimer</a>' . PHP_EOL;
	echo '</li>' . PHP_EOL;
	echo '<li class="nav-item">' . PHP_EOL;
	echo '<a class="nav-link" href="index.php?sitemap=1">Site Map</a>' . PHP_EOL;
	echo '</li>' . PHP_EOL;
	echo '<li class="nav-item">' . PHP_EOL;
	echo '<a class="nav-link" href="index.php?contact=1">Contact</a>' . PHP_EOL;
	echo '</li>' . PHP_EOL;
	echo '</ul>' . PHP_EOL;
	echo '<ul class="nav navbar-nav navbar-right">' . PHP_EOL;
	echo ' Designed by&nbsp;&nbsp;&nbsp;' . PHP_EOL;
    echo '<a href="index.php?about=1"><b>Chris van Gorp</b></a>' . PHP_EOL;
    echo '</ul>' . PHP_EOL;

	echo '</div>' . PHP_EOL;
	echo '</nav> ' . PHP_EOL;
	echo '<!-- Optional JavaScript --> ' . PHP_EOL;
    echo '<!-- jQuery first, then Popper.js, then Bootstrap JS --> ' . PHP_EOL;
    if ($App_Bootstrap_local)
    {
	    echo '<script src="' . constant('JSDIR') . '/jquery-3.5.1.slim.min.js"></script><!-- JQuery script -->' . PHP_EOL;
	    echo '<script src="' . constant('JSDIR') . '/popper.min.js"></script><!-- Popper script -->' . PHP_EOL;
	    
	    echo '<script src="' . constant('JSDIR') . '/bootstrap.min.js"></script><!-- Bootstrap script -->' . PHP_EOL;

    }
    else
    {
    	echo '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>' .PHP_EOL;
    	echo '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>' . PHP_EOL;
    	echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>' . PHP_EOL;
    }
	echo "</BODY>" . PHP_EOL;
	echo "</HTML>" . PHP_EOL;
}
function display_about()
{
	include(constant('SCRIPTSDIR') . "/appinfo.inc.php");
	start_page();
	echo '<h2>About WebBuilder</h2>' . PHP_EOL;
	echo '<br>WebBuilder is created by Chris van Gorp in 2012, in 2020 Bootstrap 4 replaced my own CSS to make it responsive and better looking.' . PHP_EOL;
	echo '<br><a href="https://github.com/OldChris/webbuilder" target="_blank">View / download source from Github</a> <br><br>' .PHP_EOL; 

    if ($App_Bootstrap_local)
    {
    	echo 'Bootstrap is loaded from local server<br>' . PHP_EOL;

    }
    else
    {
    	echo 'Bootstrap is loaded from CDN<br>' . PHP_EOL;
    }

	end_page();
}

function display_contact()
{
	start_page();
	readfilexx(constant('ROOTDIR') . "/_contact.txt");
	end_page();
} 

function display_disclaimer()
{
	start_page();
	readfilexx(constant('ROOTDIR') . "/_disclaimer.txt");
	end_page();
} 

function filename_to_url_menu($filename)
{
	$menulevels=filename_to_menulevels($filename);	
	$url="";
	$level=substr($filename,0,1);
	switch ($level)
	{
		case 1:
			$level1_menuitem=substr($filename,2);
			$url='index.php?menu=' . $menulevels[0];	
			break;
		case 2:
			$url='index.php?menu=' . $menulevels[0] . '&amp;submenu=' . $menulevels[1];
			break;
		case 3:
				$url='index.php?menu=' . $menulevels[0] . '&amp;submenu=' . $menulevels[1] . '&menul3=' . $menulevels[2];
			break;
		default:
			if ($filename == "_contact") 
			{
				$url='index.php?contact=1';	
			}
			if ($filename == "_disclaimer") 
			{
				$url='index.php?disclaimer=1';	
			}
	}
	return $url;
}

function filename_to_href_menu($filename, $text="")
{
	$menulevels=filename_to_menulevels($filename);
	//$level1_menuitem, $level2_menuitem,	$level3_menuitem=explode(";", $menulevels);
	//echo 'filename = ' . $filename . ', 1= ' . $menulevels[0] . ', 2 = ' . $menulevels[1] . ', 3 = ' . $menulevels[2] . '<br>';
	$url=filename_to_url_menu($filename);
	$href="";
	$level=substr($filename,0,1);
	switch ($level)
	{
		case 1:
			$level1_menuitem=substr($filename,2);
			if ($text == "")
			{
				$href='<A HREF="' . $url . '">' . $menulevels[0] . '</a>';	
			}
			else
			{
				$href='<A HREF="' . $url . '">' . $text . '</a>';	
			}
			break;
		case 2:
			if ($text == "")
			{
				$href='<A HREF="' . $url . '">' . $menulevels[0] . ' / ' . $menulevels[1] . '</a>';
			}
			else
			{
				$href='<A HREF="' . $url . '">' . $text . '</a>';
			}
			break;
		case 3:
			if ($text == "")
			{
				$href='<A HREF="' . $url . '">' . $menulevels[0] . ' / ' . $menulevels[1] . ' / ' . $menulevels[2] . '</a>';
			}
			else
			{
				$href='<A HREF="' . $url . '">' . $text . '</a>';
			}
			break;
		default:
			if ($filename == "_contact") 
			{
				$href='<A HREF="' . $url . '">Contact</a>';	
			}
			if ($filename == "_disclaimer") 
			{
				$href='<A HREF="' . $url . '">Disclaimer</a>';	
			}
	}
	return $href;
}

function filename_to_menulevels($filename)
{
	//echo 'filename to menulevel ' . $filename . ' <br>';
	$level1_menuitem="";
	$level2_menuitem="";
	$level3_menuitem="";
	$menuitems=array();
	$level=substr($filename,0,1);
	$pos1=2;
	$pos2=-1;
	$pos3=-1;
	$pos4=-1;
	switch ($level)
	{
		case 1:
			$level1_menuitem=substr($filename,$pos1);
			break;
		case 2:
			$level1_menuitem=substr($filename,$pos1);
			$pos2=strpos($level1_menuitem,"_");
			if ($pos2 !== false)
			{
				$level1_menuitem=substr($level1_menuitem,0,$pos2);
			}
			$level2_menuitem=substr($filename,$pos2+3);
			break;
		case 3:
			$pos1=2;
			$level1_menuitem=substr($filename,$pos1);
			$pos2=strpos($filename,"_",$pos1+1);
			if ($pos2 !== false)
			{
				$level1_menuitem=substr($filename,$pos1,$pos2-$pos1);
			}
			$pos3=strpos($filename,"_",$pos2+1);
			if ($pos3 !== false)
			{
				$level2_menuitem=substr($filename,$pos2+1, $pos3-$pos2-1);
			}
			$pos4=strpos($filename,".txt",$pos3+1);
			if ($pos4 !== false)
			{
				$level3_menuitem=substr($filename,$pos3+1, $pos4-$pos3-1);
			}
			else
			{
				$level3_menuitem=substr($filename,$pos3+1);
			}
			break;
	}
	//echo '<br>filename = ' . $filename . '<br>';
	//echo '1= ' . $pos1 . ', 2 = ' . $pos2 . ',  3 = ' . $pos3 . ', 4 = ' . $pos4 . '<br>';
	$menuitems[]=$level1_menuitem;
	$menuitems[]=$level2_menuitem;
	$menuitems[]=$level3_menuitem;
	return $menuitems;
	
}

?>