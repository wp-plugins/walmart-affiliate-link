<?php
/*
Modify the content and insert the links.
*/
function generate_links( $content ) { 
  global $wmt_options;
  if (!$wmt_options['encrypted']) {
    // Dont insert invalid links. User can notice that links aren't inserted and try to fix the problem.
    return $content;
  }

  global $link_created;

  // g isn't required in the regex options because preg_replace already
  // replaces all occurances in the text.
  /* 
    s - include newline in dot regex char
    i - case insensitive
    u - unicode chars eg. &nbsp; is converted to unicode  
    U - Dont be greedy when matching. Reqd for multiple matches in a file.
  */  
  $regex_options = "usiU";

  $pattern_search = "#\[walmart\s+search\s+(.+)\]#".$regex_options;

  $pattern_link = "#\[walmart\s+(http\S+)\s+(.+)\]#".$regex_options;

  $pattern_banner = "#\[walmart\s+banner\s+([0-9]+)\]#".$regex_options;

  // Link ids are choosen from the list of id slots provided to us by linkshare. Please refer below for more details.
  // https://confluence.walmart.com/display/LABS/Launching+new+widgets+for+affiliates

  $newcontent = preg_replace_callback(
    $pattern_search,
    function($matches) {
               global $link_created;
               $link_created = 1;
               global $wmt_options;
               return '<a target="_blank" href="http://linksynergy.walmart.com/fs-bin/click?id='.$wmt_options['encrypted'].'&offerid=223073.7500&type=4&subid=0&tmpid=1081&RD_PARM1=http%3A%2F%2Fwww.walmart.com%2Fsearch%2Fsearch-ng.do%3Fsearch_query%3D'.urlencode($matches[1]).'">'.$matches[1].'</a>';
    },
    $content);

  $newcontent = preg_replace_callback(
    $pattern_link,
    function($matches) {
               global $link_created;
               $link_created = 1;
               global $wmt_options;
               $tmpid = "";
               if (strpos($matches[1], '?')) {
                  // ? exists use 1081 as the tmpid
                  $tmpid = "1081";
               } else {
                  // ? DOES NOT exists use 1082 as the tmpid
                  $tmpid = "1082";
               }
               return '<a target="_blank" href="http://linksynergy.walmart.com/fs-bin/click?id='.$wmt_options['encrypted'].'&offerid=223073.7502&type=4&subid=0&tmpid='.$tmpid.'&RD_PARM1='.urlencode($matches[1]).'">'.$matches[2].'</a>';
    },
    $newcontent);

  $newcontent = preg_replace_callback(
    $pattern_banner,
    function($matches) {
               global $link_created;
               $link_created = 1;
               global $wmt_options;
               return '<iframe target="_blank" height="250" width="300" src="http://affil.walmart.com/ad?wtype=rc&lsnTrack=http%3A%2F%2Flinksynergy.walmart.com%2Ffs-bin%2Fclick%3Fid%3D'.$wmt_options['encrypted'].'%26offerid%3D223073.7503%26type%3D13%26subid%3D0%26tmpid%3D1081&exp=ID&itemIDs='.$matches[1].'"></iframe>';
    },
    $newcontent);
  // Collecting some data about the usage of the plugin development purposes.
  try {
    if ($link_created) {
        file_get_contents("http://www.google-analytics.com/collect?v=1&tid=UA-51915563-1&dl=http%3A%2F%2Faffil.walmart.com&t=pageview&dp=regex-used&cid=".rand(0,100000000));
    } else {
        file_get_contents("http://www.google-analytics.com/collect?v=1&tid=UA-51915563-1&dl=http%3A%2F%2Faffil.walmart.com&t=pageview&dp=regex-unused&cid=".rand(0,100000000));
    }
  } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
  return $newcontent;
}

?>