<?php

// LINE message API access token
define("LINE_MESSAGE_API_ACCESS_TOKEN", 'YOUR_ACCESS_TOKEN_HERE');

// HTTP URL for image files of chart
define('IMAGE_HTTP_PATH_BASE_RATE', "https://your_domain/pic");

// LINE message API URL
define("LINE_MESSAGE_API_URL", "https://api.line.me/v2/bot/message/push");

// Days will draw on charts
define('DRAW_COUNT_LIMIT', 14);

// File locations for save image files of chart
define('IMAGE_LOCAL_PATH_BASE_RATE', __DIR__ . "/web/pic");

// Send message if and only foreign exchange rate is updated today
define('CHECK_FOREIGN_EX_RATE_UPDATED', false);

?>

