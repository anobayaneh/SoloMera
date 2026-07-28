<?php

// LOAD WORDPRESS (important)
require_once('../wp-load.php');

$config = require "config.php";

$message = file_get_contents($config["template_file"]);
$emails = file($config["email_file"], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($emails as $to) {

    $subject = $config["subject"];

    $headers = array('Content-Type: text/html; charset=UTF-8');

    wp_mail($to, $subject, $message, $headers);

    echo "Sent to: $to <br>";

    sleep($config["delay_seconds"]);
}

echo "<h2>DONE SENDING</h2>";