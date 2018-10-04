<?php

require("dao.php");

class Sender
{
    public function send($text, $imagePath) {
        $db = new ForeignEXDB(dirname(__FILE__) . '/db/db.sqlite');
        $rows = $db->getAllLineID();

        foreach($rows as $row) {
            $post_data = array(
                "to" => $row,
                "messages" => array(
                    array(
                        "type" => "text",
                        "text" => $text,
                    ),
                    array(
                        "type" => "image",
                        "originalContentUrl" => $imagePath,
                        "previewImageUrl" => $imagePath,
                    ),
                ),
            );
            $data_string = json_encode($post_data);
            //echo "$data_string\n";


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, LINE_MESSAGE_API_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer " . LINE_MESSAGE_API_ACCESS_TOKEN,
                "Content-Type: application/json",
            ));
            //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data)); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch); 
            echo 'LINE message API response: ' . $response;
            curl_close($ch);
        }
    }
}

?>

