# Foreign Exchange RATE BOT

Get foreign exchange rate and send to your LINE every day

## Version

* 1.1.2

## Getting Started

1. Clone this project, and make your Apache or nginx to access "web" folder as root folder
2. Install dependencies
```text
$ composer install
```

3. Setup access token in config.php
```text
define("LINE_MESSAGE_API_ACCESS_TOKEN", 'YOUR_ACCESS_TOKEN_HERE');
```

4. Check file permission of this project! This project will access "db" and "log" foler, please check "www-data" or "nginx" have permission to read/write "db" and "log" folder
```text
$ sudo chown -R www-data:www-data db
$ sudo chmod -R 755 db
$ sudo chown -R www-data:www-data log
$ sudo chmod -R 755 log
```

5. Invite LINE bot into your chat room or group room
6. Check line_id has been added to DB after invited LINE bot into room, for example:
```text
$ sqlite3 db/db.sqlite
sqlite> .tables
target
sqlite> SELECT * FROM target;
1|C6318xxxxxxxxxxxxxxxxxxxxxxxx5946|FOREIGN_EX_DB_TYPE_GROUP|2018-09-25 04:40:47|
```

7. Run worker.php from command line
```text
php worker.php
```

8. Use crontab to run worker.php every day

