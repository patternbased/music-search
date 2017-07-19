Print the array that the form generated and POSTed: <br>
<?php print_r($_POST); ?>

<br><br><br><br>

General Explode function using a variable set to the string "Hello world. It's a beautiful day."<br>
<?php
$str = "Hello world. It's a beautiful day.";
print_r (explode(" ",$str));
?>

<br><br><br><br>

Printing individual elements of an array<br>
<?php print_r($_POST[Rhythm]); ?>
<br>
<?php print_r($_POST[Speed]); ?>
<br>
<?php print_r($_POST[Light]); ?>
<br>
<?php print_r($_POST[Com]); ?>

<br><br><br><br>

Form Array Subtring Attempt<br>

<?php
$rhythm_full = $_POST[Rhythm];
?>
<br>
<?php
print_r ($rhythm_full);
$rhythm_low = (substr($rhythm_full,0,1));
print_r ($rhythm_low);
$rhythm_high = (substr($rhythm_full,2,1));
print_r ($rhythm_high);
?>

<br><br><br><br>

<?
echo 'Hello ' . htmlspecialchars($_POST[rhythm-low]) . '!';
?>

rhythm-low = <?php print_r ($_POST[rhythm-low]); ?> <br>
rhythm-high = <?php echo $_POST[rhythm-high]; ?> <br>

speed-low = <?php echo $_POST[speed-low]; ?> <br>
speed-high = <?php echo $_POST[speed-high]; ?> <br>

light-low = <? echo $_POST[light-low]; ?> <br>
light-high = <? echo $_POST[light-high]; ?> <br>

com-low = <? echo $_POST[rhythm-low]; ?> <br>
com-high = <? echo $_POST[rhythm-high]; ?> <br>
