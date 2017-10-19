<?php
	session_start();
	if(isset($_SESSION['uid'])){
		if(substr($_SESSION['uid'], 0, 3) === 'ang'){
			echo 'authentified';
		}
		else if(substr($_SESSION['uid'], 0, 3) === 'vie'){
			echo 'viewer';
		}
	}
?>