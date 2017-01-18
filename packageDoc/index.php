<center><h1>Package documentation viewer</h1>
<h3>select CMSSW version and Domain</h3>
</center>



<?php




$green_icon = "<img src=\"doc_green.png\" border=\"0\">";
$red_icon = "<img src=\"doc_red.png\" border=\"0\">";
$gray_icon = "<img src=\"doc_gray.png\" border=\"0\">";


$DOXYDIR = dirname(dirname($_SERVER['SCRIPT_FILENAME']));
$REFMANBASE = "http://".$_SERVER['SERVER_NAME'].dirname(dirname($_SERVER['PHP_SELF']));

$domain_GET = $_GET['domain'];
$version_GET = $_GET['version'];

$default_version="";

$documentedFiles = "";

$packages = array();


if ($version_GET != ""){
  $myFile = $DOXYDIR."/".$version_GET."/".$version_GET.".index";		
  $fh = fopen($myFile, 'r');
  $documentedFiles = fread($fh, filesize($myFile));
  $dfiles = explode("\n", $documentedFiles);       
  fclose($fh);		
}

function checkIfPackageDocumented($package){

	$bad = array("THE PACKAGE ADMINISTATOR SHOULD REPLACE THIS SENTENCE WITH HAND-WRITTEN DOCUMENTATION SAYING WHAT THE PACKAGE DOES",
		"aAuthor: computer-generated.");        

	$package = str_replace("/","_",$package);
	$package = "/".$package.".html";

	foreach ($GLOBALS['dfiles'] as $dfile){ 
	  if (strpos($dfile, $package)){

		$html = file_get_contents($GLOBALS['REFMANBASE'].$dfile);
		
		$empty = false;
		foreach($bad as $needle){
			
			if (strpos($html, $needle)){
			    $empty = true;
				
			}	
		}
		
		return array($dfile, $empty);
	  }
	}
	return "";	
}    


echo "<form action=\"?\" method=\"GET\">"; 
echo "<select name=\"version\">";

 	$output = trim(shell_exec("ls ../ -rs ".$DOXYDIR." | grep CMSSW | awk '{printf(\"%s:\", $2)}'"), ":");
        $arr = explode(":", $output);

        for ($i=0; $i<count($arr); $i++)
        {
   	     echo "<option ";
	     if ($arr[$i]==$version_GET) echo "selected ";
	     	echo "id=\"".$arr[$i]."\">".$arr[$i]."</option>";
	}

	$default_version = $arr[0];
            

echo "</select>";
                
echo "<select name=\"domain\" >";
	
		
	$dataurl = $REFMANBASE."/tcproxy.php?type=packages&release=CMSSW_4_4_2";
	$data = file_get_contents($dataurl);

	$data = str_replace(array("{","]}", "\""), "", $data);

	$domains = explode("], ", $data);

	foreach($domains as $domaindata){
	        
  	  	$domaindata = explode(": [", $domaindata);
  	  	$domain = $domaindata[0];

  		echo "<option ";
	  	if ($domain==$domain_GET) echo "selected ";
  		echo "id=\"".$domain."\">".$domain."</option>";

	  	if ($domain==$domain_GET){    			
			$packages = explode(", ", $domaindata[1]);
  		} 
	}

echo "</select>";
     
echo "<input type=\"submit\" value=\"search\">";
echo "</form>";
echo "<br/>";


             
echo "<table width=\"400\">";
echo "<tr bgcolor=\"#cccccc\"><td>Package</td><td>Status</td></tr>";


foreach($packages as $package){
	$link = $package;
	$found = $red_icon;		
	$ret = checkIfPackageDocumented($package);
	if ($ret != ""){
		$found = $green_icon;
		if ($ret[1] == true){
		   $found=$gray_icon;
		}
		$link = "<a target=\"_blank\" href=\"".$REFMANBASE.$ret[0]."\">".$package."</a>";
	}	
      echo "<tr><td>".$link."</td><td align=\"center\">".$found."</td></tr>";
    }
 
echo "</table>";

echo "<hr/>
Status meaning:<br/> 
<b>".$green_icon."</b> -  documented <br/> 
<b>".$red_icon."</b> -  not documented (file does not exist in reference manual) <br/>
<b>".$gray_icon."</b> -  package documentation file exists, but missing content<br/>
";


       
?>
