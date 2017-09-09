

<?php 

    $token = $_GET['token'];
    $action = $_GET['action'];
    
    echo $token.'<br />';
    echo $action.'<br />';

    if($token=='9999'){
        if($action=='push')echo Push();
    }else{
        return;
    }


    function Push() {
        $access_token = 'mApA9dA4vBkZddHCyLrQ6xkK4FOBQWii2hCpCp2TaH340/LB60kdCjlZFxoxZkAWRudTMqnXefQkEh8v1V92dAFNDbWovSt+vGDpYoUdIzVHmDJfL+XkVrTLDWug46RACDK4NU0UuLvAHav8PlC+ZQdB04t89/1O/w1cDnyilFU=ISSUE';

        // Get POST body content
        //$content = file_get_contents('php://input');
        // Parse JSON
        //$events = json_decode($content, true);

        // Build message to reply back
        $url = 'http://democlaimpa.rvp.co.th/Services/line_reply.ashx?text='.urlencode('ดัม');
        $text = file_get_contents($url);

        if($text == '') return;

        $to_id = ['to' => 'Ucd7a7d735cb377cbf5e2f65ed29d44a7'];
        $messages = [
            'type' => 'text',
            'text' => $text
        ];

        // Make a POST Request to Messaging API to reply to sender
        $url = 'https://api.line.me/v2/bot/message/push';
        $data = [
            'to' => 'Ucd7a7d735cb377cbf5e2f65ed29d44a7',
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
    }
   
?>