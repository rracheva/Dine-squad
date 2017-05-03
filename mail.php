<?php

//conect to DB if havent done so
//should have table with emails and preferences((assume one preference to start with)

//get preference and check if it is met in any of the dining halls
// This would be some sort of helper function that "searches" 
// through all the dining halls and also gives a rating/count of occurances --> tell user of highest ranked dining hall
// email that user if preference/s is/are met

// Multiple recipients
// just a string seperated by commas
// match email with preference

// get json ranking
// update with real path to json files
$string_break = file_get_contents('breakfastdata.json');
$json_break_ranking = json_decode($string_break, true);
$string_lunch = file_get_contents('lunchdata.json');
$json_lunch_ranking = json_decode($string_lunch, true);
$string_dinner = file_get_contents('dinnerdata.json');
$json_dinner_ranking = json_decode($string_dinner, true);
echo $json_dinner_ranking;
echo var_dump($json_lunch_ranking);
// connect to db
include ('dbconn.php');
include ('getMax.php');
$conn = connect_to_db('Dine');
$query ="SELECT EmailInfo.email,Cuisine.type 
          FROM EmailInfo, Preferences, Cuisine 
          WHERE Preferences.cid = Cuisine.cid 
          AND EmailInfo.emailid = Preferences.emailid";

$result = perform_query($conn,$query);  



$array_email_preference_outcome = array();


while ($row =$result->fetch_assoc()) {
  $email = $row['email'];
  
  $preference = $row['type'];



  $bfast=  getMax("breakfast",$preference);
  
  $lunch= getMax("lunch",$preference);
  $dinner= getMax("dinner",$preference);

  $array_preference = [$bfast,$lunch,$dinner];

  $array_email_preference_outcome[$email] = $array_preference;
}

// Subject
$subject = 'Claremont dining hall preferences';




// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

$resultTwo = perform_query($conn,$query);  

while ($row = mysqli_fetch_array($resultTwo, MYSQLI_ASSOC)) {
  echo "inside";
  $to = $row['email'];
  echo $to;
  $message = '



  <html>
  <head>
    <title>Suggestion where you should go</title>
  </head>
  <body>
    
    <table>
      <tr>
        <th>For breakfast go to ' .$array_email_preference_outcome[$to][0].'</th>
      </tr>
      <tr>
        <td>For lunch go to ' .$array_email_preference_outcome[$to][1].'</th>
      </tr>
      <tr>
        <td>For dinner go to ' .$array_email_preference_outcome[$to][2] .'</th>
      </tr>
    </table>
  </body>
  </html>
  ';
  // Mail it
  // works on macs not on windows

  mail($to, $subject, $message, implode("\r\n", $headers));
}
?>