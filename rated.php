<?php
//rating stuff
include ('dbconn.php');

echo $_POST['Hall'];
echo $_POST['rating'];
echo $_POST['date'];
$meal = $_POST['meal'];
$date = date_create($_POST['date']);
$date = date_format($date,"Y/m/d");
$ratedDay= $_POST['day'];
echo "rated day ". $ratedDay;
//echo <br>; 
$Currentdayofweek = date('w', strtotime($date));
//$result    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date)));
echo "<br>";
echo $Currentdayofweek;
//echo $date;
$conn = connect_to_db('testRatings');
$diningHall =$_POST['Hall'];
$rating = $_POST['rating'];
$addRatingQuery = "INSERT INTO Ratings VALUES (NULL, '$diningHall', '$rating', '$meal', '$date')";
$resultRating = $conn->query($addRatingQuery);
if(!$resultRating)die("Data failed".$conn->error);
?>