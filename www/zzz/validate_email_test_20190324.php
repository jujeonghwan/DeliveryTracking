<?php

    $subject = "aaaa@bbb.com";
    // $subject = "bbb.com";

    // $subject = "cdeaaaa@bbb.com";

    echo "<br />Subject: " . $subject;

    $patten = '/^[a-zA-Z0-9_.-]+@([a-zA-Z0-9-]+.)+[a-z]{2,4}$/';

    $match = preg_match($patten, $subject);

    echo "<br />match: " . $match;

    echo "<br />";
    print_r($matches);

    if ($match)
    {
        echo "<br /><br />Patten is matched.";
    }
    else
    {
        echo "<br /><br />Patten in NOT matched.";
    }

?>