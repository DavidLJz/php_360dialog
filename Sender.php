<?php

namespace App\Libs\Dialog360;

use Exception;

class Sender
{
  protected const URL = 'https://waba.360dialog.io/';
  protected $api_key;

	function __construct(string $api_key)
	{
		$this->api_key = $api_key;
	}

  protected function post_request(string $endpoint, $data)
  {
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => self::URL . $endpoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 10,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $data,
		  CURLOPT_HTTPHEADER => array(
			'D360-API-KEY: ' . $this->api_key,
			'Accept: application/json',
			'Content-Type: application/json'
		  ),
		));

    $response = curl_exec($curl);
		
		if ( $error_msg = curl_error($curl) ) {
      throw new Exception($error_msg);
    }

    curl_close($curl);

    $response = json_decode($response, true);

    return $response;
  }

  public function send_template(Template $template)
  {
    return $this->post_request('v1/messages', strval($template));
  }
}