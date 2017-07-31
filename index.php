<?php
  /**
   *  TVHeadend station/image name converter and redirector.
   */

  $baseurl['gigablue'] = 'https://raw.githubusercontent.com/gigablue-support-org/templates_PiconsUpdater/master/picon_all/';
  $baseurl['picons']   = 'https://easimon.github.io/picons-dist/';

  function transliterate_gigablue($channel) {
    $channel = iconv('UTF-8', 'ASCII//IGNORE',  normalizer_normalize($channel, Normalizer::NFKD));
    $channel = strtolower($channel);
    $channel = str_replace(array('&', '+', '*', ' '), array('___and___', '___plus___', '___star___','-'), $channel);
    $channel = preg_replace('/[^a-z0-9\-\_]/', '', $channel);
    return $channel;
  }

  function transliterate_picons($channel) {
    $channel = iconv('UTF-8', 'ASCII//IGNORE',  normalizer_normalize($channel, Normalizer::NFKD));
    $channel = strtolower($channel);
    $channel = str_replace(array('&', '+', '*'), array('and', 'plus', 'star'), $channel);
    $channel = preg_replace('/[^a-z0-9]/', '', $channel);
    return $channel;
  }

  function bailout() {
    http_response_code(404);
    die('Usage: see https://github.com/easimon/tvheadend-picon-redirector');    
  }

  function filter_mode() {
    if (!isset($_GET['mode'])) {
      $mode = 'picons';
    }
    else {
      $mode = $_GET['mode'];
    }

    if ($mode != 'gigablue' && $mode != 'picons') {
      $mode = 'picons';
    }
    return $mode;
  }

  if (!isset($_GET['channel'])) {
    bailout();
  }

  $mode = filter_mode();
  $channel = trim($_GET['channel']);

  if ($channel == false) {
    bailout();
  }

  mb_internal_encoding('UTF-8');
  mb_regex_encoding('UTF-8');

  $transliterate = 'transliterate_' . $mode;
  
  $url = $baseurl[$mode] . $transliterate($channel) . '.png';
  header('Location: ' . $url);
?>