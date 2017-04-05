
<?php 
session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="ratingCookieScript.js"></script>
</head>

<body>
	<p> Rating Form Structure Test </p>
	<br>
	<br>
	<br>
	<form method= "post" action="rated.php" id="cookieRatingForm">
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
		<input name="date" type="date" id="date">
		<br>
		<input name="submit" type="submit">

	</form>

	<a href="chartTest.php">Charts</a>
</body>
<html>
