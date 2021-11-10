<?php
//settings_default.php
//DO NOT MODIFY THIS FILE, COPY IT TO settings.php AND EDIT THAT ONE.
$settings = array(
  //page title
  'title' => 'ScribbleByte | z0m.bi',
  //ScribbleByte URL ie: http://z0m.bi/apps/ScribbleByte/ (need that last slash)
  'ScribbleByte_site_path' => "http://" . $_SERVER['SERVER_NAME'] . '/ScribbleByte/',
  //default string to use on load
  'default_text' =>
    'Sphinx Of Black Quartz, Judge My Vow.'.PHP_EOL.
    '(pack my box with five dozen liquor jugs?)'.PHP_EOL.
    'WALTZ, BAD NYMPH, FOR QUICK JIGS VEX!'.PHP_EOL.
    'pi = 3.1415926535897...',
  /*'default_text' =>
    'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.PHP_EOL.
    'abcdefghijklmnopqrstuvwxyz'.PHP_EOL.
    '0123456789'.PHP_EOL.
    '|()<>[]{}+=`~-.!?,"\':;\\/@#$%^&*',*/
  'default_font' => 'Elite Extra',
  //anything to include in the bottom of the page, ie /var/www/html/tracking.html
  'include_footer' => '',
);
