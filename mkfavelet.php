<?php
require('config.php');

if (isset($argc) && isset($argv)) {
  // cli mode
  $script =<<<SCRIPT
  javascript:
    window.open('%s', '_blank', 'width=480, height=100,
      menubar=no,toolbar=no,status=no,location=no')
SCRIPT;

  $script = preg_replace('/([ \n])*/', '', $script);
  $script = sprintf($script, SHORT_URL.'favelet?auth='.AUTH_TOKEN);
  print $script."\n";
} else {
  die('CLI only.');
}
