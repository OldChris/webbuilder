<?php
/*
 * this file is part of
 * PHP WebBuilder by Chris van Gorp
 * Version : 15 November 2012
 */
// only change rootdir if required
// example : define('ROOTDIR','mywebfolder');
define('ROOTDIR','rootdir');
// do not change below this line
define('SCRIPTSDIR',constant('ROOTDIR') . '/webbuilder/scripts');

include_once(constant('SCRIPTSDIR') . "/functions.inc.php");


if (isset($_GET['menu']))       { $l_menu=$_GET['menu']; }      	else { $l_menu="Home"; }
if (isset($_GET['submenu']))  	{ $l_submenu=$_GET['submenu']; }	else { $l_submenu=""; }
if (isset($_GET['menul3']))  	{ $l_menul3=$_GET['menul3']; }	    else { $l_menul3=""; }
if (isset($_GET['sitemap']))  	{ $l_sitemap=$_GET['sitemap']; }	else { $l_sitemap=""; }
if (isset($_GET['contact']))  	{ $l_contact=$_GET['contact']; }	else { $l_contact=""; }
if (isset($_GET['disclaimer']))	{ $l_disclaimer=$_GET['disclaimer']; }	else { $l_disclaimer=""; }
if (isset($_GET['srch-term']))	{ $l_srchterm=$_GET['srch-term']; }	else { $l_srchterm=""; }
if (isset($_GET['check']))   	{ $l_check=$_GET['check']; }    	else { $l_check=""; }
if (isset($_GET['about']))   	{ $l_about=$_GET['about']; }    	else { $l_about=""; }
//?srch-term=tank
//
readDefaults();
showHeader("norefresh");


showMenu($l_menu, $l_submenu);


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
  showPage($l_menu, $l_submenu, $l_menul3);
}

showFooter();


?>
	