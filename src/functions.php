<?php

function call($url, $params = [])
{
    $curl = curl_init();

    // Allow ommitting {} in params
    $formattedParams = [];
    foreach ($params as $name => $value) {
        $formattedParams["{" . $name . "}"] = $value;
    }

    $url = strtr($url, $formattedParams);

    curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response);
}

function now()
{
    return new DateTime("now", new DateTimeZone(HONG_KONG_TZ));
}

function minutesFromNow(DateTime $date) {
    $diff = date_diff(now(), $date);

    return $diff->days * 24 * 60
            + $diff->h * 60
            + $diff->i;
}

