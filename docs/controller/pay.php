<?php
	require_once('../model/model.php');
	$array = array(	"serial" => rand(10000000, 99999999),
					"type" => $_POST['type'],
					// "timestamp" => "bar",
					"count" => $_POST['count'],
					"activated" => 0,
					"number" => $_POST['number']);
	// Пример: function( 'table', array('key' => 'value', 'key' => 'value'))
	db_insert_data('tickets', $array);
	header('Location: '.DOMAIN);
?>