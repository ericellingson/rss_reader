<?php
class RSSFeedModel extends SQLite3 {
	function __construct() {
		$path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "rss.db3";
		$this->open($path);
	}
	public function getRecords($sql) {
		$results = $this->query($sql);
		$rows = array();
		while ($row = $results->fetchArray()) {
			$rows[] = $row;
		}
		return $rows;
	}
	public function deleteRecord($table, $fields) {
		$sql = "DELETE FROM $table";
		$sql_cond = "";
		foreach ($fields as $field => $value) {
			$sql_cond .= (strlen($sql_cond) ? " AND " : " WHERE ") . " $field = '$value'";
		}
		$sql .= $sql_cond;
		$this->exec($sql);
	}
	public function getFeedUrl($feed_id) {
		$sql = "SELECT feed_url FROM feeds WHERE feed_id = $feed_id";
		$rows = array();
		$results = $this->query($sql);
		while ($row = $results->fetchArray()) $rows[] = $row;
		if (count($rows) === 1) $rows = $rows[0];
		else $rows = array();
		return $rows;
	}
	public function getFeedIdFromUrl($feed_url) {
		$sql = "SELECT feed_url FROM feeds WHERE feed_id = $feed_id";
		$rows = array();
		$results = $this->query($sql);
		while ($row = $results->fetchArray()) $rows[] = $row;
		if (count($rows) === 1) $rows = $rows[0];
		else $rows = array();
		return $rows;
	}
	public function getFeedLastUpdated($feed_id) {

	}
	public function addFeed($feed) {
		$feed_name = trim($feed->feed_name);
		$feed_url = trim($feed->feed_url);
		$source_last_updated = trim($feed->source_last_updated);
		$feed_description = trim($feed->feed_description);
		$local_last_updated = "1988-09-15";
		$sql = "
			INSERT INTO feeds (
				feed_name,
				feed_url,
				source_last_updated,
				feed_description,
				local_last_updated
			)
			VALUES (
				'$feed_name',
				'$feed_url',
				'$source_last_updated',
				'$feed_description',
				'$local_last_updated'
			)
		";
		$this->exec($sql);
		$id = $this->query("SELECT last_insert_rowid()")->fetchArray();
		return $id[0];
	}

	public function loadFeed($feed_id) {
		$feed_id = (int)$feed_id;
		$sql = "
			SELECT f.feed_id, f.feed_name, f.feed_url, f.source_last_updated,
				f.feed_description, f.local_last_updated, f.is_active
			FROM feeds as f
			WHERE f.feed_id = $feed_id
		";
		$rows = array();
		$results = $this->query($sql);
		while ($row = $results->fetchArray()) {
			$rows[] = (object)$row;
		}
		return $rows;
	}
}

