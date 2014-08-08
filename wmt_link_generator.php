<?php
  /*
   * Plugin Name: Walmart Affiliate Link Generator
   * Version: 1.0.2
   */

/*
Supported formats for wordpress plugin.

[walmart search ipad]

[walmart http://walmart.com/ “This is the title of the link" ]

[walmart banner 123123123]
*/
// Get the encrypted id from the database.

$wmt_options = get_option("wmt_settings");

include 'regex_matcher.php';
include "wmt_admin_page.php";

add_filter( 'the_content', 'generate_links' );

?>