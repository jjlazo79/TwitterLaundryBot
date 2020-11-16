<?php

namespace TweetBot;

/**
 * Import classes
 */
require_once 'classes/class-Config.php';
require_once 'classes/class-GetWheather.php';
require_once 'classes/class-MessageLogic.php';
require_once 'classes/class-TweetBot.php';

/**
 * Get parameters
 */
if (isset($_GET['cityCode']) && !empty($_GET['cityCode'])) {
	$cityCode = $_GET['cityCode'];
}

/**
 * Get wheather data
 */
$wheather         = new GetWheather;
$parseData        = $wheather->GetData($cityCode);
$objectCurrentDay = $parseData[0]->prediccion->dia[0];
$objectNextDay    = $parseData[0]->prediccion->dia[1];

/**
 * Get human readable messages
 */
// 06:00 morning information
if (isset($_GET['time']) && $_GET['time'] === 'morning') {

	$morning = array();
	$morning['chancePrecipitation'] = $objectCurrentDay->probPrecipitacion[4]->value;
	$morning['skyState']            = $objectCurrentDay->estadoCielo[4]->value;
	$morning['skyStateDes']         = $objectCurrentDay->estadoCielo[4]->descripcion;
	$morning['windDir']             = $objectCurrentDay->viento[4]->direccion;
	$morning['windSpeed']           = $objectCurrentDay->viento[4]->velocidad;
	$morning['temperature']         = $objectCurrentDay->temperatura->dato[0]->value;
	$morning['relativeHumidity']    = $objectCurrentDay->humedadRelativa->dato[0]->value;

	$tweetMessage = new MessageLogic;
	$tweetContent = $tweetMessage->messageLogic($morning, $_GET['time']);
}


// 12:00 afternoon information
if (isset($_GET['time']) && $_GET['time'] === 'noon') {

	$noon = array();
	$noon['chancePrecipitation'] = $objectCurrentDay->probPrecipitacion[5]->value;
	$noon['skyState']            = $objectCurrentDay->estadoCielo[5]->value;
	$noon['skyStateDes']         = $objectCurrentDay->estadoCielo[5]->descripcion;
	$noon['windDir']             = $objectCurrentDay->viento[5]->direccion;
	$noon['windSpeed']           = $objectCurrentDay->viento[5]->velocidad;
	$noon['temperature']         = $objectCurrentDay->temperatura->dato[1]->value;
	$noon['relativeHumidity']    = $objectCurrentDay->humedadRelativa->dato[1]->value;

	$tweetMessage = new MessageLogic;
	$tweetContent = $tweetMessage->messageLogic($noon, $_GET['time']);
}


// 18:00 next day information
if (isset($_GET['time']) && $_GET['time'] === 'afternoon') {

	$nexDay = array();
	$nexDay['chancePrecipitation'] = $objectNextDay->probPrecipitacion[2]->value;
	$nexDay['skyState']            = $objectNextDay->estadoCielo[2]->value;
	$nexDay['skyStateDes']         = $objectNextDay->estadoCielo[2]->descripcion;
	$nexDay['windDir']             = $objectNextDay->viento[2]->direccion;
	$nexDay['windSpeed']           = $objectNextDay->viento[2]->velocidad;
	$nexDay['temperature']         = $objectNextDay->temperatura->dato[2]->value;
	$nexDay['relativeHumidity']    = $objectNextDay->humedadRelativa->maxima;

	$tweetMessage = new MessageLogic;
	$tweetContent = $tweetMessage->messageLogic($nexDay, $_GET['time']);
}


/**
 * Twitter call to publish
 */

// Production credentials
$api_key          = TweetBotConfig::TWITTER_API_KEY;
$api_secret       = TweetBotConfig::TWITTER_API_SECRET;
$access_token     = TweetBotConfig::TWITTER_ACCESS_TOKEN;
$access_token_key = TweetBotConfig::TWITTER_ACCESS_TOKEN_KEY;

$tweet = new tweet_bot;
$tweet->setKey($api_key, $api_secret, $access_token, $access_token_key);
// $result = $tweet->tweet($tweetContent);

/*******************************/
echo '<p>';
print_r($tweetContent);
echo '</p>';
echo '<pre>';
print_r($result);
echo '</pre>';
/*******************************/
