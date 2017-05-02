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
// connect to db
include ('dbconn.php');
$conn = connect_to_db('Dine');
$query ="SELECT EmailInfo.email,Cuisine.type 
          FROM EmailInfo, Preferences, Cuisine 
          WHERE Preferences.cid = Cuisine.cid 
          AND EmailInfo.emailid = Preferences.emailid";
$result = perform_query($conn,$query);  


 
$array_email_preference_outcome = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $email = $row['email'];
  $preference = $row['type'];
  $array_preference = meal_dininghall($preference);
  $array_email_preference_outcome[$email] = $array_preference;
}


function max_key($array_value){
  $max_val = 0;
  $max_key = 'Frank';
  foreach ($array_value as $key => $value){
    if ($value > $max_val){
      $max_val = $value;
      $max_key = $key;
    }
  }
  return $max_key;
}
function meal_dininghall($preference){
  $preferences_dininghall_meal = array();
  foreach ($json_break_ranking as $key => $value) {
    if (strcmp($key, $preference) == 0){
      $preferences_dininghall_meal['breakfast'] = max_key($value);
    }
  }
  foreach ($json_lunch_ranking as $key => $value) {
    if (strcmp($key, $preference) == 0){
      $preferences_dininghall_meal['lunch'] = max_key($value);
    }
  }
  foreach ($json_dinner_ranking as $key => $value) {
    if (strcmp($key, $preference) == 0){
      $preferences_dininghall_meal['dinner'] = max_key($value);
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



while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
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