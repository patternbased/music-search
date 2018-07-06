<?php
	// 1. Create a database connection
	$dbhost = "localhost";
	$dbuser = "wordpress_dbuser";
	$dbpass = "pw_redacted";
	$dbname = "patternbased_db";
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	// Test if connection occured
	if(mysqli_connect_errno()) {
	  die("Database connection failed: " .
	  	mysqli_connect_error() .
  	  	" (" . mysqli_connect_errno() . ")"
	  );
	}

  // 1.5 Split Form Array into individual elements
	$rhythm_full = $_POST[Rhythm];
	$speed_full = $_POST[Speed];
	$light_full = $_POST[Light];
	$com_full = $_POST[Com];
	$rhythm_low = (substr($rhythm_full,0,1));
	$rhythm_high = (substr($rhythm_full,2,2));
	$speed_low = (substr($speed_full,0,1));
	$speed_high = (substr($speed_full,2,2));
	$light_low = (substr($light_full,0,1));
	$light_high = (substr($light_full,2,2));
	$com_low = (substr($com_full,0,1));
	$com_high = (substr($com_full,2,2));

	// 2. Perform database queryinclude 'process.php';

	$query  = "SELECT * ";
	$query .= "FROM Tracks ";
	$query .= "WHERE SoundCloudID > 1 ";
	$query .= "AND Rhythm BETWEEN $rhythm_low AND $rhythm_high ";
	$query .= "AND Speed BETWEEN $speed_low AND $speed_high ";
	$query .= "AND Light BETWEEN $light_low AND $light_high ";
	$query .= "AND Com BETWEEN $com_low AND $com_high ";
	$query .= "ORDER BY Rate DESC, BPMF ASC";

	echo "Database Query: " . $query . "<br />";

	$result = mysqli_query($connection, $query);

	$arr = array();

 	while($obj =  mysqli_fetch_assoc($result)) {
		$arr[] = $obj;
	}
	
	header('Content-Type: application/json');
	echo(json_encode($arr));

  mysqli_close($connection);
