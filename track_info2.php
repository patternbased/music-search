
	<head>
	<style>
	@import url('http://fonts.googleapis.com/css?family=Poiret+One');

	h1 {
		font-family: 'Poiret One';
	}

	.catalog-button{
		height: 50px;
		width: 320px;
		background-color: #f6f6f6;
		border: 1px solid #666666;
		font-family: 'Poiret One';
		font-size: 24px;
		color: #666666;
		text-align: center;
		font-style: normal;
		line-height: 36px;
		margin-top: 25px;
	}

	.catalog-button:hover{
		background-color: #33b5e5;
		border: 1px solid #33b5e5;
		color: #ffffff;
	}

	.catalog-button:visited{
		background-color: #f6f6f6;
		border: 1px solid #666666;
		color: #666666;
	}
	</style>
	</head>



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
	$track_title = $_POST[TrackTitle];
?>

<?php
	// 2. Build the MYSQL Query to search the Tracks table based on the form sliders;
  // until pagination/scrollination is built in, limit to 25 results

	$query  = "SELECT * ";
	$query .= "FROM Tracks ";
	$query .= "WHERE Title = '$track_title' ";
	$query .= "LIMIT 1";

	// uncomment the following echo statement to see a printout of the database query
	// echo "Database Query: " . $query . "<br />";

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

		<?php
		echo "<iframe width=\"100%\" height=\"166\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/" . $subject["SoundCloudId"] . "&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false\"></iframe>";
		echo "<a href=\"#\" class=\"catalog-button\">License Music</a>";
		echo "<a href=\"#\" class=\"catalog-button\">Similar Tracks</a>";
		echo "<a href=\"#\" class=\"catalog-button\">More Info3</a>";
		echo "<a href=\"#\" class=\"catalog-button\">More Info4</a>";
		?>

		<li><h1><?php echo "Artist: " . $subject["ArtistName"] . "<br />Title: " . $subject["Title"] . "<br />Key: " . $subject["MusicKey"] . "<br />BPM: " . $subject["BPMF"] . "<br /><br />Description: " . $subject["Description"]; ?></h1></li>


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
