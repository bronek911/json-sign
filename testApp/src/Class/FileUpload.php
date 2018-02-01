<?php

	// require __DIR__ . '\..\autoload.php';

	// $path = __DIR__ . '\uploads';

	// $JsonController = new JsonController;
	// $JsonController->checkDir($path);

	class FileUpload{

		private $path = __DIR__ . '\..\..\..\uploads';

		private $files;

		private $jsonController;

		public function __construct(){
			// $this->files = $files;
			// $this->jsonController = $jsonController;

			// return $this;
		}

		public function uploadAction($files, $jsonController){

			$response = [];

			//Move file from temp
			$path = $jsonController->saveFile($this->path, $files['fname']['tmp_name'], $files['fname']['name']);
			$link = '.\uploads\\' . $files['fname']['name'];

			// echo '<pre>';
	    	// var_dump($link);
	    	// var_dump($jsonController);
	    	// var_dump($path);
	    	// echo '</pre>';
	    	// die;

			$jsonObj = $jsonController->getJsonObject($path);
			$json = $jsonController->getJsonString($path);

			$response['upload'] = [];
			$response['upload']['status'] = 1;
			$response['upload']['message'] = 'Upload success!';
			$response['upload']['filename'] = $_FILES['fname']['name'];
			$response['upload']['filesize'] = $_FILES['fname']['size'];

			// echo "File uploaded successfully !!! <br />";
			// echo "Filename : ". $_FILES['fname']['name']."<br />";
			// echo "Size : " . $_FILES['fname']['size']  . "<br />";

			$simpleSignature = new SimpleSignature;

			//Check if file is signed
			if(isset($jsonObj->sign)){

				//Signed
				$return = $simpleSignature->verify($jsonObj);

				$response['verify'] = [];

				if($return == 1){
					$response['verify']['status'] = 1;
					$response['verify']['message'] = 'Json exists and is verified correctly.';
					// echo 'Json exists and is verified correctly.';
				} else {
					$response['verify']['status'] = 0;
					$response['verify']['message'] = 'Json exists and is verified incorrectly.';
					// echo 'Json exists and is verified incorrectly.';
				}
					
			} else {
				$return = $simpleSignature->sign($json, $path);
				$response['sign'] = [];

				if(isset($return['hash'])){

					$response['sign']['status'] = 1;
					$response['sign']['message'] = 'Signature succesfull!';
					$response['sign']['link'] = $link;

					// echo '</br>Signature succesfull!</br>';
					// echo '<a href="'.$link.'">Get signed</a><br>';
				}
			}

			return $response;
		}
	}
    
?>