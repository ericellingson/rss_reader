<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "RSSReaderModel.php";
require_once "RSSFeed.php";

class RSSReader {
	function __construct() {
		$this->db = new RSSReaderModel;
		$this->feeds = array();
		$this->init_db();
	}
	public function loadAllActiveFeeds() {
		$this->feeds = $this->getAllActiveFeeds();
	}
	public function getAllActiveFeeds() {
		$data = $this->db->getAllActiveFeeds();
		$feeds = array();
		foreach ($data as $_feed) {
			$feeds = new RSSFeed($_feed->feed_id);
		}
		return $feeds;
	}
	private function init_db() {
		$dbFilePath = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "rss.db3";
		echo "$dbFilePath";
	}

}

$r = new RSSReader;
