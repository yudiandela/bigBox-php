<?php
############ bigbox api-key
$bigbox_api_key = 'r7Ctvx5drVpac7TrfvCYcye2DgLCKIRf';
$bot_key = 'simade_telkom_bot';
#####
$entityBody = file_get_contents('php://input');
$status_resp = 0;
// validate type request data
$arr = json_decode($entityBody);
if (is_object($arr)) {
    if (isset($arr->message) && isset($arr->uniqid)) {
        $status_resp = 1;
    } else {
        $msg_resp = "Bad request, required parameter 'message' and 'uniqid'";
    }
} else {
    $msg_resp = "Bad request, request should in 'json' format";
}

// do backend service reply
if ($status_resp == 1) {
    $msg_resp = 'Reply from backend developer';
    $response = array(
        'reply' => $msg_resp
    );
    $url = 'https://api.thebigbox.id/telegram-config/1.1.0/replychat/' . $bot_key . '/' . $arr->uniqid;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'x-api-key:' . $bigbox_api_key));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    print_r($result);
    curl_close($ch);
} else {
    echo $msg_resp;
}
