<?php
$list = new ListCustomObjects();
print_r($list->getData());

class ListCustomObjects{
	private $host = "https://ENDPOINT.mktorest.com";
	private $clientId = "asdf-asdf-asdf-asdf";
	private $clientSecret = "secretsecretsecret";
	public $names;//array of custom object names to list

	public function getData(){
		$url = $this->host . "/rest/v1/customobjects.json?access_token=" . $this->getToken();
		if (isset($this->names)){
			$url .= "&names=" . $this::csvString($this->names);
		}
		$ch = curl_init($url);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = curl_exec($ch);
		return $response;
	}

	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}
	private static function csvString($fields){
		$csvString = "";
		$i = 0;
		foreach($fields as $field){
			if ($i > 0){
				$csvString = $csvString . "," . $field;
			}elseif ($i === 0){
				$csvString = $field;
			}
		}
		return $csvString;
	}
}
