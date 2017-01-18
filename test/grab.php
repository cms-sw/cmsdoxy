<?php
  $url = "http://cms.cern.ch/iCMS/user/annotes";

  $html = file_get_contents($url);

  echo $html;


?>