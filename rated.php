<?php
//rating stuff
//include ('dbconn.php');


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
if(isset($_POST['meal'])){
	$meal = $_POST['meal'];
	$ratedDay= $_POST['day'];


//echo "rated day ". $ratedDay;
//echo "<br>"; 
//echo " current date" . $date;

//$Currentdayofweek = date('w', strtotime($date));

//echo $Currentdayofweek;

// setting cookies
// so first we get the date
date_default_timezone_set("America/Los_Angeles");
$date = date("Y/m/d",time());
$Currentdayofweek = date('w', strtotime($date));
///echo "current day of the week ".$Currentdayofweek; 
$difference = $Currentdayofweek - $ratedDay;
// echo "<br>";
// echo "<br>";
// echo "testing can rate  ";
$canRate = false;
$cookieExpiration = 0;

if($difference>=0 && $difference<3){
	//echo "positive differences";
	$cookieExpiration = 7 - $difference;
	$canRate = true;
	//echo $difference;
} 
elseif($Currentdayofweek < 2 && abs($difference) > 4){
	//echo "true";
	//difference = 5 or 6
	$cookieExpiration =  7-(7-abs($difference));
	$canRate = true;
}
else{
	$canRate = false;
}

$mealDay = $ratedDay*3 + getMealNum($meal);
$testingCookie = (string)$mealDay;
// 
if(!isset($_COOKIE[((string)$mealDay)]) && $canRate){
	//setcookie('$mealDay','val', time() + (86400)*$cookieExpiration, "/");
	setcookie($testingCookie, "test", time()+((86400)*$cookieExpiration));
	
	print_r($_COOKIE);
	$conn = connect_to_db('DINE');
	$diningHall =$_POST['Hall'];
	$rating = $_POST['rating'];
	$addRatingQuery = "INSERT INTO Ratings VALUES (NULL, '$diningHall', '$rating', '$meal', '$date')";
	$resultRating = $conn->query($addRatingQuery);
	
	if(!$resultRating)die("Data failed".$conn->error);
}
else{
	 echo "cookie is set and day not rated";
	 print_r($_COOKIE);

 }
}
?>