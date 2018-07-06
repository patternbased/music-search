<html>
<head>
  <style>
	@import url('http://fonts.googleapis.com/css?family=Poiret+One');

	.catalog-button{
		display: block;
		height: 50px;
		width: 150px;
		background-color: #f6f6f6;
		border: 1px solid #666666;
		font-family: 'Poiret One';
		font-size: 24px;
		color: #666666;
		text-align: center;
		font-style: normal;
		line-height: 36px;
		margin-top: 10px;
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

<script type='text/javascript' src='api.soundcloud.js'></script>

</head>

<body>

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
?>

<?php
  // 1.5 Split Form Array into individual elements
	$rhythm_full = $_POST[PBRhythm];
	$speed_full = $_POST[PBSpeed];
	$mood_full = $_POST[PBMood];
	$experimental_full = $_POST[PBExperimental];
	$rhythm_low = (substr($rhythm_full,0,1));
	$rhythm_high = (substr($rhythm_full,2,2));
	$speed_low = (substr($speed_full,0,1));
	$speed_high = (substr($speed_full,2,2));
	$mood_low = (substr($mood_full,0,1));
	$mood_high = (substr($mood_full,2,2));
	$experimental_low = (substr($experimental_full,0,1));
	$experimental_high = (substr($experimental_full,2,2));
?>

<?php
	// 2. Build the MYSQL Query to search the Tracks table based on the form sliders;
  // until pagination/scrollination is built in, limit to 25 results

	$query  = "SELECT * ";
	$query .= "FROM Tracks ";
	$query .= "WHERE SoundCloudID > 1 ";
	$query .= "AND PBRhythm BETWEEN $rhythm_low AND $rhythm_high ";
	$query .= "AND PBSpeed BETWEEN $speed_low AND $speed_high ";
	$query .= "AND PBMood BETWEEN $mood_low AND $mood_high ";
	$query .= "AND PBExperimental BETWEEN $experimental_low AND $experimental_high ";
	$query .= "ORDER BY Rate DESC, DateReleased DESC ";
	$query .= "LIMIT 25";

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
		// within the while loop, draw out the soundcloud iframe embeds
		echo "<iframe width=\"100%\" height=\"166\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/" . $subject["SoundCloudId"] . "&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true\"></iframe>";
		?>


		<form action='track_info2.php' target="results-iframe" method=POST>
		  <input type="hidden" name="TrackTitle" value="<?php echo $subject["Title"]; ?>">

				<?php
				echo "<input type='submit' Value=\"More Infoz\" class=\"catalog-button\"/>";
				?>

		</form>

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

<script type='text/javascript'>

    var next_widget ;
    var iframes =[];
    var its_the_last = false;

    var current_page = document.querySelector('.current').innerHTML;
    var next_page_num = parseInt(current_page,10) + 1 ;
    var next_page_url = '/page/'+next_page_num+'/';




    //var widget = SC.Widget(iframe);



    function loadNextPage(url){
      window.location.href = url;
    }

    function fetchNextPage(){


    }

    $( document ).ready(function() {
      console.log( "ready!" );
      //////////////////////////////////////////////////////////////////////////

          (function() {
    iframes = document.querySelectorAll('iframe');

    for (var i = 0; i < iframes.length; i++) {

        window['widget_'+i] = SC.Widget(iframes[i]);
        var widget = SC.Widget(iframes[i]);
        widget.bind(SC.Widget.Events.PLAY, function(eventData) {
         var widget_i = this;
         for (var i = 0; i < iframes.length; i++) {
           if(SC.Widget(iframes[i]) === widget_i){
            if (i+1 >= iframes.length) {
              its_the_last = true;
            }else{
              next_widget = SC.Widget(iframes[i+1]);
            }
           }else{
            console.log('errooorooroor');
           }
         };
        });

        widget.bind(SC.Widget.Events.FINISH, function(eventData) {
          if (its_the_last == false) {
            next_widget.play();
          }else{
            loadNextPage(next_page_url);
          }

        });


    };

    }());



      //////////////////////////////////////////////////////////////////////////



      if (current_page > 1) {
        var widget = SC.Widget(iframes[0]);
        widget.bind(SC.Widget.Events.READY, function(eventData) {
          widget.play();
        });

      }


    });

  </script>

</body>
