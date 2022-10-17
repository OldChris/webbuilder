<?php
/*
 * this file is part of
 * PHP WebBuilder by Chris van Gorp
 * Version : March 2017
 */
define('APP_VERSION','v1.0');
//
define('CSSDIR',constant('ROOTDIR') . '/webbuilder/css');
define('JSDIR',constant('ROOTDIR') . '/webbuilder/js');
define('FONTSDIR',constant('ROOTDIR') . '/webbuilder/fonts');
define('USERCSSDIR',constant('ROOTDIR') . '/user_css');
define('USERSCRIPTSDIR',constant('ROOTDIR') . '/user_scripts');
define('SCRIPT_TITLE','PHP Webbuilder');

include constant('SCRIPTSDIR') . "/appinfo.inc.php";
include constant('SCRIPTSDIR') . "/lookup.inc.php";
include constant('SCRIPTSDIR') . "/search.inc.php";
include constant('SCRIPTSDIR') . "/downloads.inc.php";
include constant('USERSCRIPTSDIR') . "/user_functions.php";
include_once(constant('SCRIPTSDIR') . "/check.inc.php");

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
function readDefaults()
{
	include constant('SCRIPTSDIR') . "/appinfo.inc.php";

	global $DefaultErrors;
	// set initial values
	$Def_App_Name="Undefined name of website";
	$Def_App_Tagline="Undefined tagline";
	$Def_App_Icon="favicon.png";
	$Def_App_Logo="default_logo.png";
	$Def_App_Copyright="Undefined copyright message";
	$Def_App_Description="Undefined description of website";
	$Def_App_Keywords="Undefined website keywords";
	$Def_App_Home="Home";
	$Def_App_BootstrapLocal="TRUE";
	$Def_App_BGColorNavbarTop="#e3f2fd";
	$Def_App_BGColorNavbarBottom="#e3f2fd";
	$Def_App_NavbarTop="dark";
	$Def_App_NavbarBottom="light";
	$Def_App_Search="Search";
	$Def_App_SearchResult="Search results for";
    $Def_App_SearchNotFound="Sorry, did not find anything";
	$Def_App_Language="en";
	//
	$App_Name="";
	$App_Tagline="";
	$App_Icon="";
	$App_Logo="";
	$App_Copyright="";
	$App_Description="";
	$App_Keywords="";
	$App_Home="";
	$App_BootstrapLocal="";
	$App_BGColorNavbarTop="";
	$App_BGColorNavbarBottom="";
	$App_NavbarTop="";
	$App_NavbarBottom="";
	$App_Search="";
	$App_SearchResult="";
	$App_SearchNotFound="";
	$App_Language="";
	// 
	$DefaultErrors="";
	// locate file
	$directory=constant('ROOTDIR');
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
					$value=removeCr($value);
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
						case "APP_COPYRIGHT" :
							$App_Copyright=$value;
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
						case "APP_BOOTSTRAPLOCAL" :
							if (strtolower($value) == "true")
							{
								$value="TRUE";
							}
							else
							{
								$value="FALSE";
							}
							$App_BootstrapLocal=$value;
							break;
						case "APP_BGCOLORNAVBARTOP" :
							$App_BGColorNavbarTop=$value;
							break;
						case "APP_BGCOLORNAVBARBOTTOM" :
							$App_BGColorNavbarBottom=$value;
							break;
						case "APP_NAVBARTOP" :
							$App_NavbarTop=$value;
							break;
						case "APP_NAVBARBOTTOM" :
							$App_NavbarBottom=$value;
							break;
						case "APP_SEARCH" :
							$App_Search=$value;
							break;
						case "APP_SEARCHRESULT" :
							$App_SearchResult=$value;
							break;
						case "APP_SEARCHNOTFOUND" :
							$App_SearchNotFound=$value;
							break;
						case "APP_LANGUAGE" :
							$App_Language=$value;
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
			if ($App_Copyright=="")
			{
				$App_Copyright=$Def_App_Copyright;
				$DefaultErrors.='no value present for App_Copyright in ' . $filename . ', ';
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
			if ($App_BootstrapLocal=="")
			{
				$App_BootstrapLocal=$Def_App_BootstrapLocal;
				$DefaultErrors.='no value present for App_BootstrapLocal in ' . $filename . ', ';
			}
			if ($App_BGColorNavbarTop=="")
			{
				$App_BGColorNavbarTop=$Def_App_BGColorNavbarTop;
				$DefaultErrors.='no value present for App_BGColorNavbarTop in ' . $filename . ', ';
			}
			if ($App_BGColorNavbarBottom=="")
			{
				$App_BGColorNavbarBottom=$Def_App_BGColorNavbarBottom;
				$DefaultErrors.='no value present for App_BGColorNavbarBottom in ' . $filename . ', ';
			}
			if ($App_NavbarTop=="")
			{
				$App_NavbarTop=$Def_App_NavbarTop;
				$DefaultErrors.='no value present for App_NavbarTop in ' . $filename . ', ';
			}
			if ($App_NavbarBottom=="")
			{
				$App_NavbarBottom=$Def_App_NavbarBottom;
				$DefaultErrors.='no value present for App_NavbarBottom in ' . $filename . ', ';
			}
			if ($App_Search=="")
			{
				$App_Search=$Def_App_Search;
				$DefaultErrors.='no value present for App_Search in ' . $filename . ', ';
			}
			if ($App_SearchResult=="")
			{
				$App_SearchResult=$Def_App_SearchResult;
				$DefaultErrors.='no value present for App_SearchResult in ' . $filename . ', ';
			}
			if ($App_SearchNotFound=="")
			{
				$App_SearchNotFound=$Def_App_SearchNotFound;
				$DefaultErrors.='no value present for App_SearchNotFound in ' . $filename . ', ';
			}
			if ($App_Language=="")
			{
				$App_Language=$Def_App_Language;
				$DefaultErrors.='no value present for App_Language in ' . $filename . ', ';
			}
		} else
		{
			echo formatUserMessage(constant('SCRIPT_TITLE') . ' Fatal error: file with default values not found! (' . $filename . ')');
			echo formatUserMessage('script died....');
			showFooter();
			die;
		}
	} else
	{
		echo formatUserMessage(constant('SCRIPT_TITLE') . ' Fatal error: directory with data files not found! (' . $directory . ')');
		echo formatUserMessage('script died....');
		showFooter();
		die;
	}
	 //echo nl2br("Globals: \n");
	// var_dump($GLOBALS);
}


