<?php

require_once('../src/config.php');

$user = $_GET['u'] ?? false;
$direction = ($_GET["direction"] ?? "") !== "back" ? "go" : "back";
$showTimeAs = ($_GET["show"] ?? "") !== Segment::VIEW_WAIT ? Segment::VIEW_TIME : Segment::VIEW_WAIT;

$configFile = "./configs/default.php";
if ($user && file_exists("./configs/".$user.".php")) {
    $configFile = "./configs/".$user.".php";
}

$journey = require($configFile);

$segments = $journey[$direction];

foreach ($segments as $segment) {
    $segment->retrieveData();
}

require_once('../src/render.php');


