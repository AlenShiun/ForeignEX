<?php

// ==================================================
// Include all libraries
// ==================================================
require "chartGenerator.php";
require "config.php";
require "parser.php";
require "sender.php";

$chartGenerator = new chartGenerator();

// ==================================================
// Parse foreign exchange rate
// ==================================================
$parser = new OpenDataParser();
$rates = $parser->parse();

// Extract rate of today
$today = new DateTime();
$today->setTimezone(new DateTimeZone('Asia/Taipei'));
$todayDateTime = $today->format('Y-m-d');
$rateDateTimeFirst = DateTime::createFromFormat('Y/m/d', $rates[0]->date)->format('Y-m-d');
//echo $rateDateTimeFirst . PHP_EOL;

// Stop running if no data today
if(CHECK_FOREIGN_EX_RATE_UPDATED && $todayDateTime !== $rateDateTimeFirst) {
    echo "No new foreign exchange rate today" . PHP_EOL;
    die();
}

// ==================================================
// Create chart based on rate data
// ==================================================
// Setup file path of chart
$localPath = IMAGE_LOCAL_PATH_BASE_RATE . '/' . strval($today->getTimestamp()) . '.png';

// Create chart file
$chartGenerator->generate($rates, DRAW_COUNT_LIMIT, $localPath);

// ==================================================
// Send message by LINE message API
// ==================================================
// Setup HTTP URL of chart file
$httpPath = IMAGE_HTTP_PATH_BASE_RATE . '/' . strval($today->getTimestamp()) . '.png';

// Prepare message content
$message = '[' . mb_substr($rates[0]->date, 5) . "] 今日匯率: " . $rates[0]->rate;

// Send by LINE message API
$sender = new Sender();
$sender->send($message, $httpPath);

?>

