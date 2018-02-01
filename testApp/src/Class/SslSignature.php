<?php


// function signJSON($json, $path){

// }


// public function generateSslKeys(){

// 	if(file_exists('private_key.pem') == FALSE && file_exists('public_key.pem') == FALSE){

// 		//create new private and public key
// 		$new_key_pair = openssl_pkey_new(array(
// 		    "private_key_bits" => 2048,
// 		    "private_key_type" => OPENSSL_KEYTYPE_RSA,
// 		));
// 		openssl_pkey_export($new_key_pair, $private_key_pem);

// 		$details = openssl_pkey_get_details($new_key_pair);
// 		$public_key_pem = $details['key'];

// 		file_put_contents('private_key.pem', $private_key_pem);
// 		file_put_contents('public_key.pem', $public_key_pem);
// 	} else {
// 		$private_key_pem = file_get_contents('private_key.pem');
// 		$public_key_pem = file_get_contents('public_key.pem');
// 	}

// }

// public function createSignature(){

// 	//Create signature
// 	openssl_sign($json, $signature, $private_key_pem, OPENSSL_ALGO_SHA256);
// 	//Add signature to object
// 	$jsonObj->sign = base64_encode($signature);
// 	$json = json_encode($jsonObj);
// 	file_put_contents($path . $_FILES['fname']['name'], $json);

// 	unset($json->sign);
// 	$ok = openssl_verify(trim($json), $signature, $public_key_pem, OPENSSL_ALGO_SHA256);
// 	var_dump($ok);

// 	echo '<a href="'.$path . $_FILES['fname']['name'].'">Get signed</a><br>';

// }