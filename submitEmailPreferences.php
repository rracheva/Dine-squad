<?php
// get the email from the submitted form
$email=$_POST["email"];

// validate the email
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
	include('dbconn.php');
	$conn= connect_to_db('Dine');

	// check if it already exists
	$check= "Select * FROM EmailInfo WHERE email = '$_POST[email]'";
	$result= perform_query($conn,$check);
	$num_rows=mysqli_num_rows($result);


	//get cuisine id
	$CuisineID="Select cid from Cuisine WHERE type = '$_POST[CuisinePreference]'";
	$query=perform_query($conn,$CuisineID);
	$row= $query->fetch_assoc();
	$getCuisineID= $row["cid"];

	// if email does not exist in db already
	if($num_rows==0){
		// insert new email
		$insertEmail= "INSERT INTO EmailInfo (email) VALUES ('$_POST[email]')";
		perform_query($conn,$insertEmail);

		// get its id
		$EmailId= "Select emailid FROM EmailInfo WHERE email = '$_POST[email]'";
		$queryE=perform_query($conn,$EmailId);
		$rowE= $queryE->fetch_assoc();
		$getEmailId=$rowE["emailid"];


		// insert cid and emailid intp preference
		$insertPreference= "INSERT INTO Preferences(emailid, cid) VALUES ('$getEmailId','$getCuisineID')";
		perform_query($conn,$insertPreference);

		echo '<p align="center">Thank you for submitting your preference!</p> <p align="center">You will now be redirected back to the main page.</p>';

		header( "refresh:2; url=main.php" ); //wait for 5 seconds before redirecting


		



	}
	else { //email already exists, update preference

		$EmailId= "Select emailid FROM EmailInfo WHERE email = '$_POST[email]'";
		$queryE=perform_query($conn,$EmailId);
		$rowE= $queryE->fetch_assoc();
		$getEmailId=$rowE["emailid"];


		$update= "UPDATE Preferences SET cid= '$getCuisineID' WHERE emailid = '$getEmailId' ";
		perform_query($conn,$update);
		
		echo '<p align="center">Thank you for updating your preference!</p><p align="center"> You will now be redirected back to the main page.</p>';

		header( "refresh:2; url=main.php" ); //wait for 5 seconds before redirecting

	}



}

else {
	Echo "Invalid email!";
}
?>