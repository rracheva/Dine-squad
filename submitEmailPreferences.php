<?php
	include('dbconn.php');
	$conn= connect_to_db('Dine');


	$check= "Select * FROM EmailInfo WHERE email = '$_POST[email]'";
	$result= perform_query($conn,$check);
	$num_rows=mysqli_num_rows($result);


	//get cuisine id
	$CuisineID="Select cid from Cuisine WHERE type = '$_POST[CuisinePreference]'";
	$query=perform_query($conn,$CuisineID);
	$row= $query->fetch_assoc();
	$getCuisineID= $row["cid"];


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


		



	}
	else { //email already exists, update preference

		$EmailId= "Select emailid FROM EmailInfo WHERE email = '$_POST[email]'";
		$queryE=perform_query($conn,$EmailId);
		$rowE= $queryE->fetch_assoc();
		$getEmailId=$rowE["emailid"];


		$update= "UPDATE Preferences SET cid= '$getCuisineID' WHERE emailid = '$getEmailId' ";
		perform_query($conn,$update);
		
	}


	echo "Thank you for submitting your preference!";
?>