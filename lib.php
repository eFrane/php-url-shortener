<?php

function getNextShortURL($s) {
  $i = base_convert($s, 36, 10);
  return base_convert(++$i, 10, 36);
}

function shorten($url, $echo = true) {
  $db = new mysqli(MYSQLI_HOST, MYSQLI_USER, MYSQLI_PASSWORD, MYSQLI_DATABASE);
  $db->query('SET NAMES "utf8"');

  $url = $db->real_escape_string($url);

  $result = $db->query('SELECT `slug` FROM `redirect` WHERE `url` = "' . $url . '" LIMIT 1');
  if ($result && $result->num_rows > 0) { // If there’s already a short URL for this URL
    die(SHORT_URL . $result->fetch_object()->slug);
  } else {
    $result = $db->query('SELECT `slug`, `url` FROM `redirect` ORDER BY `date` DESC LIMIT 1');
    if ($result && $result->num_rows > 0) {
      $slug = getNextShortURL($result->fetch_object()->slug);
      if ($db->query('INSERT INTO `redirect` (`slug`, `url`, `date`, `hits`) VALUES ("' . $slug . '", "' . $url . '", NOW(), 0)')) {
        if ($echo) {
          header('HTTP/1.1 201 Created');
          echo SHORT_URL.$slug;
          $db->query('OPTIMIZE TABLE `redirect`');
        } else {
          return SHORT_URL.$slug;
        }
      }
    }
  }
}
