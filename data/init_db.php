<?php
$dbfpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . "rss.db3";
if (!file_exists($dbfpath)) {
	file_put_contents($dbfpath, "");
}	
$dbfilesize = filesize($dbfpath);
if ($dbfilesize === 0) {
	$sql = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . "init_db.sql");
	$db = new SQLite3($dbfpath);
	$db->exec($sql);
	$db = null;
}