function echoo($line)
{
	if (isset($GLOBALS['html_filename']) && $GLOBALS['html_filename'] != "")
	{
		echo "<br>" . $GLOBALS['html_filename'];
		file_put_contents($GLOBALS['html_filename'], $line, FILE_APPEND);
	}
	else
	{
		echo $line;
	}
}


function buildHTML()
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
	startPage();
	$files=getFileList();
    // add other files
	$files[]= '_contact';
	$files[]= '_disclaimer';
	foreach ($files as $filename)
	{
		//echo nl2br("[". $filename . "]\n");							
		if (($filename == "1_" . $App_Home) || (substr($filename,$LenHome) == "2_" . $App_Home))
		{
			$num_files_home++;
			$files_home[$num_files_home]=$filename;
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
	
	
	echo "<H1>Build</H1>";
	foreach ($files as $filename)
	{
		$menu_levels=filenameToMenulevels($filename);
		$level1=$menu_levels[0];
		$level2=$menu_levels[1];
		$level3=$menu_levels[2];
		$html_filename=html_filename_from_filename($filename);
		echo $filename . " -> " . $html_filename . '<br>' . PHP_EOL;
		echo "*** l1=" . $level1 . ", l2=" . $level2 . "<br>";
        $GLOBALS['html_filename'] = $html_filename;
        unlink($html_filename);
        readDefaults();
	//	showHeader();
	//	showMenu($level1, $level2);

/*
		if (($l_sitemap == "1") or ($l_contact == "1") or ($l_disclaimer == "1") or ( $l_srchterm !="" ) or ($l_check =="1" or ($l_about == "1")))
		{
			if ($l_sitemap == "1")
			{
				displaySitemap();
			}
			if ($l_contact == "1")
			{
				displayContact();
			}
			if ($l_disclaimer == "1")
			{
				displayDisclaimer();
			}
			if  ( $l_srchterm !="" )
			{
				showSearch($l_srchterm);
			}
			if  ( $l_check =="1" )
			{
				check();
			}
			if  ( $l_about =="1" )
			{
				displayAbout();
			}
		} 
		else
		{

		showPage($level1, $level2, "");
		showFooter();
*/
	}

	endPage();
}

function html_filename_from_filename($filename)
{
	// if filename starts with '1_' '2_' or '3_' then this is a menu item
	// if it starts with un '_' (underscore) then it is another type
	
	$menulevels=filenameToMenulevels($filename);
	$result = html_filename_from_levels($menulevels[0], $menulevels[1], $menulevels[2]);
	return $result;
}
function html_filename_from_levels($level1, $level2, $level3)
{
     $result="";
     if ($level2 == "" & $level3 == "")
     {  // level1
		$level1text=str_replace(" ", "_", $level1);
		$result = $level1text . ".html";
     }
     elseif ($level3 == "")
     {  // level2
		$level1text=str_replace(" ", "_", $level1);
		$level2text=str_replace(" ", "_", $level2);
		$level2text=remove_order_digit($level2text);
		$result = $level1text . "_" . $level2text . ".html";
     }
     else
     {  // level3

     }
	switch ($level)
	{
		case '1_':

			break;
		case '2_':

			break;
		case '3_':
			break;
		default:
			$other=substr($filename,1,strlen($filename)-1);
			$result =  $other . ".html";
			break;
	} 
	return $result;
}
function inlineFunction($functionname, $argument="")
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
		echo formatUserMessage('Inline-function "' . $functionname . '" not found');
	}
}
function theInlineTestFunction()
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


