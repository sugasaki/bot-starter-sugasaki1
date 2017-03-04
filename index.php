<?php

require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

$signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log("parseEventRequest failed. InvalidSignatureException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log("parseEventRequest failed. UnknownEventTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log("parseEventRequest failed. UnknownMessageTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log("parseEventRequest failed. InvalidEventRequestException => ".var_export($e, true));
}



$emoji['office'] = hex2bin("F4808882F48085B7F48FBFBF");
$emoji['calendar'] = hex2bin("F4809082F48087A7F48FBFBF");
$emoji['time1'] = hex2bin("F4809482F480878AF48FBFBF");
$emoji['time2'] = hex2bin("F4809482F4808781F48FBFBF");
//$emoji['kao1'] = mb_convert_encoding(hex2bin("0001F623"), 'UTF-8', 'UTF-32');
//$emoji['uzu'] = mb_convert_encoding(hex2bin("0001F300"), 'UTF-8', 'UTF-32');


foreach ($events as $event) {
//  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
//    error_log('Non message event has come');
//    continue;
  
 // if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
 //   error_log('Non text message has come');
 //   continue;
 // }

//  if (($event instanceof \LINE\LINEBot\Event\MessageEvent\MessageEvent)) {
//    $message = 'ありゃりゃ' . $event->getText();
//  }
    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
        $message = $event->getText();
        $bot->replyText($reply_token, $text);
    } elseif ($event instanceof \LINE\LINEBot\Event\BeaconDetectionEvent) {
        $message = $event->getReplyToken();
    }


  error_log('input:' . $event->getText());

  //error_log($emoji['kao1']);
  //error_log($emoji['uzu']);
  //error_log($emoji['time2']);


  //  $message = "ありゃりゃ(happy)" . $event->getText();
  // $message = "ありゃりゃ" . $emoji['kao1'] . $emoji['time2']. $emoji['uzu'];
    //$emoji = hex2bin( "F4809082F48087B3626F6F6BF48FBFBFF4809082F48087AD72756C6572F48FBFBFF4809082F48087B567696674F48FBFBF");
  //$message = '近くにいますよ・・・' . $event->getText();


  $bot->replyText($event->getReplyToken(), $message);
}

?>