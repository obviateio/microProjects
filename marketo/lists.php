<?php
$list = new ListById();
$list->id = 1001;
print_r($list->getData());

class ListById{
	private $host = "https://ENDPOINT.mktorest.com";
	private $clientId = "asdf-asdf-asdf-asdf";
	private $clientSecret = "secretsecretsecret";
	public $id;//id of the list to retrieve

	public function getData(){
		$url = $this->host . "/rest/v1/lists/" . $this->id . ".json?access_token=" . $this->getToken();
		$ch = curl_init($url);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = curl_exec($ch);
		return $response;
	}

	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}
}
