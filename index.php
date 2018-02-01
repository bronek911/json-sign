<?php

require_once __DIR__ . '/testApp/src/autoload.php';

$src = __DIR__ .'/testApp/src';

$jsonController = new jsonController();
$jsonFiles = $jsonController->getAllJsons();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_FILES['fname']['error'] == 0){
            
    	$upload = new FileUpload;
    	$response = $upload->uploadAction($_FILES, $jsonController);

    }else {

	    $response['error'] = [];
	    $response['error']['status'] = 1;

		switch ($_FILES['fname']['error']) {
		    case UPLOAD_ERR_NO_FILE:
	            $response['error']['message'] = "Select a file to upload.";
	         	break;
			 
		    case UPLOAD_ERR_INI_SIZE:
	            $response['error']['message'] = "The file size exceeds upload_max_filesize in php.ini";
	         	break;
		 	
	 	    default:
	 	    	$response['error']['message'] = "Upload failed";
		        break;
		}
	}   
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Open Tech Guides - File Upload Demo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
	<link rel="stylesheet" href="<?php 
			echo 'testApp\src\Resources\css\main.css'; 
		?>">
</head>
<body>

<div class="container-fluid">
	<div class="clearfix"></div>
	<div class="row">
		<div class="col"></div>
		<div class="col">
			<form enctype="multipart/form-data" action="index.php" method="post" >				
				<label class="custom-file d-block">
		            <input data-toggle="custom-file" data-target="#company-logo" type="file" name="fname" accept="application/json" class="custom-file-input">
		            <span id="company-logo" class="custom-file-control custom-file-name" data-content="Choose file..."></span>
		        </label>
				<input class="form-control btn btn-success" type="submit" value="Upload" name="submit" />
			</form>
		</div>
		<div class="col"></div>
	</div>
	<div class="clearfix"></div>
	<div class="row">

		<div class="col"></div>
		<div class="col">
			<?php
			if(isset($response['upload'])){
				echo '
				<div class="card-response card">
					<div class="card-body text-center card-json">
						<h5 class="card-title">'.$response['upload']['message'].'</h5>
					    <h6 class="card-subtitle mb-2 text-muted">Filename: ' .$response['upload']['filename']. '</h6>
						<p class="card-text">Filesize: ' .$response['upload']['filesize']. '</p>';

						if(isset($response['verify'])){

							echo '<p class="card-text verify" data-status="'.$response['verify']['status'].'">'
									. $response['verify']['message'] . 
								'</p>';
						}

						if(isset($response['sign'])){

							echo '<p class="card-text sign" data-status="'.$response['sign']['status'].'">'
									. $response['sign']['message'] . 
								'</p>';
						}

						if(isset($response['sign'])){
							echo '<a href="'. $response['sign']['link'] . '" class="card-link btn btn-primary btn-sm btn-block">Get signed JSON</a>';
						}
					 echo '</div>
				</div>';
			} else if(isset($response['error'])){
				if($response['error']['status'] == 1){

				}
				echo '<div class="text-center text-red"><h5>' . $response['error']['message'] . '</h5></div>';
			}
		?>
		</div>
		<div class="col"></div>


	</div>
	<div class="clearfix">
		<h1>Files:</h1>
	</div>
	<div class="row">
		
		<?php
			foreach($jsonFiles as $jsonFile){

				echo '
					<div class="card text-center card-json" style="width: 18rem;">
					  <div class="card-body">
					    <h5 class="card-title">'.$jsonFile.'</h5>
					    <a href="./uploads/'.$jsonFile.'" class="btn btn-primary btn-sm btn-block">Get JSON</a>
					    <a href="#" class="btn btn-primary btn-sm btn-block btn-get-sign" data-sign="'.$jsonController->getSignatureByDir($jsonFile).'">Copy signature to clipboard</a>
					    <i class="material-icons file-delete" data-remove="./uploads/'.$jsonFile.'">highlight_off</i>
					  </div>
					</div>
				';

			}

		?>

	</div>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="<?php 
			echo 'testApp\src\Resources\js\main.js'; 
		?>"></script>
</html>