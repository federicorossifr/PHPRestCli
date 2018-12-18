<?php
class RestCli {
	private $baseUrl;
	private $curl;
	private $debug = 0;
	/**
		Consturct the RestCli object with the given $baseUrl,
		in the format http[s]://www.example.org
	*/
	function __construct($baseUrl)
	{
		$this->baseUrl = $this->cleanBaseUrl($baseUrl);;
		$this->curl = curl_init();
		
	}

	/**
		Tidies up after an API call
	*/
	private function finishCall() {
		curl_close($this->curl);
		$this->curl = curl_init();
	}

	/**
		Removes the possible '/' from the end of the $url
	*/
	private function cleanBaseUrl($url) {
		$path = "/";
		$length = strlen($path);
		if ($length == 0) return true;
		if(substr($url, -$length) === $path) {
			return substr($url,0,strlen($url)-$length);
		} else {
			return $url;
		}
	}

	/**
		Returns the baseUrl for the class instance
	*/
	protected function getUrl() {
		return $this->baseUrl;
	}

	public function setDebugLevel($level) {
		$this->debug = $level;
	}

	protected function log($message,$level) {
		if($level >= $this->debug) 
			echo "<em>" . $message . "</em>" . "<br>";
	}


	/**
		Performs an HTTP GET request to the REST
		endpoint $endpoint with the GET query $query
		If $json is passed as TRUE the result will be
		decode into a PHP object.
	*/
	protected function GET($endpoint,$query,$json,$headers=0) {
		$reqUrl = $this->baseUrl . $endpoint . $query;
		$this->log("[GET] " .$reqUrl,1);
		curl_setopt_array($this->curl, array(
				CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $reqUrl
		));
		if($headers)
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);			
		$response = curl_exec($this->curl);
		if($json) {
			$response = json_decode($response);
		}
		$this->finishCall();
		return $response;
	}

	protected function GETf($endpoint,$query,$fileHandle,$headers=0) {
		$reqUrl = $this->baseUrl . $endpoint . $query;
		$this->log("[GET] " .$reqUrl,1);
		curl_setopt_array($this->curl, array(
				CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $reqUrl
		));
		if($headers)
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);			
		$response = curl_exec($this->curl);
		$this->finishCall();
		return $response;
	}

	/**
		Performs an HTTP POST request to the REST
		endpoint $endpoint with the GET query $query
		and the POST payload represented by the array $postData
		in the format.
		array(
			"field" => "field_value"
		)
		If $json is passed as TRUE the result will be
		decode into a PHP object.			
	*/
	protected function POST($endpoint,$getQuery,$postData,$json,$headers=0) {
		$reqUrl = $this->baseUrl . $endpoint . $getQuery;
		$this->log("[POST] " . $reqUrl,1);
		curl_setopt_array($this->curl, array(
				CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $reqUrl,
		    CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $postData,
		));
		if($headers)
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($this->curl);
		if($json) {
			$response = json_decode($response);
		}
		$this->finishCall();
		return $response;
	}	

	/**
		Performs an HTTP PUT request to the REST
		endpoint $endpoint with the GET query $query
		and the POST payload represented by the array $postData
		in the format.
		array(
			"field" => "field_value"
		)
		If $json is passed as TRUE the result will be
		decode into a PHP object.			
	*/
	protected function PUT($endpoint,$getQuery,$putData,$json) {
		$reqUrl = $this->baseUrl . $endpoint . $getQuery;
		$this->log("[PUT] " . $reqUrl,1);
		curl_setopt_array($this->curl, array(
				CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $reqUrl,
				CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_POSTFIELDS => $putData
		));
		$response = curl_exec($this->curl);
		if($json) {
			$response = json_decode($response);
		}
		$this->finishCall();
		return $response;			
	}	



	/**
		Performs an HTTP DELETE request to the REST
		endpoint $endpoint with the GET query $query
		If $json is passed as TRUE the result will be
		decode into a PHP object.
	*/
	protected function DELETE($endpoint,$query,$json) {
		$reqUrl = $this->baseUrl . $endpoint . $query;
		$this->log("[DELETE] " .$reqUrl,1);
		curl_setopt_array($this->curl, array(
				CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $reqUrl,
			CURLOPT_CUSTOMREQUEST => "DELETE"
		));
		$response = curl_exec($this->curl);
		if($json) {
			$response = json_decode($response);
		}
		$this->finishCall();
		return $response;
	}		
}
