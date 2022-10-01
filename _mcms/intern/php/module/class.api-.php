<?php
class api {
	function __construct() {
		$this->api=true;
	}
	function __destruct() {
       $this->api=false;
	}
	public static function get_page() {}
	public static function get_template() {}
	public static function get_image() {}
	public static function get_contents() {}
	public static function get_page() {}
}
?>