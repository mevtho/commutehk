<?php

require_once('../src/config.php');

$direction = ($_GET["direction"] ?? "") !== "back" ? "go" : "back";
$showTimeAs = ($_GET["show"] ?? "") !== "in" ? "time" : "in";

$journey = [
    "go" => [
        new BusSegment("Lun Fat Street &rarr; Exchange Square", "002488", ["6", "6X", "15", "66"]),
        new MtrSegment("Hong Kong Station &rarr; Kownloon Station", "TCL", "HOK", "UP")
    ],
    "back" => [
        new MtrSegment("Kownloon Station &rarr; Hong Kong Station", "TCL", "KOW", "DOWN"),
        new BusSegment("Exchange Square &rarr; Lun Fat Street", "001032", ["6", "6X", "15", "66"])
    ]
];

$segments = $journey[$direction];

foreach ($segments as $segment) {
    $segment->retrieveData();
}

require_once('../src/render.php');


