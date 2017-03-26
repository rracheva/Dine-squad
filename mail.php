<?php

//conect to DB if havent done so
//should have table with emails and preferences((assume one preference to start with)

//get preference and check if it is met in any of the dining halls
// This would be some sort of helper function that "searches" 
// through all the dining halls and also gives a rating/count of occurances --> tell user of highest ranked dining hall
// email that user if preference/s is/are met

// Multiple recipients
// just a string seperated by commas
$to = 'rar32013@gmail.com, rar32013@pomona.edu'; // note the comma

// Subject
$subject = 'Birthday Reminders for August';

// Message
$message = '
<html>
<head>
  <title>Birthday Reminders for August</title>
</head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
  <table>
    <tr>
      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Mail it
// works on macs not on windows
mail($to, $subject, $message, implode("\r\n", $headers));
?>