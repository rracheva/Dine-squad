<?php
//rating stuff
include ('dbconn.php');


 function getMealNum($value){

	if($value==="breakfast"){
		return 1;
	} else if ( $value==="lunch"){
		return 2;
	} else {
		return 3;
	}
	# code...
}
// echo $_POST['Hall'];
// echo $_POST['rating'];
$meal = $_POST['meal'];





$ratedDay= $_POST['day'];
echo "rated day ". $ratedDay;
echo "<br>"; 
//echo " current date" . $date;

//$Currentdayofweek = date('w', strtotime($date));

//echo $Currentdayofweek;

// setting cookies
// so first we get the date
$date = date("Y/m/d",time());
$Currentdayofweek = date('w', strtotime($date));
echo "current day of the week ".$Currentdayofweek; 
$difference = $Currentdayofweek - $ratedDay;
echo "<br>";
echo "<br>";
echo "testing can rate  ";
$canRate = false;
$cookieExpiration = 0;

if($difference>=0 && $difference<3){
	echo "positive differences";
	$cookieExpiration = 7 - $difference;
	echo $difference;
} 
elseif($Currentdayofweek < 2 && abs($difference) > 4){
	echo "true";
	//difference = 5 or 6
	$cookieExpiration =  7-(7-abs($difference));
}

echo "<br>";
echo "experiation of cookie ". $cookieExpiration;

$canRate = false;
//echo $difference;
	//get the date of the rated day
	//if currentDayoftheWeek is > then rated day
	//then you will subtract the difference in days
	//otherwise you add the difference in days




//echo $date;
// probably only allow rating if difference current day - rated day is 3
$conn = connect_to_db('testRatings');
$diningHall =$_POST['Hall'];
$rating = $_POST['rating'];
$addRatingQuery = "INSERT INTO Ratings VALUES (NULL, '$diningHall', '$rating', '$meal', '$date')";
$resultRating = $conn->query($addRatingQuery);

//set cookie for day and meal rated
//to make the cookie name mutiply day rating 1 mon 7 sun
// day -1 * meal (1,2,3)
//echo "<br>";
//echo "<br>";
//echo getMealNum($meal);

$mealDay = $ratedDay*3 + getMealNum($meal);

//echo "<br>";
//echo "<br>";

//echo $mealDay;
if(!$resultRating)die("Data failed".$conn->error);

// if(!isset($_COOKIE['$mealDay'])){
// 	setcookie('$mealDay','val', time() + (86400)*$cookieExpiration, "/");
// 	echo "cookie set";
// }
// else{
// 	echo "cookie is set";
// }
?>