function showMenu($menu_level1,$menu_level2="")
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
	if ($App_NavbarTop == "dark") 
        {
             $navbar="navbar-dark bg-dark";
        }
        else
        {
             $navbar="navbar-light bg-light";
             $navbar="navbar-light";
        }
	echo '<nav class="navbar navbar-expand-lg ' . $navbar . '" style="background-color:' . $App_BGColorNavbarTop . '">' . PHP_EOL;
    echo '  <div class="container-fluid">'. PHP_EOL;
	echo '  <a class="navbar-brand" href="index.php">' . PHP_EOL;
	echo '    <img src="'. constant('ROOTDIR') . '/images/' . $App_Logo . '" height="50" loading="lazy" alt="' . $App_Tagline . '">' .PHP_EOL;
	echo '  </a>' . PHP_EOL;
 	//
 	echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">' .PHP_EOL;
    echo '<span class="navbar-toggler-icon"></span>' . PHP_EOL;
    echo '</button>' . PHP_EOL;
	//
    echo '<div class="collapse navbar-collapse justify-content-between" id="myNavbar">' . PHP_EOL;
	echo '<ul class="navbar-nav  me-auto mb-2 mb-lg-0">' . PHP_EOL;
//
	$menuitems[]="";
	$menuitems=getFileList();
  //  var_dump($menuitems);
	$level1_list=getLevel1List();
	//var_dump($level1_list);
	foreach ($level1_list as $level1_menuitem)
	{
		if ($level1_menuitem == $menucontext_level1) $isActive=true; else $isActive=false;
		$level2_list=getLevel2List($level1_menuitem);
		//var_dump($level2_list);
        if (count($level2_list) > 0) $hasDropdown=true; else $hasDropdown=false;
 		if ($hasDropdown) $dropdown=' dropdown'; else $dropdown='';
 
 		echo '<li class="nav-item' . $dropdown . '">' . PHP_EOL;
 	
 		if ($hasDropdown)
 		{
 		//	echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . PHP_EOL;
 			echo '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . PHP_EOL;
 			echo $level1_menuitem . PHP_EOL;
 			echo '</a>' . PHP_EOL;
 		}
 		else
 		{
 			if ($isActive)
 			{
 				echo '<a class="nav-link active" href="#">' . $level1_menuitem . '</a>' . PHP_EOL;
 			}
 			else
 			{
 				echo '<a class="nav-link" href="index.php?menu=' . $level1_menuitem . '">' . $level1_menuitem . '</a>' . PHP_EOL;
			}
 		}
        if ($hasDropdown == true)
        {
        	echo '<ul class="dropdown-menu" >' . PHP_EOL;
			foreach ($level2_list as $level2_menuitem)
			{
				$menutext=remove_order_digit($level2_menuitem);
				echo '<li><a class="dropdown-item" href="index.php?menu=' . $level1_menuitem . '&submenu=' . $level2_menuitem . '">' . $menutext . '</a></li>' . PHP_EOL;
			}
			echo '</ul>' .PHP_EOL;
        }
		echo '</li>' .PHP_EOL;
	}
	echo '</ul>' . PHP_EOL;

	// search option
    //  name="srch-term"  is the argument for index.php
//	echo '<div class="d-flex justify-content-end">' ;
	echo '<form class="d-flex">' . PHP_EOL;
	echo '<div class="input-group">' .PHP_EOL;
    echo '  <input class="form-control me-2" name="srch-term" type="search" placeholder="' . $App_Search . '" aria-label="' . $App_Search . '">' . PHP_EOL;
    echo '  <button class="btn btn-outline-success" type="submit">' . $App_Search . '</button>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
    echo '</form>' . PHP_EOL;
  

	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
	echo '</nav>' . PHP_EOL;

}

function echo_ident($ident, $text)
{
	
	echo $text . PHP_EOL;
}

function showSearch($search_text)
{
	include constant('SCRIPTSDIR') . "/appinfo.inc.php";
	startPage();

	echo '<h2>' . $App_SearchResult . ' : "' . $search_text . '"</h2>' . PHP_EOL;
	$result = searchSite($search_text);
	if ($result !== false)
	{
		echo $result;
	}
	else
	{
		echo '<p class="text-danger">' . $App_SearchNotFound . '</p>' . PHP_EOL;
	}
	endPage();
}
function getLevel1FromLevel1File()
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

function getLevel1List()
{
	$level1_list=array();
	$level1_list=getLevel1FromLevel1File();
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

function getLevel2List($level1_menu)
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
		//    echo "menuitem " . $i . " " . $menuitems[$i];
		// remove numeric order prefix if present
            if (is_numeric(substr($menuitems[$i],$match_length,1)))
			{
				//echo " numeric  !! ";
				$level2_list[]=substr($menuitems[$i],$match_length);
			//	$level2_list[]=substr($menuitems[$i],$match_length+1);
			}
			else
			{
				$level2_list[]=substr($menuitems[$i],$match_length);
			//	$level2_list[]=substr($menuitems[$i],$match_length);
			}
		}
	}
	//asort($level2_list);
	return $level2_list; 
}
function remove_order_digit($menuitem)
{
	if (is_numeric(substr($menuitem,0,1)))
	{
		//echo " numeric  !! ";
		$menuitem=substr($menuitem,1);
	}
	return $menuitem;
}
function getLevel3List($level1_menu, $level2_menu)
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
	
