<?php

	class FileUpload{

		private $path = __DIR__ . '/../../../uploads';

		private $files;

		private $jsonController;

		public function uploadAction($files, $jsonController){

			$response = [];

			//Move file from temp
			$path = $jsonController->saveFile($this->path, $files['fname']['tmp_name'], $files['fname']['name']);
			$link = './uploads/' . $files['fname']['name'];

			$jsonObj = $jsonController->getJsonObject($path);
			$json = $jsonController->getJsonString($path);

			$response['upload'] = [];
			$response['upload']['status'] = 1;
			$response['upload']['message'] = 'Upload success!';
			$response['upload']['filename'] = $_FILES['fname']['name'];
			$response['upload']['filesize'] = $_FILES['fname']['size'];

			$simpleSignature = new SimpleSignature;

			//Check if file is signed
			if(isset($jsonObj->sign)){

				//Signed
				$return = $simpleSignature->verify($jsonObj);

				$response['verify'] = [];

				if($return == 1){
					// Json exists and is verified correctly
					$response['verify']['status'] = 1;
					$response['verify']['message'] = 'Json exists and is verified correctly.';
				} else {
					// Json exists and is verified incorrectly
					$response['verify']['status'] = 0;
					$response['verify']['message'] = 'Json exists and is verified incorrectly.';
					
				}
					
			} else {
				$return = $simpleSignature->sign($json, $path);
				$response['sign'] = [];

				if(isset($return['hash'])){

					$response['sign']['status'] = 1;
					$response['sign']['message'] = 'Signing succesfull!';
					$response['sign']['link'] = $link;
				}
			}

			return $response;
		}
	}
    
?>