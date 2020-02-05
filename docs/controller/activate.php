<?php
	require_once('../model/model.php');
	//vardump($_POST);
	db_update_data('tickets', array('activated' => 1), array('id' => $_POST['rowid']));
	header('Location: '.DOMAIN);
?>