function showPage($level1_menu, $level2_menu=Null, $level3_menu=Null)
{
	startPage();
	$level2_menutext=remove_order_digit($level2_menu);
	breadCrumbsBS($level1_menu, $level2_menutext, $level3_menu);
	//
	// now check if level 3 menu items are available...
	$level3_list="";
	if ($level2_menu != "")
	{
		$level3_list=getLevel3List($level1_menu, $level2_menu);
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
		processUserFile(constant('ROOTDIR') . "/" . "1_" . $level1_menu . ".txt");
	}
	if ($level2_menu != "") 
	{
		processUserFile(constant('ROOTDIR') . "/" . "2_" . $level1_menu . "_" . $level2_menu . ".txt");
	}
	if ($level3_menu != "") 
	{
		echo '<!-- start processUserFile() for level3 -->' .PHP_EOL;
		processUserFile(constant('ROOTDIR') . "/" . "3_" . $level1_menu . "_" . $level2_menu . '_' . $level3_menu . ".txt");
	}
	banner();

	endPage(); 
	
	
}


function banner()
{
	/*
          <div class="container"> 
               <div class="row">
                  <div class="col">Left column</div> 
                  <div class="col">Middle column</div> 
                  <div class="col">Right column</div> 
               </div>
            </div>

*/
	echo '<div class="container-fluid">' . PHP_EOL;
   	echo '<div class="row footer" style="min-height: 50px;"><!-- BEGIN ROW banner -->' . PHP_EOL;
	echo '</div><!-- END ROW for banner-->'. PHP_EOL; // close row,
	echo '<div class="row"><!-- BEGIN ROW banner -->' . PHP_EOL;

			// create column
			echo '<div class="col"><!-- BEGIN COL banner -->'. PHP_EOL;
			$width=100;
			$height=60;
            $url="http://www.rovece.nl/?page_id=362";
			$target=' target="_blank"';
			$style=' style="width:' . $width . 'px;height:' . $height . 'px;"';
			$style=' style="height:' . $height . 'px;"';
			$style=' style="width:' . $width . 'px;"';
			$image_path=constant('ROOTDIR') . "/images/banner/mastercam_rovece.jpg";
			$description="-----";
			$html='<a href="' . $url . '"' . $target ;
			$html.=' title="' . $description . '" ' . '><img src="' . $image_path . '"' . $style . ' border="0" alt="' . $description . '"></a>'; 
			$html.='</a>';
			echo '<div class="mx-auto" style="width:150px">';
            echo $html;
			echo '</div>';
			echo '</div><!-- END COL for banner-->'. PHP_EOL; // close col
			echo '<div class="col"><!-- BEGIN COL banner -->'. PHP_EOL;
			$image_path=constant('ROOTDIR') . "/images/banner/kipp.jpg";
			$description="-----";
			$url="https://www.kippcom.nl/nl/nl/Producten/Spantechniek/Nulpunt-spantechniek/Nulpuntspansysteem.html";
			$html='<a href="' . $url . '"' . $target ;
			$html.=' title="' . $description . '" ' . '><img src="' . $image_path . '"' . $style . ' border="0" alt="' . $description . '"></a>'; 
			$html.='</a>';
			echo '<div class="mx-auto" style="width:150px">';
            echo $html;
			echo '</div>';
			echo '</div><!-- END COL for banner-->'. PHP_EOL; // close col
			echo '<div class="col"><!-- BEGIN COL banner -->'. PHP_EOL;
			$image_path=constant('ROOTDIR') . "/images/banner/greenchoise.jpg";
			$description="-----";
			$url="https://www.greenchoice.nl/";
			$html='<a href="' . $url . '"' . $target ;
			$html.=' title="' . $description . '" ' . '><img src="' . $image_path . '"' . $style . ' border="0" alt="' . $description . '"></a>'; 
			$html.='</a>';
			echo '<div class="mx-auto" style="width:150px">';

            echo $html;
 			echo '</div>';
	//processUserFile(constant('ROOTDIR') . "/" . "banner.txt");
			// end column
			echo '</div><!-- END COL for banner-->'. PHP_EOL; // close col

        	 // end row
			echo '</div><!-- END ROW for banner-->'. PHP_EOL; // close row,
        	echo '<div class="row footer" style="min-height: 50px;"><!-- BEGIN ROW banner -->' . PHP_EOL;
			echo '</div><!-- END ROW for banner-->'. PHP_EOL; // close row,
			echo '</div>'. PHP_EOL; // close container,

	
}
function breadCrumbsBS($mLevel1, $mLevel2, $mLevel3)
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


