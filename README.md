# Foreign Exchange RATE BOT

Get foreign exchange rate and send to your LINE every day

## Version

* 1.1.2

## Getting Started

1. Register LINE Messaging API on LINE developers, then get access token of LINE Messaging API channel
https://developers.line.me/
2. Setup HTTPS environment by installing Apache + PHP + SQLite + SSL cert(by Let's encrypt, ..., etc.)
3. Clone this project and make your Apache to access "ForeignEX/web" as HTTPS root folder
4. Install dependent libraries and tools
```text
$ sudo apt-get install sqlite
$ sudo apt-get install composer
$ sudo apt-get install libfreetype6-dev
$ sudo apt-get install php-image-text
$ sudo apt-get install php-sqlite3
$ sudo apt-get install php-xml
$ sudo apt-get install php-mbstring
$ sudo apt-get install php-curl
```

5. Install dependencies
```text
$ composer install
```

6. Setup access token in config.php
```text
define("LINE_MESSAGE_API_ACCESS_TOKEN", 'YOUR_ACCESS_TOKEN_HERE');
```

7. Setup URL for image files of line chart in config.php
```text
define('IMAGE_HTTP_PATH_BASE_RATE', "https://your_domain/pic");
// For example
define('IMAGE_HTTP_PATH_BASE_RATE', "https://linebottest.alenshiun.tw/pic");
```

8. Check file permission of this project! This project will access "db" and "log" foler, please check "www-data" or "nginx" have permission to read/write "db" and "log" folder
```text
$ sudo chown -R www-data:www-data db
$ sudo chmod -R 755 db
$ sudo chown -R www-data:www-data log
$ sudo chmod -R 755 log
```

9. Invite LINE bot into your chat room or group room
10. Check line_id has been added to DB after invited LINE bot into room, for example:
```text
$ sqlite3 db/db.sqlite
sqlite> .tables
target
sqlite> SELECT * FROM target;
1|C6318xxxxxxxxxxxxxxxxxxxxxxxx5946|FOREIGN_EX_DB_TYPE_GROUP|2018-09-25 04:40:47|
```

11. Run worker.php from command line
```text
php worker.php
```

12. Use crontab to run worker.php every day

## Reference
1. My blog: [LINE BOT 匯率提醒機器人(1/3) － 使用GCP架設Linux server](https://blog.alenshiun.tw/2018/10/line-bot-13-gcplinux-server.html)
2. [LINE developers console](https://developers.line.me)
3. PHP Chart library: [pChart 2.0](http://www.pchart.net/)
