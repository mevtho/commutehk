<?php

require_once('../src/config.php');

$direction = ($_GET["direction"] ?? "") !== "back" ? "go" : "back";
$showTimeAs = ($_GET["show"] ?? "") !== Segment::VIEW_WAIT ? Segment::VIEW_TIME : Segment::VIEW_WAIT;

$configFile = "./configs/default.php";
if ($_GET['u'] && file_exists("./configs/".$_GET['u'].".php")) {
    $configFile = "./configs/".$_GET['u'].".php";
}

$journey = require($configFile);

$segments = $journey[$direction];

foreach ($segments as $segment) {
    $segment->retrieveData();
}

require_once('../src/render.php');