function processUserFile($filename)
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
				echo "<H1><EM>" . $lines[0] . "</EM></H1>" .PHP_EOL;
			}
			$bookmark_list=buildBookmarkList($filename);
			//var_dump($bookmark_list);
			$row_count+=1;
			echo '<div class="row"><!-- BEGIN first ROW -->' . PHP_EOL;
			for($i=1;$i<count($lines);$i++)
			{
				if (substr($lines[$i],0,1) == ".")
				{
					// $heading=substr($lines[$i],1);
					// $heading=extended_ascii_html($heading);
					 $heading=getMacros(substr($lines[$i],1));
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
							echo '<h2>'. $heading . '</h2>' . PHP_EOL; // heading of column
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
							echo '<h2>'. $heading . '</h2>' . PHP_EOL; // heading of column
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
						echo formatUserMessage('no bookmarks found on this page','W') . PHP_EOL;
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
//						echo '<a data-bs-toggle="collapse" href="#collapse1">Click to expand / collapse</a>' . PHP_EOL;

						echo '<a class="btn btn-primary" data-bs-toggle="collapse" href="#collapse1" role="button" aria-expanded="true" aria-controls="collapse1">&emsp;' . $bookmark_heading . '&emsp;</a>' . PHP_EOL;					
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
					echo getMacros($lines[$i]) . PHP_EOL; 
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

function buildBookmarkList($filename)
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
						$bookmark_list[]=extendedAsciiHtml($output);
					}
				}
			}
		}
	}
	return $bookmark_list;
}

function getFileList()
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
					$path_parts = pathinfo($file);
					if (isset($path_parts['extension']))
					{
						$extension=$path_parts['extension'];
					}
					$filename=$directory . '/' . $file; 
					// only extention .txt
					if ($extension == "txt")
					{
						$level=substr($file,0,1);
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

function getTagContents($input, $tag)
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
function getMacros($input)
{
	global $blnPassThrough;
	$result = getTagContents($input, "PASS");
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
	$result = getTagContents($input, "INLINE");
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

		inlineFunction($function_name, $argument);
	}

	//

	//
	//
	$result = getTagContents($input, "URL");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$output=lookupUrl($TagContent);
	}
	//

	//
	$result = getTagContents($input, "IMG");
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
		
		$output=lookupImage($name,$width,$height, $caption);
	}
	//
	$result = getTagContents($input, "IMGPAGE");
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
		$url=filenameToUrlMenu($filename);
		$output=lookupImageUrl($name,$width,$height, $caption, $url);
	}
	//
	$result = getTagContents($input, "IMGLINK");
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
		$url=lookupLinkUrl($link);
		//echo 'url = ' . $url;
		$output=lookupImageUrl($name,$width,$height, $caption, $url);
	}
	//
	$result = getTagContents($input, "LINKPAGE");
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
		$output='<a href="' . filenameToUrlMenu($filename) . '">' . $text . '</a>';
//				$output=filename_to_href_menu($filename);
//		$output=lookup_image_url($name,$width,$height, $caption, $url);
	}
	//
	$result = getTagContents($input, "SPECS");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$output=lookupSpecs($TagContent);
	}
	//
	$result = getTagContents($input, "CCT");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$output=lookup_cct($TagContent);
	}
//
	$result = getTagContents($input, "BM");
	if ( $result !== false)
	{
		$LeadText=$result[0];
		$TagContent=$result[1];
		$TrailText=$result[2];
		$output.='<a name="BM_' . $TagContent . '" href="#BM_" >' . $TagContent . '</a>';
	}

	//

 
	$ReturnText=extendedAsciiHtml($LeadText);
	$ReturnText.=extendedAsciiHtml($output);
	if ($TrailText != "")
	{
		$TrailText=getMacros($TrailText);
		$ReturnText.=extendedAsciiHtml($TrailText);
	}
	//echo "done with macros()";
	return $ReturnText;
}


function formatUserMessage($text, $severity=null)
{
	$bs_attribute="text-danger";
	$message_prefix="Error";
	if ($severity === null )
	{
		$errText='<p class="' . $bs_attribute . '"><b>' . $message_prefix . ' : ' .  $text . '</b></p>';
	}
	else
	{
		switch($severity)
	    {
			case 'I': 
				$bs_attribute="text-success";
				$message_prefix="Ok";
				break;
			case 'W': 
				$bs_attribute="text-warning";
				$message_prefix="Warning";
				break;
			default:
				break;
		}
		$errText='<p class="' . $bs_attribute . '"><b>' . $message_prefix . ' : ' .  $text . '</b></p>';

	}
	return $errText;

}



function extendedAsciiHtml($extended_ascii_text)
{
	$ReturnText="";
	for ($i=0; $i < strlen($extended_ascii_text); $i++)
	{
	$ReturnText .= replace8bitHtml($extended_ascii_text[$i]);
	}
	//echo "text = " . $extended_ascii_text;
	
	//return $ReturnText;
	return $extended_ascii_text;
}

function replace8bitHtml($character)
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
		case 232: return '&egrave;'; break;
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
	startPage();
	//set_time_limit(0);
	echo '<h2>Check of your URL links as used in the pages</h2><br>please wait ....<br>';
	$html=checkUrlPages();
	echo $html;
	echo '<br><h2>Check of your external URL links</h2><br>please wait ....<br>';
	$html=checkUrlInternet();
	echo $html;
	echo '<br><h2>Check of your images</h2><br>please wait ....<br>';
	$html=checkImagePages();
	echo $html;
	echo '<br><h2>Check images in image folder</h2><br>please wait ....<br>';
	$html=checkImagesFolder(constant('ROOTDIR') . '/images');
	echo $html;
	echo '<br><br><br><br>' .PHP_EOL;
}

