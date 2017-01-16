<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// require "includes/RSSReader.php";
// // $rss = new RSSReader("http://screenshotdaily.tumblr.com/rss");
// $rss = new RSSReader("http://localhost/rss_reader/atom_example.php");
// echo "<pre>" . print_r($rss->feed_type, true) . "</pre>";

require "includes/RSSFeedModel.php";
$m = new RSSFeedModel;
echo "<pre>" . print_r($m->loadFeed(2), true) . "</pre>";
