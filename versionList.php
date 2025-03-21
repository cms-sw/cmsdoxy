<html>
<head>
<script type="text/javascript">

function setSelected(){

   var l = parent.location.href;
   var l_array=l.split("/");

   for(var i=0; i < l_array.length; i++) {
	var value = l_array[i];
        if (value.indexOf('CMSSW_') != -1){
	    var vers = document.getElementById(value);
		vers.selected = true;
        }
    }
}

function redir(version){

   var l = parent.location.href;
   var l_array=l.split("/");
   var newUrl=l;
   for(var i=0; i < l_array.length; i++) {
	var value = l_array[i];
        if (value.indexOf('CMSSW_') != -1){
            newUrl = l.replace(value, version);

        }
   }
parent.location.href = newUrl;
}
</script>

</head>
<body bgcolor="#b7cade" onload="setSelected()">

<font face="Arial" size="2">Current Version:</font>
<select onchange="redir(this.value);" >
<?php
	$DOXYDIR = dirname($_SERVER['SCRIPT_FILENAME']);
	$output = trim(shell_exec("ls ".$DOXYDIR."/cmssw/ | grep CMSSW_ | sed 's|\.zip$||;s|\.sqfs$||' | tr '\n' ':'"), ":");
        $arr = explode(":", $output);

        for ($i=0; $i<count($arr); $i++)
        {
             // for XCMSSW
             if(strpos($arr[$i], "CMSSW_") != 0) continue;
   	     echo "<option id=\"".$arr[$i]."\">".$arr[$i]."</option>\n";
	}

include("log/log.php");

?>
</select>


 
</body>
</html>



