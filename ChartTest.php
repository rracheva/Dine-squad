<?php
session_start(); 
include ('dbconn.php');
$conn = connect_to_db('testRatings');

$getRatingsQuery;
if(isset($_POST['timeSpan'])){
  $mealRating = $_POST['meal'];
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
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      var scoresJ = <?php echo json_encode($scores)?>;
      console.log( (new Date ())/1000);

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
        for(var key in scoresJ){
          var rating = parseFloat(scoresJ[key]);
          data.addRows([[key,rating]]);
        }
        

        // Set chart options
        var options = {'title':'Dining Hall Ratings',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <form id="selectRatingsForm" method="post">
      <select name="timeSpan">
        <option name="day">Current Day</option>
        <option name="week">week</option>
        <option name="overall">overall</option>
      </select>

      <select name ="meal">
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
</html>