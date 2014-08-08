<?php
/*
 * Modify the content and insert the links.
 */
function generate_links($content) {
	global $wmt_options;
	if (! $wmt_options ['encrypted']) {
		// Dont insert invalid links. User can notice that links aren't inserted and try to fix the problem.
		return $content;
	}
	
	// g isn't required in the regex options because preg_replace already
	// replaces all occurances in the text.
	/*
	 * s - include newline in dot regex char
	 * i - case insensitive 
	 * u - unicode chars eg. &nbsp; is converted to unicode 
	 * U - Dont be greedy when matching. Reqd for multiple matches in a file.
	 */
	$regex_options = "usiU";
	
	$pattern_search = "#\[walmart\s+search\s+(.+)\]#" . $regex_options;
	
	$pattern_link = "#\[walmart\s+(http\S+)\s+(.+)\]#" . $regex_options;
	
	// Support for banner for backward-compatibility
	
	$pattern_rectangle = "#\[walmart\s+(?:rectangle|banner)\s+([0-9]+)\]#" . $regex_options;
	
	$pattern_leaderboard = "#\[walmart\s+leaderboard\s+([0-9]+)\s+([0-9]+)\]#" . $regex_options;
	
	$pattern_skyscraper = "#\[walmart\s+skyscraper\s+([0-9]+)\s+([0-9]+)\s+([0-9]+)\]#" . $regex_options;
	
	$pattern_carousel = "#\[walmart\s+carousel\s+([\s0-9]*)\]#" . $regex_options;
	
	// Link ids are choosen from the list of id slots provided to us by linkshare. Please refer below for more details.
	// https://confluence.walmart.com/display/LABS/Launching+new+widgets+for+affiliates
	
	$newcontent = preg_replace_callback ( $pattern_search, function ($matches) {
		global $wmt_options;
		return '<a target="_blank" href="http://linksynergy.walmart.com/fs-bin/click?id=' . $wmt_options ['encrypted'] . '&offerid=223073.7500&type=4&subid=0&tmpid=1081&RD_PARM1=http%3A%2F%2Fwww.walmart.com%2Fsearch%2Fsearch-ng.do%3Fsearch_query%3D' . urlencode ( $matches [1] ) . '">' . $matches [1] . '</a>';
	}, $content );
	
	$newcontent = preg_replace_callback ( $pattern_link, function ($matches) {
		global $wmt_options;
		$tmpid = "";
		if (strpos ( $matches [1], '?' )) {
			// ? exists use 1081 as the tmpid
			$tmpid = "1081";
		} else {
			// ? DOES NOT exists use 1082 as the tmpid
			$tmpid = "1082";
		}
		return '<a target="_blank" href="http://linksynergy.walmart.com/fs-bin/click?id=' . $wmt_options ['encrypted'] . '&offerid=223073.7502&type=4&subid=0&tmpid=' . $tmpid . '&RD_PARM1=' . urlencode ( $matches [1] ) . '">' . $matches [2] . '</a>';
	}, $newcontent );
	
	$newcontent = preg_replace_callback ( $pattern_rectangle, function ($matches) {
		global $wmt_options;
		return '<iframe target="_blank" height="250" width="300" src="http://affil.walmart.com/ad?wtype=rc&lsnTrack=http%3A%2F%2Flinksynergy.walmart.com%2Ffs-bin%2Fclick%3Fid%3D' . $wmt_options ['encrypted'] . '%26offerid%3D223073.7503%26type%3D13%26subid%3D0%26tmpid%3D1081&exp=ID&itemIDs=' . $matches [1] . '"></iframe>';
	}, $newcontent );
	
	$newcontent = preg_replace_callback ( $pattern_leaderboard, function ($matches) {
		global $wmt_options;
		return '<iframe target="_blank" height="90" width="728" src="http://affil.walmart.com/ad?wtype=ld&lsnTrack=http%3A%2F%2Flinksynergy.walmart.com%2Ffs-bin%2Fclick%3Fid%3D' . $wmt_options ['encrypted'] . '%26offerid%3D223073.7503%26type%3D13%26subid%3D0%26tmpid%3D1081&exp=ID&itemIDs=' . $matches [1] . ',' . $matches [2] . '"></iframe>';
	}, $newcontent );
	
	$newcontent = preg_replace_callback ( $pattern_skyscraper, function ($matches) {
		global $wmt_options;
		return '<iframe target="_blank" height="600" width="160" src="http://affil.walmart.com/ad?wtype=ss&lsnTrack=http%3A%2F%2Flinksynergy.walmart.com%2Ffs-bin%2Fclick%3Fid%3D' . $wmt_options ['encrypted'] . '%26offerid%3D223073.7503%26type%3D13%26subid%3D0%26tmpid%3D1081&exp=ID&itemIDs=' . $matches [1] . ',' . $matches [2] . ',' . $matches [3] . '"></iframe>';
	}, $newcontent );
	
	$newcontent = preg_replace_callback ( $pattern_carousel, function ($matches) {
		global $wmt_options;
	     
		$product_ids = preg_split ( '/\s+/u', $matches [1]);
		$product_ids_comma_sep = "";
		
		for($iterator = 0; $iterator < count ( $product_ids ); $iterator ++) {
		    $product_ids_comma_sep = $product_ids_comma_sep . $product_ids [$iterator] . ',';
		}
		
		$product_ids_comma_sep = trim($product_ids_comma_sep,',');
		
		return '<iframe target="_blank" height="250" width="300" src="http://affil.walmart.com/ad?wtype=carousel&lsnTrack=http%3A%2F%2Flinksynergy.walmart.com%2Ffs-bin%2Fclick%3Fid%3D' . $wmt_options ['encrypted'] . '%26offerid%3D223073.7503%26type%3D13%26subid%3D0%26tmpid%3D1081&exp=ID&itemIDs='.$product_ids_comma_sep.'"></iframe>';
	}, $newcontent );
	
	return $newcontent;
}

?>
