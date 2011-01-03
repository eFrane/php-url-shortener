<?php

include('config.php');

if (!isset($_GET['token']) || urldecode($_GET['token']) !== AUTH_TOKEN) {
  header('Content-Type: text/plain;charset=UTF-8');
  header('HTTP/1.1 401 Unauthorized');
  die('Unauthorized.');
} else {
  header('Content-Type: text/html;charset=UTF-8');
}

$shorturl = file_get_contents(sprintf("http://efrane.com/shorten?token=%s&url=%s",
              $_GET['token'], $_GET['url']));

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
?>
<!DOCTYPE html>
<html>

</html>
