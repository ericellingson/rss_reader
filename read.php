<?php
require "includes/RSSReader.php";
$reader = new RSSReader;
$reader->loadAllActiveFeeds();
echo "<pre>" . print_r($reader, true) . "</pre>";