function displaySitemap()
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
	startPage();
	$files=getFileList();
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
		$title=sitemapGetheadingFromFile($directory . "/" . $filename . ".txt");
 		$url=filenameToUrlMenu($filename);
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
						$title=sitemapGetheadingFromFile($directory . "/" . $filename . ".txt");
				 		$url=filenameToUrlMenu($filename);
						$level2=substr($filename,$len_level1+1);
						$level2text=remove_order_digit($level2);
						echo '...<a href="' . $url . '">' . $level2text . '</a><I>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $title . '</i><br>' . PHP_EOL;
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

	endPage();
}

function sitemapGetheadingFromFile($filename)
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
	$heading = removeCr($heading);
	return $heading;
}

function removeCr($input)
{
	return(preg_replace("/[\\n\\r]+/", "", $input));
}


function showHeader()
{
	include(constant('SCRIPTSDIR') . "/appinfo.inc.php");
	global $menucontext_level1;
	global $menucontext_level2;
	global $DefaultErrors;
	$PageTitle=$App_Name . ' : ' . $App_Tagline; //. ", " . $menucontext_level1)
	echoo( '<!doctype html>' . PHP_EOL);
	echoo( '<!-- Created by Webbuilder Chris van Gorp -->' . PHP_EOL);
	echoo('<!--      based on BootStrap 5 -->' . PHP_EOL);
	echoo('<html lang="' . $App_Language . '">' . PHP_EOL);
	echoo('<head>' . PHP_EOL);
	echoo('<meta charset="utf-8">' . PHP_EOL);
	echoo('<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">' . PHP_EOL);
     echoo('<!-- Bootstrap CSS -->' . PHP_EOL);
	if ($App_BootstrapLocal == "TRUE")
     {
		echoo('<link rel="stylesheet" type="text/css" href="' . constant('CSSDIR') . '/bootstrap.min.css">' . PHP_EOL); 
	}
	else
	{
		echoo('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">' . PHP_EOL); 
	}
     echoo('<link rel="stylesheet" type="text/css" href="' . constant('CSSDIR') . '/webbuilder.css"><!-- Cascading Webbuilder style elements -->' . PHP_EOL);  // cascading our own style elements.
     echoo('<link rel="stylesheet" type="text/css" href="' . constant('USERCSSDIR') . '/custom.css"><!-- Cascading user style elements -->' . PHP_EOL);  // cascading our own style elements.
	echoo('<link rel="shortcut icon" type="image/x-icon" href="' . constant('ROOTDIR') . '/images/' . $App_Icon . '">' . PHP_EOL);
	echoo('<link rel="apple-touch-icon" href="' . constant('ROOTDIR') . '/images/' . $App_Icon . '">' . PHP_EOL); // for Apple products viewing this page, same as favicon
	echoo('<meta name="generator" content="Webbuilder, Chris van Gorp">' . PHP_EOL);
	echoo('<meta name="rights" content="' . $App_Copyright . '"/>' . PHP_EOL);
	echoo('<meta name="description" content="' . $App_Description . '">' . PHP_EOL);
	echoo('<meta name="keywords" content="' . $App_Keywords . '">' . PHP_EOL);
	if ($DefaultErrors != "")
	{
		echoo('<!--  found some errors in configuration file -->' . PHP_EOL);
		echoo('<!--  ' . $DefaultErrors . ' -->' . PHP_EOL);
	}
	echoo( '<title>' . $PageTitle . '</title>' . PHP_EOL);
	echoo('</HEAD>' . PHP_EOL);
	echoo('<BODY>' . PHP_EOL);
	echoo('<a id="TopOfPage"></a>' . PHP_EOL); 
}

function startPage()
{
	echo '<div class="container-fluid" style="margin-bottom:30px;"><!-- START CONTAINER -->' . PHP_EOL;  
}

function endPage()
{
	echo '<br>' . PHP_EOL;
	echo '</div><!-- END CONTAINER -->' . PHP_EOL;
}

