<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// require "includes/RSSReader.php";
require_once "includes/RSSFeed.php";
// require "includes/RSSFeedModel.php";




// // $rss = new RSSReader("http://screenshotdaily.tumblr.com/rss");
// $rss = new RSSReader("http://localhost/rss_reader/atom_example.php");
// echo "<pre>" . print_r($rss->feed_type, true) . "</pre>";
// $m = new RSSFeedModel;
// echo "<pre>" . print_r($m->loadFeed(2), true) . "</pre>";

// $feed = new RSSFeed("", "C:\\dev\\rss_reader\\data\\test.rss");
$feed = new RSSFeed("", "http://screenshotdaily.tumblr.com/rss");
// echo "<pre>" . print_r($feed, true) . "</pre>";
