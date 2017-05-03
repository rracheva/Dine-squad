<?php
//rating stuff
//include ('dbconn.php');

//convert meals into numbers
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

if(isset($_POST['meal'])){
	$meal = $_POST['meal'];
	$ratedDay= $_POST['day'];


//get date and day of th week
date_default_timezone_set("America/Los_Angeles");
$date = date("Y/m/d",time());
$Currentdayofweek = date('w', strtotime($date));

$difference = $Currentdayofweek - $ratedDay;

$canRate = false;
$cookieExpiration = 0;

//figuring out if day is eligible 
// eligible if within the last two days
if($difference>=0 && $difference<3){

	$cookieExpiration = 7 - $difference;
	$canRate = true;

} 
elseif($Currentdayofweek < 2 && abs($difference) > 4){

	$cookieExpiration =  7-(7-abs($difference));
	$canRate = true;
}
else{
	$canRate = false;
}

//setting unique cookie number for each meail
$mealDay = $ratedDay*3 + getMealNum($meal);
$testingCookie = (string)$mealDay;
// if cookie is not set and can rate the day create cookie and insertrating
if(!isset($_COOKIE[((string)$mealDay)]) && $canRate){
	//setcookie('$mealDay','val', time() + (86400)*$cookieExpiration, "/");
	setcookie($testingCookie, "test", time()+((86400)*$cookieExpiration));
	

	$conn = connect_to_db('DINE');
	$diningHall =$_POST['Hall'];
	$rating = $_POST['rating'];
	$addRatingQuery = "INSERT INTO Ratings VALUES (NULL, '$diningHall', '$rating', '$meal', '$date')";
	$resultRating = $conn->query($addRatingQuery);
	
	if(!$resultRating)die("Data failed".$conn->error);
}

}
?>