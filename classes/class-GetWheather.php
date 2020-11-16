<?php

namespace TweetBot;

class GetWheather
{
	protected $basicURL;
	protected $endpoint;
	protected $apiKey;
	public $url;
	public $cityCode;

	public function __construct($cityCode)
	{
		$this->basicURL = TweetBotConfig::AEMET_URL;
		$this->endpoint = TweetBotConfig::AEMET_ENDPOINT;
		$this->cityCode = $cityCode;
		$this->apiKey   = TweetBotConfig::AEMET_API_KEY;
		$this->url      = $this->basicURL . $this->endpoint . $this->cityCode . "/?api_key=" . $this->apiKey;
	}

	public function GetData()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL            => $this->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "GET",
			CURLOPT_HTTPHEADER     => array(
				"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
			exit;
		}

		// Transform JSON to usefull data in PHP
		$responseJson     = json_decode($response, true);
		$jsonData         = file_get_contents($responseJson['datos']);
		$parseData        = json_decode($jsonData, false, 512, JSON_INVALID_UTF8_SUBSTITUTE);

		return $parseData;
	}
}
