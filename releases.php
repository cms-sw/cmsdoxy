<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once('simplejson.php');
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

$cmsswAutoDoc = fromJSON(file_get_contents('CMSSWAutoDoc/cmsswRels2Doc.json'), true);
function isBeingDocumented($ver){
    global $cmsswAutoDoc;
    if(! in_array($ver, $cmsswAutoDoc)) return False;

    if($cmsswAutoDoc[$ver]['status'] == 'documenting...') return True;

    return False;
}

function getDocProcess(){
    global $cmsswAutoDoc;
    $res = array();
    foreach($cmsswAutoDoc as $key => $val) if($val['status'] == 'documenting...') $res[] = $key;
    return $res;
}

Header('Content-type: text/xml');
?>
<projects>
<?php
$doxy_URL  = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']);
if ($handle = opendir('.')){
    while (false !== ($dir = readdir($handle))){
        if ($dir != "." && $dir != ".." && is_dir($dir) && startsWith($dir, 'CMSSW_') && !isBeingDocumented($dir)){
            // attribute for auto-generated documentations. init state: null string
            $auto = "false";
            if(file_exists("$dir/auto.doc.2")) $auto = "true";
            echo "    <project label=\"$dir\" url=\"$doxy_URL/$dir/doc/html/\" auto-documented=\"$auto\" />\n";
        }
    }
    closedir($handle);
}
foreach(getDocProcess() as $ver){
    echo "    <project label=\"$ver\" auto-documented=\"documenting...\" />\n";
}
?>
    <project label="CMSSW_5_1_3" url="" state="deprecated"/>
    <project label="CMSSW_5_2_3" url="" state="deprecated"/>
    <project label="CMSSW_5_2_3_patch4" url="" state="deprecated"/>
    <project label="CMSSW_5_2_4" url="" state="deprecated"/>
    <project label="CMSSW_5_2_4_hltpatch2" url="" state="deprecated"/>
    <project label="CMSSW_5_2_4_hltpatch3" url="" state="deprecated"/>
    <project label="CMSSW_5_2_4_hltpatch4" url="" state="deprecated"/>
    <project label="CMSSW_5_2_4_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_2_4_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_2_4_patch3" url="" state="deprecated"/>
    <project label="CMSSW_5_2_4_patch4" url="" state="deprecated"/>
    <project label="CMSSW_5_2_5" url="" state="deprecated"/>
    <project label="CMSSW_5_2_5_ecalpatch1" url="" state="deprecated"/>
    <project label="CMSSW_5_2_5_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_2_5_patch3" url="" state="deprecated"/>
    <project label="CMSSW_5_2_6" url="" state="deprecated"/>
    <project label="CMSSW_5_2_6_hltpatch1" url="" state="deprecated"/>
    <project label="CMSSW_5_2_6_hltpatch2" url="" state="deprecated"/>
    <project label="CMSSW_5_2_6_hltpatch4" url="" state="deprecated"/>
    <project label="CMSSW_5_2_6_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_2_6_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_2_8" url="" state="deprecated"/>
    <project label="CMSSW_5_2_8_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_11_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_11_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_3_11_patch3" url="" state="deprecated"/>
    <project label="CMSSW_5_3_11_patch5" url="" state="deprecated"/>
    <project label="CMSSW_5_3_12_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_12_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_3_13_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_13_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_3_1_TS120913" url="" state="deprecated"/>
    <project label="CMSSW_5_3_1_TS121128" url="" state="deprecated"/>
    <project label="CMSSW_5_3_2_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_2_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_3_2_patch3" url="" state="deprecated"/>
    <project label="CMSSW_5_3_2_patch4" url="" state="deprecated"/>
    <project label="CMSSW_5_3_3_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_3_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_3_7_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_7_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_3_7_patch3" url="" state="deprecated"/>
    <project label="CMSSW_5_3_7_patch4" url="" state="deprecated"/>
    <project label="CMSSW_5_3_7_patch6" url="" state="deprecated"/>
    <project label="CMSSW_5_3_8_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_8_patch2" url="" state="deprecated"/>
    <project label="CMSSW_5_3_9_patch1" url="" state="deprecated"/>
    <project label="CMSSW_5_3_9_patch2" url="" state="deprecated"/>
    <project label="CMSSW_6_0_0" url="" state="deprecated"/>
    <project label="CMSSW_6_0_0_patch1" url="" state="deprecated"/>
    <project label="CMSSW_6_0_1" url="" state="deprecated"/>
    <project label="CMSSW_6_0_1_PostLS1v1" url="" state="deprecated"/>
</projects>
