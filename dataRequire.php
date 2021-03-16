<?php 
$arrDir = [ '.data.csv'];
$path = './';

$file = fopen('.data.csv', 'r');
	while (($line = fgetcsv($file)) !== FALSE) {
		//$line is an array of the csv elements
        var_dump();
        echo "<pre>" . print_r(explode(' ',$line), 1); exit;
		$event[array_shift($line)] = $line;
	}

	fclose($file);
	
	echo "<pre>" . print_r($event, 1); exit;