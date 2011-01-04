<?php
include('config.php');
include('lib.php');

header('Content-Type: text/plain;charset=UTF-8');

if (!isset($_GET['token']) || urldecode($_GET['token']) !== AUTH_TOKEN) {
  header('HTTP/1.1 401 Unauthorized');
  die('Unauthorized.');
}

$url = isset($_GET['url']) ? urldecode(trim($_GET['url'])) : '';
shorten($url);
