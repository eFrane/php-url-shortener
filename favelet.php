<?php
include('config.php');
include('lib.php');

if (!isset($_GET['token']) || urldecode($_GET['token']) !== AUTH_TOKEN) {
  header('Content-Type: text/plain;charset=UTF-8');
  header('HTTP/1.1 401 Unauthorized');
  die('Unauthorized.');
}

$url = isset($_GET['url']) ? urldecode(trim($_GET['url'])) : '';
ob_start();
shorten($url, true);
$shorturl = ob_get_contents();
ob_end_clean();

header('Content-Type: text/html;charset=UTF-8');

$db = new mysqli(MYSQLI_HOST, MYSQLI_USER, MYSQLI_PASSWORD, MYSQLI_DATABASE);
$db->query('SET NAMES "utf8"');

$url = $db->real_escape_string($_GET['url']);

$stats = $db->prepare('SELECT hits, date AS since FROM redirect WHERE url = ?');
$stats->bind_param('s', $url);
$stats->execute();
$stats->bind_result($hits, $since);
$stats->fetch();
$stats->close();

$db->close();

$date = date(DATE_ATOM);
($hits == 0 || $hits > 1) ? $hits .= " times" : $hits .= "time";
?>
<!DOCTYPE html>
<html>
 <head>
  <title><?=$shorturl;?></title>
  <style type="text/css">
    html, body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 70px;
      font-family:Arial, Helvetica, Tahoma, Verdana, sans-serif;
      font-size:12px;
      color:#000;
      line-height: 1.2em;
      background:#ccc;
    }

    div {
      margin: 2px;
      padding: 2px;
      border: 1px dotted #ccc;
    }

    #content {
      margin:auto;
      margin-top:20px;
      margin-bottom:20px;
      padding:10px;
      background:#fff;
      width:800px;
      border-radius:20px;
    }
  </style>
  <script type="text/javascript" src="zeroclipboard.js">
  </script>
 </head>
 <body onload="init()" lang="en">
  <div id="content">
   <div id="stats">
    You shortened <a href="<?=$url;?>"><?=$url;?></a>.<br />
    The shortened link was visited <?=$hits;?> since <?=$date;?>.
   </div>
   <div id="url_container">
    Short URL: <span id="url"><a href="<?=$shorturl;?>"><?=$shorturl;?></a></span>
   </div>
   <div id="controls">
    <a href="javascript:window.close();">Close</a>&nbsp;|&nbsp;
    <div id="copy_btn">Copy to Clipboard</div>
   </div>
  </div>
  <script type="text/javascript">
    ZeroClipboard.setMoviePath('zeroclipboard.swf');
    var clip = new ZeroClipboard.Client();
    clip.setText = "<?=$shorturl?>";
    clip.glue = "copy_btn";
  </script>
 </body>
</html>
