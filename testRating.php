
<?php 
session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="ratingValidate.js"></script>
</head>

<body>
	<p> Rating Form Structure Test </p>
	<br>
	<br>
	<br>
	<form id="ratingForm" method= "post" action="rated.php" id="cookieRatingForm">
		<select name="Hall">
			<option value ="Scripps"> Scripps </option>
			<option value ="Mudd"> Mudd </option>
			<option value ="Pitzer"> Pitzer </option>
			<option value ="Frary"> Frary </option>
			<option value ="Frank"> Frank </option>
			<option value ="CMC"> CMC </option>
		</select>
		<input name="rating" value="rating">
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
			<option value = "6"> Saturday </option>
			<option value = "0"> Sunday </option>
			</select>
		<br>
		<input name="submit" type="submit">

	</form>

	<a href="chartTest.php">Charts</a>
</body>
<html>
