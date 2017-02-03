<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "RSSFeedModel.php";
class RSSFeed {
	function __construct($feed_id = "", $feed_url = "") {
		$this->db = new RSSFeedModel;
		$this->feed_contents = "";

		$this->feed_id = is_numeric($feed_id) ? (int)$feed_id : "";
		$this->feed_url = trim($feed_url);
		$this->feed_type = "unknown";
		$this->feed_name = "";
		$this->feed_description = "";
		$this->source_last_updated = "";
		$this->local_last_updated = "";
		$this->is_active = true;

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
		$this->feed_contents = $this->getFeedContents();
		$this->feed_type = $this->getFeedType();
		$this->setFeedInfo($this->feed_contents["xml"]);

		$entries = $this->getEntries($this->feed_contents["xml"]);

		echo $this->feed_name . "<br>" . $this->feed_description . "<br>" . $this->source_last_updated;
		exit();

	}
	private function setFeedInfo($xml) {
		if ($this->feed_type === "atom") {
			$this->setAtomFeedInfo($xml);
		} elseif ($this->feed_type === "rss") {
			$this->setRSSFeedInfo($xml);
		}
	}
	private function setAtomFeedInfo($xml) {
		$this->feed_name = $xml->title;
		$this->feed_description = $xml->subtitle;
		$this->source_last_updated = isset($xml->updated) ? $xml->updated : "";
	}
	private function setRSSFeedInfo($xml) {
		$xml = $xml->channel;
		$this->feed_name = $xml->title;
		$this->feed_description = $xml->description;
		$this->source_last_updated = isset($xml->lastBuildDate) ? $xml->lastBuildDate : "";
	}
	private function getEntries($xml) {
		if ($this->feed_type === "atom") {
			$this->getAtomEntries($xml);
		} elseif ($this->feed_type === "rss") {
			$this->getRSSEntries($xml);
		}
	}
	private function getAtomEntries($xml) {
		die("getAtomEntries");
	}
	private function getRSSEntries($xml) {
		// die("getRSSEntries");
		$xml = $xml->channel;
		$entries = array();
		// echo "<pre>" . print_r(gettype($xml->item), true) . "</pre>";
		foreach ($xml->item as $item) {
			$entries[] = array(
				"entry_id" => $this->db->getEntryId($item->guid),
				"entry_title" => $item->title,
			);
		}
		// echo "<pre>" . print_r(get_object_vars($xml), true) . "</pre>";

		// echo gettype($xml->entry);
		// exit();
		return $entries;
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