<!DOCTYPE html>
<html>
<body>
	<h1 align="center">Dine in Claremont</h1>

	<div style= "width :1200;">
		<!-- the subscribe functionality -->
		<div style= "float: left;width: 400px;">
			<p align ="center">enter email and choose/update preference to get emails of when the dining halls serve your favorite food! </p>
			<form action='submitEmailPreferences.php' method='POST'>
				<p>Email: <input type='Email' name='email' id ="email"></p>
				
				<?php
				include('dbconn.php');
				$conn= connect_to_db('Dine');
				$query= 'SELECT type from Cuisine';

				$result= perform_query($conn,$query);

				echo '<p> Preference: <select name="CuisinePreference">';
				// populate the suisine options from the db
				while ($row=$result->fetch_assoc()){
					echo "<option value = '". $row["type"]. "'>".$row["type"]."</option>";
				}

				echo '</select></p>';
				?>
				<input type ='submit' value= 'Subscribe!'>
			</form>

		</div>

		<!-- the core functionality displaying to users where they should eat
		based of their meal option and Cuisine type -->
		<div style= "float: left;width:400px;">
			<p align= "center">
				<p align="center"> Pick a meal and preference to see where you should dine today! </p>

				<form method='POST'>
					<p>Meal: 
						<select name="mealOption">
							<option>breakfast</option>
							<option>lunch</option>
							<option>dinner</option>

						</select>
					</p>
					<?php
						include('getMax.php');

						$query= 'SELECT type from Cuisine';

						$result= perform_query($conn,$query);


						echo '<p> Preference: <select name="prefSel">';

						while ($row=$result->fetch_assoc()){
							echo "<option value = '". $row["type"]. "'>".$row["type"]."</option>";
						}

						echo '</select></p>';
						echo "<input type ='submit' value= 'find!'></form";
						echo 	"</p>";


						if(isset($_POST['mealOption']) && isset($_POST['prefSel'])){
							$hall=getMax($_POST['mealOption'], $_POST['prefSel']);
							echo "<p align='center'> You should go to $hall </p>";
						}

			
					?>
			


		</div>
		<!-- link to ratings -->
		<div style= "float: left;width:400px;">
			<p align= "center"> If you want to rate your favorite meals, click <a href="testRating.php">Here</a></p>
		</div>
	<br style="clear: left;" />


</div>

</body>

</html>


<?php
//include CSS Style Sheet
echo "<link rel='stylesheet' type='text/css' href='main.css' />";


//execute py script
$tmp=exec("python ascp_menu.py");
// get rid of the extra quotes
$real=substr($tmp, 1, -1);
// get the current day
$time=time();
$day= date("D", mktime(0,0,0,date("n", $time),date("j",$time)- 1 ,date("Y", $time)));

// the menus and dininghalls (except oldenborg)
$menus=json_decode($real,true);
$names= array('frank','frary','cmc','mudd','scripps','pitzer');

// display correct menus depending on the days
if($day==='Sat' || $day==='Sun'){

	echo '<table align="center" "border=1 rules=rows id="display">
<tr>
	 <th>DiningHall</th>
	 <th>Brunch</th>
	 <th>Dinner</th>
</tr>';

}

else{

// oldenborg specific (only has lunch)
$dininghall= "Oldenborg";
$arr=$menus['oldenborg'][0];

//prints menu
echo '<table align="center" "border=1 rules=rows id="display">
<tr>
	 <th>DiningHall</th>
	 <th>BreakFast</th>
	 <th>Lunch</th>
	 <th>Dinner</th>
</tr>';

echo '<tr><td>'.$dininghall. '</td>';
// bfast
echo '<td> </td>';
// lunch
echo '<td> ';
foreach ($arr as $val){
	echo '<li>' . $val . '</li>';
}
echo "</td>";
// dinner
echo '<td> </td></tr>';

}

// fills in the menus in with the correct items
foreach ($names as $name) {
	echo '<tr>
			<td>'. $name. '</td>';
	foreach ($menus[$name] as $meals) {
			echo '<td>';
			foreach ($meals as $specificMeal) {
				echo '<li>'. $specificMeal. '</li>';	
			}
			echo '</td>';
	}
	
	echo '</tr>';


	
}
echo '</table>';


?>