function showFooter()
{
	include(constant('SCRIPTSDIR') . "/appinfo.inc.php");
	//echo  "<HR>";
	$home='<a href="index.php">Home</a>';
	$disclaimer='<a href="https://pa7rhm.nl/index.php?disclaimer=1">Disclaimer</a>';
	$sitemap='<a href="index.php?sitemap=1">Site Map</a>';
	$contact='<a href="index.php?contact=1">Contact</a>';
	$copyrightscripting='(' . constant('SCRIPT_TITLE') . ' by Chris van Gorp)';
	$spacing='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	if ($App_NavbarBottom == "dark") 
        {
             $navbar="navbar-dark";
        }
        else
        {
             $navbar="navbar-light";
        }
		
	echo '<nav class="navbar fixed-bottom navbar-solid navbar-expand-lg ' . $navbar . '"  style="background-color:' . $App_BGColorNavbarBottom . ';">' . PHP_EOL;
    echo '  <div class="container-fluid">';
    echo '  <a class="navbar-brand" href="#TopOfPage"  style="font-size:2vw;">' . $App_Name . ' : <small class="text-muted">' . $App_Tagline . '</small></a>' . PHP_EOL;
 	echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myFooterNavbar" aria-controls="myFooterNavbar" aria-expanded="false" aria-label="Toggle navigation">' .PHP_EOL;
    echo '<span class="navbar-toggler-icon"></span>' . PHP_EOL;
    echo '</button>' . PHP_EOL;
	//
    echo '<div class="collapse navbar-collapse justify-content-between" id="myFooterNavbar">' . PHP_EOL;
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
	//echo ' Designed by&nbsp;&nbsp;&nbsp;' . PHP_EOL;
    echo '<a href="index.php?about=1"><b>About this website</b></a>' . PHP_EOL;
    echo '</ul>' . PHP_EOL;

	echo '</div>' . PHP_EOL;
  echo '</div>' . PHP_EOL;
	
	echo '</nav> ' . PHP_EOL;
	echo '<!-- Optional JavaScript --> ' . PHP_EOL;
    echo '<!-- jQuery first, then Popper.js, then Bootstrap JS --> ' . PHP_EOL;
    if ($App_BootstrapLocal == "TRUE")
    {
	    // bundle includes Popper .
	    echo '<script src="' . constant('JSDIR') . '/bootstrap.bundle.min.js"></script><!-- Bootstrap script -->' . PHP_EOL;

    }
    else
    {
    	echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>' . PHP_EOL;
    }
	echo "</BODY>" . PHP_EOL;
	echo "</HTML>" . PHP_EOL;
}
function displayAbout()
{
	include(constant('SCRIPTSDIR') . "/appinfo.inc.php");
	startPage();
    $giturl ='https://github.com/OldChris/webbuilder';
	echo '<h2>About WebBuilder</h2>' . PHP_EOL;
	echo '<br>The tool used to build this website is named WebBuilder and was created by Chris van Gorp in 2012.' . PHP_EOL;
	echo '<br>In 2020 Bootstrap 4 replaced the original CSS to make it responsive and better looking.' . PHP_EOL;
	echo '<br>In 2022 Bootstrap 4 is replaced by Bootstrap 5.<br>' . PHP_EOL;
	echo '<br>WebBuilder is opensource and can be downloaded from <a href="' . $giturl . '" target="_blank">Github</a>' . PHP_EOL;

 
    // https://docs.github.com/en/rest/reference/repos#get-the-latest-release

    $gitapiurl ='https://api.github.com/repos/OldChris/webbuilder';
    $giturlVersion = $gitapiurl . '/releases';
    $headers=get_headers($giturlVersion);
    //echo 'headers[0] = ' . $headers[0] . PHP_EOL;

    $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
    $context  = stream_context_create($options);
    $data = file_get_contents($giturlVersion, false, $context); 
    $user_data  = json_decode($data, true);
    $tag = $user_data['0']['tag_name'];
    $appVersion=constant('APP_VERSION');
	$version_check = versionCheck($tag,  $appVersion);
    switch($version_check)
    {
	    case "=":
			echo formatUserMessage('Version is up to date : ' . $appVersion . ', Version on GitHub : ' . $tag , "I");
			break;
		case ">":
			echo formatUserMessage('Version older : ' . $appVersion . ', Version on GitHub : ' . $tag , "W");
			break;
		case "<":
			echo formatUserMessage('Version newer : ' . $appVersion . ', Version on GitHub : ' . $tag , "I");
			break;
		default:
			echo formatUserMessage('Error checking version : ' . $version_check  , "W");
			
    }


    if ($App_BootstrapLocal == "TRUE")
    {
    	echo '<br>Bootstrap is loaded from local server<br>' . PHP_EOL;

    }
    else
    {
    	echo '<br>Bootstrap is loaded from CDN<br>' . PHP_EOL;
    }
	
	CreateRobotsTxtSitemapXML();
	echo '<br><br><h2>Perform checks on your website</h2>' . PHP_EOL;
	echo '<br><a href="index.php?check=1">Check files and references to images and website. Mind you, this may take a while...</a><br>' . PHP_EOL;
	endPage();
}
function versionCheck($version1, $version2)
{
    $result="unknown";

	if ($version1 == "" || $version2 == "")
	{
		return "invalid versions, both versions missing";
	}
	// should start with lowercase 'v'
	if (substr($version1, 0, 1) != "v" || substr($version2, 0, 1) != "v")
	{
		return "invalid versions, version should start with v : for example : v1.0";
	}
	$version_parts1=explode(".", substr($version1,1));
	$version_parts2=explode(".", substr($version2,1));
	if ( count($version_parts1) != 2 || count($version_parts2) != 2)
	{
		return "versions invalid, count of version parts should be 2 (major and minor version number)";
	}
	if (!is_int(intval($version_parts1[0])) || !is_int(intval($version_parts1[1])) || !is_int(intval($version_parts2[0])) || !is_int(intval($version_parts2[1])))
	{
		return "versions not int, both major and minor version number should be an integer";
	}
     $major_1=intval($version_parts1[0]);
     $minor_1=intval($version_parts1[1]);
     $major_2=intval($version_parts2[0]);
     $minor_2=intval($version_parts2[1]);
     if ($major_1 > $major_2 )
	{
		return ">";
	}
	elseif ($major_1 == $major_2)
	{
		if ($minor_1 > $minor_2)
		{
			return ">";
		}
		elseif ($minor_1 == $minor_2)
		{
			return "=";
		}
		else
		{
			return "<";			
		}
	}
	else
	{
		return "<";				
	}
  	return $result;
}


