<?php

const HONG_KONG_TZ = "Asia/Hong_Kong";

$busRouteCompanies = [
    "6" => ["ctb"],
    "66" => ["ctb", "nwfb"],
    "6X" => ["ctb"],
    "15" => ["nwfb"],
];


require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Segment.php');
require_once(__DIR__ . '/BusSegment.php');
require_once(__DIR__ . '/MtrSegment.php');
