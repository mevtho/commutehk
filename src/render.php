<?php

function nowStr()
{
    echo now()->format("H:i:s");
}

function renderLink($label, $active, $parameters) {
    printf(
            "<a href=\"?%s\" class=\"w-1/2 p-2 text-center hover:bg-opacity-75 %s\">%s</a>",
            http_build_query($parameters),
            $active ?  "font-bold text-black bg-primary-200" : "text-white bg-primary-700",
            $label
    );
}

?>

<html>
<head>
    <title>Smooth Commute</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <script>
        setTimeout(() => window.location.reload(), 60 * 1000);
    </script>
</head>
<body class="flex flex-col h-full">
<header class="flex-none bg-primary-800 p-2 border-b border-black flex items-center justify-between">
    <div>
        <h1 class="font-extrabold text-lg text-white">Let's be on time !</h1>
        <span class="italic text-xs text-white">Last Refreshed (<?php nowStr(); ?>)</span>
    </div>
    <div class="p-2">
        <button class="text-white" onclick="window.location.reload()">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
        </button>
    </div>
</header>
<main class="flex-1 flex flex-col">
    <div class="flex">
        <?php renderLink("Going", $direction !== "back", ["direction" => "go", "show" => $showTimeAs]); ?>
        <?php renderLink("Returning", $direction === "back", ["direction" => "back", "show" => $showTimeAs]); ?>
    </div>
    <?php
        foreach ($segments as $segment) {
            echo $segment->render($showTimeAs);
        }
    ?>
    <div class="flex-shrink-1 flex items-center justify-around">
        <div class="<?php echo ['animate-pulse', 'animate-bounce', 'animate-ping'][rand(0,2)]; ?> ">
            <img src="img/lapin.png" class="flex  " alt="" />
        </div>
    </div>
</main>
<footer class="flex-none bg-primary-200">
    <div class="px-2 py-1 text-sm">Showing time as</div>
    <div class="flex">
        <?php renderLink("Clock", $showTimeAs !== Segment::VIEW_WAIT, ["direction" => $direction, "show" => Segment::VIEW_TIME]); ?>
        <?php renderLink("Wait (minutes)", $showTimeAs === Segment::VIEW_WAIT, ["direction" => $direction, "show" => Segment::VIEW_WAIT]); ?>
    </div>
</footer>
</body>
</html>