function CreateRobotsTxtSitemapXML()
{
	$myfile = fopen("robots.txt", "w");
	$robots_text="User-agent: Googlebot";
	$robots_text .=  "\nDisallow: " . constant('ROOTDIR') . "/webbuilder/";
	$robots_text .=  "\nDisallow: " . constant('ROOTDIR') . "/images/";
	$robots_text .=  "\nDisallow: " . constant('ROOTDIR') . "/user_css/";
	$robots_text .=  "\nDisallow: " . constant('ROOTDIR') . "/user_scripts/";
	$robots_text .=  "\n\nUser-agent: *";
	$robots_text .=  "\nAllow: /";
	$robots_text .=  "\n\nSitemap: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/sitemap.xml' ;
	fwrite($myfile, $robots_text);
	fclose($myfile);
	// Sitemap.xml
	$myfile = fopen("sitemap.xml", "w");
	$sitemap_text  = '<?xml version="1.0" encoding="utf-8"?>';
     $sitemap_text .= "\n<!--Created by WebBuilder-->";
     $sitemap_text .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
	// for each file create a record
	$files=getFileList();
     // add other files
	$files[]= '_contact';
	$files[]= '_disclaimer';
	$files[]= 'about';
     $sitemap_text .= sitemap_record('https://em.pa7rhm.nl/');
	foreach ($files as $filename)
	{
		//echo nl2br("<br>xml [". $filename . "]\n");		
        $sitemap_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . filenameToUrlMenu($filename);
        $sitemap_text .= sitemap_record($sitemap_url);		
	}
     $sitemap_text .= "\n</urlset>";
     $sitemap_text .= "\n<!--Created by WebBuilder-->";
	fwrite($myfile, $sitemap_text);
	fclose($myfile);
}

function sitemap_record($url)
{
    $result  = "\n  <url>";
    $result .= "\n   <loc> " . $url . "/</loc>";
    $result .= "\n    <lastmod>2022-09-11</lastmod>";
    $result .= "\n    <changefreq>monthly</changefreq>";
    $result .= "\n    <priority>0.5</priority>";
    $result .= "\n  </url>";
	return $result;
}


function displayContact()
{
	startPage();
	processUserFile(constant('ROOTDIR') . "/_contact.txt");
	endPage();
} 

function displayDisclaimer()
{
	startPage();
	processUserFile(constant('ROOTDIR') . "/_disclaimer.txt");
	endPage();
} 

function filenameToUrlMenu($filename)
{
	$menulevels=filenameToMenulevels($filename);	
	$url="";
	$level=substr($filename,0,1);
		if (isset($GLOBALS['html_filename']) && $GLOBALS['html_filename'] != "")
	{
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
				if ($filename == "about") 
				{
					$url='index.php?about=1';	
				}
		}

	}
	else
	{
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
				if ($filename == "about") 
				{
					$url='index.php?about=1';	
				}
		}

	}
	return $url;
}

function filenameToHrefMenu($filename, $text="")
{
	$menulevels=filenameToMenulevels($filename);
	//$level1_menuitem, $level2_menuitem,	$level3_menuitem=explode(";", $menulevels);
	//echo 'filename = ' . $filename . ', 1= ' . $menulevels[0] . ', 2 = ' . $menulevels[1] . ', 3 = ' . $menulevels[2] . '<br>';
	$url=filenameToUrlMenu($filename);
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

function filenameToMenulevels($filename)
{
	//echo 'filename to menulevel ' . $filename . ' <br>';
	$level1_menuitem="";
	$level2_menuitem="";
	$level3_menuitem="";
	$other="";
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
		default:
			$other="bla";
               break;
	}
	//echo '<br>filename = ' . $filename . '<br>';
	//echo '1= ' . $pos1 . ', 2 = ' . $pos2 . ',  3 = ' . $pos3 . ', 4 = ' . $pos4 . '<br>';
//	echo " level1 = " . $level1_menuitem;
//	echo " level2 = " . $level2_menuitem;
//	echo " level3 = " . $level3_menuitem;


	$menuitems[]=$level1_menuitem;
	$menuitems[]=$level2_menuitem;
	$menuitems[]=$level3_menuitem;
	$menuitems[]=$other;
	return $menuitems;
	
}

?>