<?php

	include_once '../../class/session.class.php';

	$sessionDestroy = new Session();
	$sessionDestroyResponse = $sessionDestroy->SessionDestroy();
	if($sessionDestroyResponse == true){
		header('location: ../../index.php');
	}
	else{
		header('location: ../../clientDashboard.php');
	}
	
?>