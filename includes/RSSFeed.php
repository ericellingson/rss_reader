<?php
require_once "RSSFeedModel.php";
class RSSFeed {
	function __construct($feed_id = "", $feed_url = "") {
		$this->db = new RSSFeedModel;
		$this->feed_id = is_numeric($feed_id) ? (int)$feed_id : "";
		$this->feed_url = trim($feed_url);
		$this->feed_contents = "";
		$this->feed_type = "unknown";

		$this->load();
	}

	private function load() {
		if (!is_numeric($this->feed_id)) {
			$this->initialize();
		} else {
			$data = $this->db->loadFeed($this->feed_id);
		}
	}

	private function initialize() {
		$feed_data = $this->getFeedContents();

	}

	private function getFeedContents() {
		$xml_str = file_get_contents($this->feed_url);
		return array(
			"str" => $xml_str,
			"xml" => new SimpleXMLElement($xml_str)
		);
	}
	private function getFeedType() {
		$type = $this->feed_contents["xml"][0]->getName();
		if (strtolower(trim($type)) === "rss") {
			return "rss";
		} elseif (strtolower(trim($type)) === "feed") {
			return "atom";
		}
	}
	private function getLastUpdated() {
		$lastUpdated = "";
		/* todo */
		$lastUpdated = $this->db->getFeedLastUpdated($this->$feed_id);
		return $lastUpdated;
	}
	private function getEntriesSinceDate($lastUpdated) {
		$entries = array();
		/* todo */
		return $entries;
	}
	private function saveEntries($entries) {
		/* todo */
	}
	function saveNewEntries() {
		$lastUpdated = $this->getLastUpdated();
		$entries = $this->getEntriesSinceDate($lastUpdated);
		$this->saveEntries($entries);
	}
}