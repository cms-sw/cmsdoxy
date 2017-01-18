<?php

#echo "labas";


function getUrl($url){
	$html = file_get_contents($url);
	return $html;
}


switch ($_GET['type'])
{

case 'managers':
	$html = getUrl("https://cmstags.cern.ch/tc/CategoriesManagersJSON");

	$lists = explode("}, {", $html);
	echo str_replace("[{", "{", $lists[0]."}");

break;

case 'users':
	$html = getUrl("https://cmstags.cern.ch/tc/CategoriesManagersJSON");

	$lists = explode("}, {", $html);
	echo str_replace("}]", "}", "{".$lists[1]);


break;


case 'packages':
	if (isset($_GET['release']) && $_GET['release'] != ""){
		$release = $_GET['release'];	
		$html = getUrl("https://cmstags.cern.ch/tc/CategoriesPackagesJSON?release=".$release);
		echo $html;
	}
	else{
		echo "CMSSW release version is not provided";
	}
break;

case 'tags':

	if (isset($_GET['release']) && $_GET['release'] != ""){
		$release = $_GET['release'];	
		$html = getUrl("https://cmstags.cern.ch/tc/ReleaseTagsXML?release=".$release);

		$html = str_replace("\"", "", $html);
		$html = str_replace("<tags>\n", "", $html);
		$html = str_replace("\n</tags>", "", $html);
		$html = str_replace("<tag name=", "", $html);
		$html = str_replace("tag=", "", $html);		
		$html = str_replace(" />", "", $html);		
		$html = str_replace("  ", "", $html);		
		$html = str_replace("\n\n", "", $html);		

		
		echo $html;
	}
	else{
		echo "CMSSW release version is not provided";
	}


break;


default:

	echo "How to use?<br/> 
		Examples:<br/>
		<a href=tcproxy.php?type=managers>tcproxy.php?type=managers</a> <br/>
		<a href=tcproxy.php?type=users>tcproxy.php?type=users</a> <br/>
		<a href=tcproxy.php?type=packages&release=CMSSW_4_4_2>tcproxy.php?type=packages&release=CMSSW_4_4_2</a> (change release) <br/>
		<a href=tcproxy.php?type=tags&release=CMSSW_4_4_2>tcproxy.php?type=tags&release=CMSSW_4_4_2</a> (change release)";
	
}

                          
?>