<?php

$bodyMsg = file_get_contents('php://input');

// Log bodyMsg to log file
//$logFile = fopen("../log/log_recv.txt", "a") or die("Unable to open file!");
//fwrite($logFile, $bodyMsg);
//fclose($logFile);

$json = json_decode($bodyMsg);

$eventType = null;
if($json->events[0]->type === "join") {
    $eventType = "join";
} else if($json->events[0]->type === "leave") {
    $eventType = "leave";
}
else {
    echo "Bad event type <br />";
    return;
}

if($json->events[0]->source->type === null) {
    echo "Bad source type <br />";
    return;
}
$type = $json->events[0]->source->type;
$lineID = null;
if($type === "room" && $json->events[0]->source->roomId !== null) {
    $lineID = $json->events[0]->source->roomId;
    $typeID = FOREIGN_EX_DB_TYPE_ROOM;
} else if($type === "group" && $json->events[0]->source->groupId !== null) {
    $lineID = $json->events[0]->source->groupId;
    $typeID = FOREIGN_EX_DB_TYPE_GROUP;
} else if($type === "user" && $json->events[0]->source->userId !== null) {
    $lineID = $json->events[0]->source->userId;
    $typeID = FOREIGN_EX_DB_TYPE_USER;
} else {
    echo "Bad source id <br />";
    return;
}

if($lineID === null) {
    echo "Bad LINE ID";
} else {
    //echo "type: $type, line ID: $lineID";
}

require("../dao.php");

$db = new ForeignEXDB('../db/db.sqlite');
if($db->isTableExisted("target") === false) {
    $db->createTables();
}

if($eventType === "join") {
    if($db->addLineID($lineID, $typeID) === false) {
        echo "新增LINE ID失敗";
        return;
    }
    echo "新增成功";
} else if($eventType === "leave") {
    if($db->deleteLineID($lineID) === false) {
        echo "刪除LINE ID失敗";
        return;
    }
    echo "退出成功";
}

?>

