<html>
<head>
<link type="text/css" rel="stylesheet" href="/SDT/doxygen/doxygen_php_files/doxygen.css">
<script type="text/javascript" src="common/jquery-1.10.2.min.js"></script>
<title> CMSSW Reference Manual </title>
<style>
.roundbox{
	margin:5px;
	padding:5px;
	-moz-background-clip: border;
	-moz-background-inline-policy: continuous;
	-moz-background-origin: padding;
	-moz-border-radius-bottomleft: 15px;
	-moz-border-radius-bottomright: 15px;
	-moz-border-radius-topleft: 15px;
	-moz-border-radius-topright: 15px;
	-webkit-border-radius: 15px;
	-moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
	background: #cccccc none repeat scroll 0 0;
	width:115px;	
}

</style>
<script>
function filter()
{
    var version = $('#filter').val();
    $("a").each(function() {
        if($(this).text().indexOf('Contact') != -1) return;
        if($(this).text().indexOf('ECAL API Documentation') != -1) return;
        if($(this).text().toLowerCase().indexOf(version.toLowerCase()) == -1)
            $(this).parent().css({'display':'none'}); // hide
        else
            $(this).parent().css({'display':'block'}); // show
    })
}
$(document).ready(function() {
    $('#filter').bind("change paste keyup", filter);
});
</script>
</head>
<body style="padding:20px; background-color:lightBlue;">
<center>
	<h1>CMSSW Reference Manual (doxygen)</h1>
	<h2>Click on a version </h2>
    <div> <b>Filter</b>: <input type="text" id="filter" value=""> </div>
</center>

<?php

function getEcalDirList()
{

   $output = trim(shell_exec("ls -rs /data/doxygen/ecaldoc | grep ECAL | awk -F \" \" '{print $2}'"));
   $arr = explode("\n", $output);
   
   foreach($arr as $file){
        //echo "-".$file;

	$suboutput = trim(shell_exec("ls -rs /data/doxygen/ecaldoc/".$file." | grep ECAL | awk -F \" \" '{print $2}'"));
   	$subarr = explode("\n", $suboutput);	

	foreach($subarr as $subfile){
		//echo "--".$subfile;
		$version_list[$file][] = $subfile;
	}
  }	
  	return $version_list;
}


function getDirList()
{

   $output = trim(shell_exec("ls -rs /data/doxygen | grep CMSSW | awk -F \" \" '{print $2}'"));
   $arr = explode("\n", $output);
   
   foreach($arr as $file){
      if (strpos($file, "CMSSW") === 0) {
	if (strpos($file, "_X_") === false){
          $version = explode("_", $file);
	  $version_list[$version[1]][$version[2]][$version[3]][] = $file;
	}
	else{
	  $nightbuilds[$file] = $file;
	}
      }	
   }
//  return $version_list;
  return array ( $version_list, $nightbuilds );

}



$BASE = "http://cmssdt.cern.ch/SDT/doxygen/";


// ECAL RELEASES

//$level1 = getEcalDirList();

//krsort($level1);
//while (list ($key1, $values) = each ($level1) ){

//     echo "<hr><div class=\"roundbox\"><b>".$key1."</b></div>";    

//      echo "<div class=\"tabs\" style=\"margin-left:150px; width:auto\"><ul class=\"tablist\" style=\"margin:0px;\">";

//      sort($values);
//      while (list ($key, $value) = each ($values) ) { 
//	echo "<li><a target=\"_blank\" href=".$BASE."ecaldoc/".$key1."/".$value."/doxygen>".$value."</a></li> ";
//      }
//      echo("</ul></div>");
//    }

// END OF ECAL

//echo "<hr>";



?>
<div class="tabs" style="margin:10px;">
    <ul class="tablist" style="margin:0px;">
        <li><a target="_blank" href="https://twiki.cern.ch/twiki/bin/view/CMSPublic/SWGuidePackageDocumentation">Package Documentation Guide</a></li>
        <li><a target="_blank" href="http://cmsdoxy.web.cern.ch/cmsdoxy/cmsrel/">CMSSW Release List</a></li>
        <li><a target="_blank" href="http://cms-ecaldaq-doxygen.web.cern.ch/cms-ecaldaq-doxygen/"> ECAL API Documentation </a></li>
    </ul>
</div>
<?php

//echo ("<div class=\"tabs\" style=\"width:212px\"><ul class=\"tablist\" style=\"margin:0px;\"> <li><a target=\"_blank\" href=\"http://cms-ecaldaq-doxygen.web.cern.ch/cms-ecaldaq-doxygen/\"> ECAL API Documentation </a></li></ul></div></br>");



// CMSSW and NB RELEASES

$dirList = getDirList();
 
$level1 = $dirList[0];
//$level1 = getDirList();

$nb = $dirList[1];


// NIGHT BUILDS

echo "<hr><div class=\"roundbox\"><b><center> Night builds </center> </b></div>";
echo "<div class=\"tabs\" style=\"margin-left:150px; width:auto\"><ul class=\"tablist\" style=\"margin:0px;\">";

while (list ($key, $value) = each ($nb) ) { 
	echo "<li><a target=\"_blank\" href=".$BASE.$value."/doc/html>".$value."</a></li> ";
     }

echo("</ul></div>");

// END OF NB
echo "<hr>";

// CMSSW RELEASES

krsort($level1);
while (list ($key1, $level2) = each ($level1) ){ 

  krsort($level2);
  while (list ($key2, $level3) = each ($level2) ) { 

    krsort($level3);
    echo "<hr><div class=\"roundbox\"><b>CMSSW_".$key1."_".$key2."_* </b></div>";
    while (list ($key3, $values) = each ($level3) ) { 

      echo "<div class=\"tabs\" style=\"margin-left:150px; width:auto\"><ul class=\"tablist\" style=\"margin:0px;\">";

      sort($values);
      while (list ($key, $value) = each ($values) ) { 
	echo "<li><a target=\"_blank\" href=".$BASE.$value."/doc/html>".$value."</a></li> ";
      }
      echo("</ul></div>");
    }
  }
}

// END OF CMSSW



?>
<br>
<hr>
<div>
<i>Please avoid using links from pre-releases, they will be removed after their production releases.</i>
<center><a href="mailto:cmsdoxy@cern.ch">Contact</a></center>
</div>
</body>
</html>
