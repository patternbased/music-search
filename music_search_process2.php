<?php
	// 1. Create a database connection
	$dbhost = "localhost";
	$dbuser = "wordpress_dbuser";
	$dbpass = "doody!pp74mizzle";
	$dbname = "patternbased_db";
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	// Test if connection occured
	if(mysqli_connect_errno()) {
	  die("Database connection failed: " .
	  	mysqli_connect_error() .
  	  	" (" . mysqli_connect_errno() . ")"
	  );
	}
?>

<?php
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
?>

<?php
	// 2. Perform database queryinclude 'process.php';

	$query  = "SELECT * ";
	$query .= "FROM Tracks ";
	$query .= "WHERE SoundCloudID > 1 ";
	$query .= "AND Rhythm BETWEEN $rhythm_low AND $rhythm_high ";
	$query .= "AND Speed BETWEEN $speed_low AND $speed_high ";
	$query .= "AND Light BETWEEN $light_low AND $light_high ";
	$query .= "AND Com BETWEEN $com_low AND $com_high ";
	$query .= "ORDER BY Rate DESC, BPMF ASC";

	$result = mysqli_query($connection, $query);
	// Test if there was a query error
	if (!$result) {
		die("Database query failed.");
	}
?>

		<ul>
		<?php
			// 3. Use returned data (if any)
			while($subject = mysqli_fetch_assoc($result)) {
				// output data from each row
		?>

		<li><?php echo "Title: " . $subject["Title"]?></li>

		<?php
		echo "<iframe width=\"100%\" height=\"166\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/" . $subject["SoundCloudId"] . "&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false\"></iframe>";
		?>


		<br>

		<br><br><br><br>

	  <?php
			}
		?>
		</ul>

		<?php
		  // 4. Release returned data
		  mysqli_free_result($result);
		?>

<?php
  // 5. Close database connection
  mysqli_close($connection);
?>
