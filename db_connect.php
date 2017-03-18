<?php

	$dbhost = 'localhost';
	$dbuser = 'timetable';
	$dbpass = 'baseerkhan';
	$dbname = 'timetable';

	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

	/* check connection */
	if ($conn->connect_errno) {
		die($conn->connect_error);
	}

?>