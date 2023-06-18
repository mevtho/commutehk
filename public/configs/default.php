<?php

return [
    "go" => [
        new BusSegment("Lun Fat Street &rarr; Exchange Square", "002488", ["6" => ["dir" => "I"], "6X" => ["dir" => "I"], "15"  => ["dir" => "I"], "66" => ["dir" => "I"]]),
        new MtrSegment("Hong Kong Station &rarr; Kowloon Station", "TCL", "HOK", "UP")
    ],
    "back" => [
        new MtrSegment("Kowloon Station &rarr; Hong Kong Station", "TCL", "KOW", "DOWN"),
        new BusSegment("Exchange Square &rarr; Lun Fat Street", "001032", ["6" => ["dir" => "O"], "6X" => ["dir" => "O"], "15"  => ["dir" => "O"], "66" => ["dir" => "O"]])
    ]
];
