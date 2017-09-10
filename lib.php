

<?php 

    echo 'token-> '.$_GET['token'];
    echo 'action-> '. $_GET['action'];

    if($_GET['token']=='9999'){
        if($_GET['action']=='push')echo Push($get_token);
    }else{
        return;
    }

    function Push() {
        // Build message to reply back
        //$url = 'http://democlaimpa.rvp.co.th/Services/line_reply.ashx?text='.urlencode('ดัม');
        $url = 'http://163.44.197.45/OJAmeeting/LineAPI/Push?token='.$_GET['token'];
        //echo $url.'<br />';
        $json = file_get_contents($url);

        $json_a=json_decode($json,true);
        echo $json_a["userID"].'<br />';
        echo $json_a["text"].'<br />';
        
        $access_token = 'mApA9dA4vBkZddHCyLrQ6xkK4FOBQWii2hCpCp2TaH340/LB60kdCjlZFxoxZkAWRudTMqnXefQkEh8v1V92dAFNDbWovSt+vGDpYoUdIzVHmDJfL+XkVrTLDWug46RACDK4NU0UuLvAHav8PlC+ZQdB04t89/1O/w1cDnyilFU=ISSUE';        
        $to = $json_a["userID"];
        $text = $json_a["text"];

        if($to == '') return; if($text == '') return;
        //-----------------------------------------------------------------
        $messages = [
            'type' => 'text', //Ucd7a7d735cb377cbf5e2f65ed29d44a7
            'text' => $text
        ];

        // Make a POST Request to Messaging API to reply to sender
        $url = 'https://api.line.me/v2/bot/message/push';
        $data = [
            'to' => $to,
            'messages' => [$messages],
        ];

        $post = json_encode($data);
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result . "\r\n";
        echo "OK";
        //-----------------------------------------------------------------
    }
   
?>