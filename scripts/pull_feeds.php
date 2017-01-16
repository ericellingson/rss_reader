<?php
require "RSSReader.php";
$rss = new RSSReader;
$feeds = $rss->getAllActiveFeeds();
foreach ($feeds as $feed) {
	$rss->load($feed->id);
}
