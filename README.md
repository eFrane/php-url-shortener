# Simple PHP URL shortener

## Installation

1) Download the source code as located within this repository, and upload it to your web server.
2) Use `database.sql` to create the `redirect` table in a database of choice.
3) Edit `config.php` and enter your database credentials.
4) If you don't provide an auth.token file, the system will generate one automatically the first time it is used.

### Favelet

You can get the code for the included favelet by executing mkfavelet.php on your servers shell, or if you don't have access to a shell on your server, get the contents of auth.token and fill them into the following scriptlet:

    javascript:(function(){var%20d=document;window.open('<SHORTENER_URL>favelet.php?token=<AUTH_TOKEN>&url='+encodeURIComponent(d.location)+'','_blank','width=480,height=70,menubar=no,toolbar=no,status=no,location=no');})();

Which than can be used as favelet in your favorite browser.

## Features

* Uses a simple token authentication when accessing the shortener
* Redirect to Twitter when given a numerical slug, e.g. `http://mths.be/8065633451249664` → `http://twitter.com/mathias/status/8065633451249664`.
* Redirect to your main website when no slug is entered, e.g. `http://mths.be/` → `http://mathiasbynens.be/`.
* Redirect to a specific page on your main website when an unknown slug (not in the database) is used, e.g. `http://mths.be/demo/jquery-size` → `http://mathiasbynens.be/demo/jquery-size`.
* Ignores weird trailing characters (`!`, `"`, `#`, `$`, `%`, `&`, `'`, `(`, `)`, `*`, `+`, `,`, `-`, `.`, `/`, `@`, `:`, `;`, `<`, `=`, `>`, `[`, `\`, `]`, `^`, `_`, `{`, `|`, `}`, `~`) in slugs — useful when your short URL is run through a crappy link parser, e.g. `http://mths.be/aaa)` → same effect as visiting `http://mths.be/aaa`.
* Generates short URLs using base 36 characters.
* Doesn’t create multiple short URLs when you try to shorten the same URL. In this case, the script will simply return the existing short URL for that long URL.
* DRY, minimal code.
* Correct, semantic use of the available HTTP status codes.
* Can be used with Twitter for iPhone. Just go to _Settings_ › _Services_ › _URL Shortening_ › _Custom…_ and enter `http://yourshortener.ext/shorten?token=<AUTH_TOKEN>&url=%@`.

## Credits

* _— [Mathias](http://mathiasbynens.be/)_ for the basic implementation
