<?php
include('config.php');

if (isset($argc) && isset($argv)) {
  // cli mode

  $url = SHORT_URL.'favelet.php?token='.AUTH_TOKEN.'&url=\'+enc(d.location)+\'';

  $script =<<<SCRIPT
  javascript:(
    function() {
      var%%20 d=document, wsh;
      wsh = window.open('%s', '_blank', 'width=480, height=100,
        menubar=no,toolbar=no,status=no,location=no');
    })()
SCRIPT;

  $script = preg_replace('/([ \n])*/', '', $script);
  $script = sprintf($script, $url);

  print $script."\n";
} else {
  header('Location: /');
}
