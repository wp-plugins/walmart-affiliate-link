<?php
class test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		var_dump($this->getName());
	}

	#  unicode chars [walmart search                 chocos sweet]

    public function test_generate_links_search_pass() {    	
    	$content = "This is the first test. [walmart search tv\n]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

 	public function test_generate_links_search_pass_unicode() {  
 		// unicode chars in the below string.  	
 		$a = "[walmart search                 chocos sweet]";
    	$content = "<p>This is ".utf8_encode($a)." SPARTA.</p>";
		$newcontent = generate_links($content);
		echo $content;
		echo $newcontent;
		$this->assertTrue($content != $newcontent);
    }

    public function test_generate_links_search_pass_extra_spaces() {    	
    	$content = "This is the first test. [walmart    search             tv]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

    public function test_generate_links_search_pass_multiple_in_string() {    	
    	$a = "[walmart    search            search one of two]";
    	$b = "[walmart    search            search two of two]";
    	$content = "This is the first test. ".$a." This should link to search page with tv's.".$b;
		$newcontent = generate_links($content);
		$this->assertTrue(!strpos($newcontent, $a));
		$this->assertTrue(!strpos($newcontent, $b));
    }

    public function test_generate_links_search_pass_multiple_in_string_same() {    	
    	$a = "[walmart    search            search same]";
    	$b = "[walmart    search            search same]";
    	$content = "This is the first test. ".$a." This should link to search page with tv's.".$b;
		$newcontent = generate_links($content);
		$this->assertTrue(!strpos($newcontent, $a));
		$this->assertTrue(!strpos($newcontent, $b));
    }

	public function test_generate_links_search_pass_extra_chars_in_search_query() {
    	$content = "This is the first test. [Walmart search 980 tv ~!@#$ %^ &*() some\n thing ,./?>< laksd\n ;':\"[]\|}{']. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

    public function test_generate_links_link_pass() {
    	$content = "This is the first test. [walmart http://walmart.com/ This is the title of the link]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }
	
	public function test_generate_links_link_pass_unicode() {
    	$content = "This is the first test. [walmart                                    http://walmart.com/ This is the title of the link]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

    public function test_generate_links_link_pass_extra_spaces() {
    	$content = "This is the first test. [walmart       			 http://walmart.com/ This is the    title of  	 the link]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

    public function test_generate_links_link_pass_multiple_in_string() {    	
    	$a = "[walmart       			 http://walmart.com/ link one of two]";
    	$b = "[walmart       			 http://walmart.com/ link two   of two]";
    	$content = "This is the first test. ".$a." This should link to search page with tv's.".$b;
		$newcontent = generate_links($content);
		$this->assertTrue(!strpos($newcontent, $a));
		$this->assertTrue(!strpos($newcontent, $b));
    }

    public function test_generate_links_link_pass_multiple_in_string_same() {    	
    	$a = "[walmart       			 http://walmart.com/ link same]";
    	$b = "[walmart       			 http://walmart.com/ link same]";
    	$content = "This is the first test. ".$a." This should link to search page with tv's.".$b;
		$newcontent = generate_links($content);
		$this->assertTrue(!strpos($newcontent, $a));
		$this->assertTrue(!strpos($newcontent, $b));
    }

    public function test_generate_links_link_pass_extra_chars_in_title() {
    	$content = "This is the first test. [Walmart http://walmart.com/ This ~!@#$ %^ &*() some\n thing ,./?>< laksd\n ;':\"[]\|}{']. This should link to search page with tv's.]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

    public function test_generate_links_banner_pass() {
    	$content = "This is the first test. [walmart banner 123123123]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

	public function test_generate_links_banner_pass_unicode() {
    	$content = "This is the first test. [walmart                  banner                  123123123]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

    public function test_generate_links_banner_pass_extra_spaces() {
    	$content = "This is the first test. [walmart   banner   			  123123123]. This should link to search page with tv's.";
		$newcontent = generate_links($content);
		$this->assertTrue($content != $newcontent);
    }

    public function test_generate_links_banner_pass_multiple_in_string() {    	
    	$a = "[walmart banner 123123123]";
    	$b = "[walmart banner 312233123]";
    	$content = "This is the first test. ".$a." This should link to search page with tv's.".$b;
		$newcontent = generate_links($content);		
		$this->assertTrue(!strpos($newcontent, $a));
		$this->assertTrue(!strpos($newcontent, $b));
    }

    public function test_generate_links_banner_pass_multiple_in_string_same() {    	
    	$a = "[walmart banner 123123123]";
    	$b = "[walmart banner 123123123]";
    	$content = "This is the first test. ".$a." This should link to search page with tv's.".$b;
		$newcontent = generate_links($content);		
		$this->assertTrue(!strpos($newcontent, $a));
		$this->assertTrue(!strpos($newcontent, $b));
    }
}
?>