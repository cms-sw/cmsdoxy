<?php

$url = "https://cms.cern.ch/iCMS/user/annotes";

$c = curl_init($url);

$optinos = array( 
                  CURLOPT_RETURNTRANSFER => false,
                  CURLOPT_HEADER         => true,
                  CURLOPT_FOLLOWLOCATION => false,
                  CURLOPT_SSL_VERIFYHOST => '0',
                  CURLOPT_SSL_VERIFYPEER => '0',
                  CURLOPT_CAINFO         => '/data/doxygen/test/cms.cern.ch.crt',
                  CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                  CURLOPT_VERBOSE        => true,
                  CURLOPT_URL            => $url
           );

curl_setopt($c, $options);


//curl_setopt(... other options you want...)

$html = curl_exec($c);

if (curl_error($c))
    die(curl_error($c));

// Get the status code
$status = curl_getinfo($c, CURLINFO_HTTP_CODE);

curl_close($c);


echo $html;
?>