<?php

$dir = [];

$dir[]    = __DIR__ . '\Class';
$dir[]    = __DIR__ . '\Controller';
$dir[]    = __DIR__ . '\Model';

$files = [];

foreach ($dir as $path) {


	// echo '<pre>';
	// var_dump($path);
	// echo '</pre>';

	$filesArray = array_diff(scandir($path), array('..', '.'));
	foreach ($filesArray as $file) {
		$files[] = $path . '\\' . $file;
	}
}

foreach ($files as $file) {

	// echo '<pre>';
	// var_dump($file);
	// echo '</pre>';


	require_once $file;
}
