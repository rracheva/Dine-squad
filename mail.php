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
$string_break = file_get_contents("/data.json");
$json_break_ranking = json_decode($string_break, true);
$string_lunch = file_get_contents("/data.json");
$json_lunch_ranking = json_decode($string_lunch, true);
$string_dinner = file_get_contents("/data.json");
$json_dinner_ranking = json_decode($string_dinner, true);
// connect to db
include ('dbconn.php');
$conn = connect_to_db('DINE');
$query ="SELECT EmailInfo.email,Cuisine.type 
          FROM EmailInfo, Preferences, Cuisine 
          WHERE Preferences.cid = Cuisine.cid 
          AND EmailInfo.emailid = Preferences.emailid";
$result = perform_query($conn,$query);  


 
$array_email_preference_outcome = array();

while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
  $email = $row['email'];
  $preference = $row['preferences'];
  $array_preference = meal_dininghall($preference);
  $array_email_preference_outcome[$email] = $array_preference;
}


function meal_dininghall($preference){
  $preferences_dininghall_meal = array();
  foreach ($json_break_ranking as $key => $value) {
    if (strcmp($key, $preference) == 0){
      $preferences_dininghall_meal['breakfast'] = key($value[0]);
    }
  }
  foreach ($json_lunch_ranking as $key => $value) {
    if (strcmp($key, $preference) == 0){
      $preferences_dininghall_meal['lunch'] = key($value[0]);
    }
  }
  foreach ($json_dinner_ranking as $key => $value) {
    if (strcmp($key, $preference) == 0){
      $preferences_dininghall_meal['dinner'] = key($value[0]);
    }
  }
  return $preferences_dininghall_meal;
}

//$to = 'rar32013@gmail.com, rar32013@pomona.edu, ralitsa.racheva@pomona.edu'; // note the comma

// Subject
$subject = 'Claremont dining hall preferences';




// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';



while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
  $to = $row['email'];
  $message = '



  <html>
  <head>
    <title>Suggestion where you should go</title>
  </head>
  <body>
    
    <table>
      <tr>
        <th>For breakfast go to' .$array_email_preference_outcome[$email]['breakfast'].'</th>
      </tr>
      <tr>
        <td>For lunch go to' .$array_email_preference_outcome[$email]['lunch'].'</th>
      </tr>
      <tr>
        <td>For dinner go to' .$array_email_preference_outcome[$email]['dinner'].'</th>
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