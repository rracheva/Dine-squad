<?php 
session_start(); 
include ('dbconn.php');
$conn = connect_to_db('DINE');
include('rated.php');


$getRatingsQuery="SELECT hall, AVG(rating) as rating  FROM Ratings GROUP BY hall";;
if(isset($_POST['timeSpan'])){
  $mealRating = $_POST['mealView'];
  if($_POST['timeSpan']=="week"){
    $getRatingsQuery = "SELECT hall, AVG (rating) as rating FROM Ratings WHERE timeDate >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND timedate < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND meal = '$mealRating' GROUP BY hall";
  }
  elseif($_POST['timeSpan']=="Current Day"){
    $getRatingsQuery = "SELECT hall, AVG(rating) as rating FROM Ratings Where DAYOFWEEK(timedate) = DAYOFWEEK(curdate()) AND meal = '$mealRating' GROUP BY hall";
  }
  else {
    $getRatingsQuery= "SELECT hall, AVG(rating) as rating  FROM Ratings WHERE meal = '$mealRating' GROUP BY hall";
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
  $scores[$row['hall']]=($row['rating']);
  $num++;
  $row = mysqli_fetch_assoc($getRatingsResult);
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="ratingValidate.js"></script>

	<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      var scoresJ = <?php echo json_encode($scores)?>;
      console.log( (new Date ())/1000);
      var colorsArray = ['red', 'blue', 'purple','maroon','orange','green'];
      var currentColor = 0;

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();

        data.addColumn('string', 'Dining Hall');
        data.addColumn('number', 'Rating');
        // data.addColumn({role:'style'});
        for(var key in scoresJ){
          var rating = parseFloat(scoresJ[key]);
          data.addRows([[key,rating]]);
        }
        

        // Set chart options
        var options = {
        				'width':400,
                      	'height':300,

        				chart:{
        					'title':'Dining Hall Ratings',
                      		 },
                      	axes: {
                      		y: {
                      			all: {
                      				range: {
                      					max: 5,
                      					min: 0
                      				}
                      			}
                      		}
                      	}
                   };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
</head>

<body>
	<p> Rating Form Structure Test </p>
	<br>
	<br>
	<br>
	<form id="selectRatingsForm" method="post">
      <select name="timeSpan">
        <option name="day">Current Day</option>
        <option name="week">week</option>
        <option name="overall">overall</option>
      </select>

      <select name ="mealView">
        <option name="breakfast">breakfast</option>
        <option name="lunch">lunch</option>
        <option name="dinner">dinner</option>
      </select>
      <input type="submit" name="submit">
    </form>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
    <div id="testing"></div>
  </body>





	<form id="ratingForm" method= "post" id="cookieRatingForm">
		<select name="Hall">
			<option value ="Scripps"> Scripps </option>
			<option value ="Mudd"> Mudd </option>
			<option value ="Pitzer"> Pitzer </option>
			<option value ="Frary"> Frary </option>
			<option value ="Frank"> Frank </option>
			<option value ="CMC"> CMC </option>
		</select>
		<select name=rating>
			<<option value="1">1 </option>
			<option value="2"> 2 </option>
			<option value="3"> 3 </option>
			<option value="4"> 4 </option>
			<option value="5"> 5 </option>
		</select>
		<br>
		<select name= "meal" id="mealSelect">
			<option value = "breakfast"> Breakfast </option>
			<option value = "lunch"> Lunch </option>
			<option value = "dinner">Dinner</option>
		</select>
		<select id="day" name = "day">
			<option value="1"> Monday </option>
			<option value="2"> Tuesday </option>
			<option value="3"> Wednesday </option>
			<option value="4"> Thursday </option>
			<option value="5"> Friday </option>
			<option value ="6"> Saturday </option>
			<option value ="0"> Sunday </option>
			</select>
		<br>
		<input name="submit" type="submit">

	</form>

	<a href="chartTest.php">Charts</a>
</body>
<html>
