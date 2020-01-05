<?php

$db = new mysqli(
  "localhost",
  "wordpress_dbuser",
  "pw_redacted",
  "patternbased_db"
);

$query  = "SELECT `Title`, `SoundCloudID` ";
$query .= "FROM Tracks ";
$query .= "WHERE SoundCloudID > 1 ";
$query .= "AND Rhythm BETWEEN ? AND ? ";
$query .= "AND Speed BETWEEN ? AND ? ";
$query .= "AND Light BETWEEN ? AND ? ";
$query .= "AND Com BETWEEN ? AND ? ";
$query .= "ORDER BY Rate DESC, BPMF ASC";


$stmt = $db->prepare($query);
$stmt->bind_param('iiiiiiii',
  $_GET['s1l'], $_GET['s1r'],
  $_GET['s2l'], $_GET['s2r'],
  $_GET['s3l'], $_GET['s3r'],
  $_GET['s4l'], $_GET['s4r']
);

$stmt->execute();
$arr = array();

$stmt->bind_result($a, $b);

while($stmt->fetch())
{
  $arr[] = array($a,$b);
}

header('Content-Type: application/json');
echo(json_encode($arr));

$stmt->close();
