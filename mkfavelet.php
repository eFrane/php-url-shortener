<?php
include('config.php');

if (isset($argc) && isset($argv)) {
  // cli mode

  $script =<<<SCRIPT
  javascript:(
    function() {
      var%%20 d=document;
      window.open('%s', '_blank', 'width=480, height=100,
        menubar=no,toolbar=no,status=no,location=no');
    })();
SCRIPT;

  $url = SHORT_URL.'favelet.php?token='.AUTH_TOKEN.'&url=\'+encodeURIComponent(d.location)+\'';

  $script = preg_replace('/([ \n])*/', '', $script);
  $script = sprintf($script, $url);

  print $script."\n";
} else {
  header('Location: /');
}
