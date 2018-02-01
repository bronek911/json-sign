<?php

class JsonController{

	private $jsonsPath = __DIR__ . '/../../../uploads/';


	//getJsonObject
	public function getAllJsons(){

		if(is_dir($this->jsonsPath)){
			$filesArray = array_diff(scandir($this->jsonsPath), array('..', '.'));
			return $filesArray;
		} else {
			return 'No files';
		}

	}

	public function getSignatureByDir($filename){

		$data = file_get_contents($this->jsonsPath . $filename);

		$obj = json_decode($data);
		$signature = $obj->sign;

		return $signature;
		// die;

	}

	//checkDir
	public function checkDir($path){
		if(is_dir($path) == FALSE){
			mkdir($path);
			//return 1 if new dir created
			return 1;
		} else {
			return 0;
		}
	}

	//saveFile
	public function saveFile($path, $tmp, $file){

		move_uploaded_file($tmp, $path . '\\' . $file);
		$path .= '\\' .  $_FILES['fname']['name'];

		return $path;
	}

	//getJsonObject
	public function getJsonObject($path){

		//Get content of json
		$json = file_get_contents($path);

		//Decode JSON
		$jsonObj = json_decode($json);

		return $jsonObj;
	}

	//getJsonObject
	public function getJsonString($path){

		//Get content of json
		$json = file_get_contents($path);

		return $json;
	}


}