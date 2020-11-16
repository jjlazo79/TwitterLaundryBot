<?php

namespace TweetBot;

use Abraham\TwitterOAuth\TwitterOAuth;

class tweet_bot
{
	function oauth()
	{
		require_once("twitteroauth/autoload.php");
		$con = new TwitterOAuth($this->api_key, $this->api_secret, $this->access_token, $this->access_token_secret);
		return $con;
	}

	function tweet($text)
	{
		$con = $this->oauth();
		$status = $con->post('statuses/update', array('status' => $text));
		return $status;
	}

	function setKey($api_key, $api_secret, $access_token, $access_token_secret)
	{
		$this->api_key             = $api_key;
		$this->api_secret          = $api_secret;
		$this->access_token        = $access_token;
		$this->access_token_secret = $access_token_secret;
	}
}
