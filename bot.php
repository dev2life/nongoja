<?php
$access_token = 'mApA9dA4vBkZddHCyLrQ6xkK4FOBQWii2hCpCp2TaH340/LB60kdCjlZFxoxZkAWRudTMqnXefQkEh8v1V92dAFNDbWovSt+vGDpYoUdIzVHmDJfL+XkVrTLDWug46RACDK4NU0UuLvAHav8PlC+ZQdB04t89/1O/w1cDnyilFU=ISSUE';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			$id = $event['message']['id'];

			//$type = $event['source']['type'];
			//try{$userId = $event["source"]["userId"];}catch{$userId="";}
			//try{$groupID =  $event["source"]["groupId"];}finally{$groupID='';}

			$userId = $event["source"]["userId"];
			$groupID='';
			try{$groupID =  $event["source"]["groupId"];}catch(Exception $e){$groupID = "";}
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			//$url = 'http://democlaimpa.rvp.co.th/Services/line_reply.ashx?text='.urlencode($text);
			//$text = file_get_contents($url);
			if($text =='โอจา อินโฟ') $text=$event['source'];
			else if($text =='โอจา ไอดี') $text=$userId;
			else if($text =='โอจา ไอดีห้อง') $text=$groupID;
			//###################################################################################
			// Group Register
			//else if(substr($text,0,40) =='โอจา ลงทะเบียน') {		
			else if(substr($text,0,5) =='REGIS') {
				//$url = 'http://163.44.197.45/OJAmeeting/LineAPI/GroupRegister';
				$url = 'http://ncjadfollowup.oja.go.th/LineAPI/GroupRegister';
				$url .= '?token=9999';
				$url .= '&lineGroupID='.$groupID;
				//$url .= '&lineMeetingID='.substr($text,-8);
				$url .= '&lineMeetingID='.$text;
				$text = file_get_contents($url);
				//$text = $url;
			}
			//###################################################################################
			else if(stripos($text, "หล่อ") !== false) {
				$text="หล่อม๊ากกกกกก!!!";
			}
			//###################################################################################
			else $text = '';

			if($text != '')
			{
				$messages = [
					'type' => 'text',
					'text' => $text
				];

				// Make a POST Request to Messaging API to reply to sender
				$url = 'https://api.line.me/v2/bot/message/reply';
				$data = [
					'replyToken' => $replyToken,
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
			}
		}
	}
}
echo "OK";


