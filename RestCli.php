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
		public function getUrl() {
			return $this->baseUrl;
		}

		public function setDebugLevel($level) {
			$this->debug = $level;
		}

		private function log($message) {
			if($this->debug) 
				echo $message;
		}


		/**
			Performs an HTTP GET request to the REST
			endpoint $endpoint with the GET query $query
			If $json is passed as TRUE the result will be
			decode into a PHP object.
		*/
		public function GET($endpoint,$query,$json) {
			$reqUrl = $this->baseUrl . $endpoint . $query;
			$this->log("[GET] " .$reqUrl);
			curl_setopt_array($this->curl, array(
   				CURLOPT_RETURNTRANSFER => 1,
    			CURLOPT_URL => $reqUrl
			));
			$response = curl_exec($this->curl);
			if($json) {
				$response = json_decode($response);
			}
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
		public function POST($endpoint,$getQuery,$postData,$json) {
			$reqUrl = $this->baseUrl . $endpoint . $getQuery;
			$this->log("[POST] " . $reqUrl);
			curl_setopt_array($this->curl, array(
   				CURLOPT_RETURNTRANSFER => 1,
    			CURLOPT_URL => $reqUrl,
    		    CURLOPT_POST => 1,
    			CURLOPT_POSTFIELDS => $postData
			));
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
		public function PUT($endpoint,$getQuery,$putData,$json) {
			$reqUrl = $this->baseUrl . $endpoint . $getQuery;
			$this->log("[PUT] " . $reqUrl);
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
		public function DELETE($endpoint,$query,$json) {
			$reqUrl = $this->baseUrl . $endpoint . $query;
			$this->log("[DELETE] " .$reqUrl);
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
