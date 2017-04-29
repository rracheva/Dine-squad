<?php 
session_start(); 
include ('dbconn.php');
$conn = connect_to_db('testRatings');
//first query
//SELECT * FROM Ratings WHERE timeDate >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND timedate < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY;
//SELECT hall, AVG (rating) as rating FROM Ratings WHERE timeDate >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND timedate < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY GROUP BY hall;
$getRatingsQuery = "SELECT hall, AVG(rating) as rating  FROM Ratings GROUP BY hall";
if(isset($_POST['timeSpan'])){
  echo $_POST['timeSpan'];
  if($_POST['timeSpan']=="week"){
    echo "we in week";
    $getRatingsQuery = "SELECT hall, AVG (rating) as rating FROM Ratings WHERE timeDate >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND timedate < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY GROUP BY hall";
  }
  elseif($_POST['timeSpan']=="Current Day"){
    echo "we in here";
    $getRatingsQuery = "SELECT hall, AVG(rating) as rating FROM Ratings Where DAYOFWEEK(timedate) = DAYOFWEEK(curdate()) GROUP BY hall";
  }
  else {
    echo "in else";
  }
}
 //cd /Applications/MAMP/Library/bin
 //./mysql --host=localhost -u root -proot
 //$getRatingQuery = "SELECT hall FROM DiningRatings";
$getRatingsResult = $conn->query($getRatingsQuery);
if(!$getRatingsResult)die("Data failed".$conn->error);

 $row = mysqli_fetch_assoc($getRatingsResult);
 $scores = array();
 $num = 0;
while(!empty($row)){
  echo $row ['hall']. " ". $row['rating'];
  $scores[$row['hall']]=($row['rating']);
  $num++;
  $row = mysqli_fetch_assoc($getRatingsResult);
}
?>