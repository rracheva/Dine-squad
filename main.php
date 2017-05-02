<?php 
	// include('getMax.php');
	// if(isset($_POST['mealOption']) && isset($_POST['prefSel'])){
	// 	echo "heyyyyyyyyyyyyyyyyyyyyyyyyyy";
	// 	$hall=getMax($_POST['mealOption'], $_POST['prefSel']);
	// 	//$response="You should get '$_POST['prefSel]' at $hall for '$POST[$mealOption]"; 
	// 	$response = $hall;
	// }

?>

<!DOCTYPE html>
<html>
<body>

	<div style= "width :1200;">
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

				while ($row=$result->fetch_assoc()){
					echo "<option value = '". $row["type"]. "'>".$row["type"]."</option>";
				}

				echo '</select></p>';
				?>
				



				<input type ='submit' value= 'Subscribe!'>
			</form>

		</div>
		<div style= "float: left;width:400px;">
			<p align= "center">
				<form method='POST'>
					<p>MEAL: 
						<select name="mealOption">
							<option>breakfast</option>
							<option>lunch</option>
							<option>dinner</option>

						</select>
					</p>
					<?php
						include('getMax.php');

						// include('dbconn.php');
						// $conn= connect_to_db('Dine');
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
							echo "<p align='center'> You should go to '$hall' </p>";
						}

			
					?>
			


		</div>
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
$real=substr($tmp, 1, -1);

$time=time();
//get menus
$day= date("D", mktime(0,0,0,date("n", $time),date("j",$time)- 1 ,date("Y", $time)));


$menus=json_decode($real,true);
$names= array('frank','frary','cmc','mudd','scripps','pitzer');


if($day==='Sat' || $day==='Sun'){

	echo '<table align="center" "border=1 rules=rows id="display">
<tr>
	 <th>DiningHall</th>
	 <th>Brunch</th>
	 <th>Dinner</th>
</tr>';

}

else{
//all dininghalls except oldenborg

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

