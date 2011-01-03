<?php

define('MYSQLI_HOST', 'localhost');
define('MYSQLI_USER', 'user');
define('MYSQLI_PASSWORD', 'password');
define('MYSQLI_DATABASE', 'database');
define('TWITTER_USERNAME', '');
define('SHORT_URL', ''); // include the trailing slash!
define('DEFAULT_URL', ''); // omit the trailing slash!

// auth token to make shortening more secure
// esp. to avoid random ppl shortening URLs via this instance who shouldn't.
if (!file_exists('auth.token')) {
  if (!file_put_contents('auth.token', substr(sha1(uniqid().strftime(DATE_ATOM)), 0, 8))) {
    die("Could neither access nor create auth.token, check config.");
  }
} else {
  define('AUTH_TOKEN', trim(file_get_contents('auth.token')));
}

?>
