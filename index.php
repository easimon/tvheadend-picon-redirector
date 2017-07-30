<?php
  /**
   *  TVHeadend station/image name converter and redirector.
   */

  $baseurl = 'https://raw.githubusercontent.com/gigablue-support-org/templates_PiconsUpdater/master/picon_all/';

  function bailout() {
    http_response_code(404);
    die('Usage: see https://github.com/easimon/tvheadend-picon-redirector');    
  }

  if (!isset($_GET['channel'])) {
    bailout();
  }

  $channel=trim($_GET['channel']);

  if ($channel == false) {
    bailout();
  }

  mb_internal_encoding('UTF-8');
  mb_regex_encoding('UTF-8');
  
  $channel = iconv('UTF-8', 'ASCII//IGNORE',  normalizer_normalize($channel, Normalizer::NFKD));
  $channel = strtolower($channel);
  $channel = str_replace(array('&', '+', '*', ' '), array('___and___', '___plus___', '___star___','-'), $channel);
  $channel = preg_replace('/[^a-z0-9\-\_]/', '', $channel);
  
  $url = $baseurl . $channel . '.png';
  header('Location: ' . $url);
?>