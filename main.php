<?php
//include CSS Style Sheet
echo "<link rel='stylesheet' type='text/css' href='main.css' />";



$tmp=exec("/c/python27/python ascp_menu.py",$out);

var_dump($out);



$dininghall= "Frary";
// $meal= "Lunch";

// pass in arrays from query
$arr=array('xx1','tacos','fish', 'socks');
$arr2=array('xx2','tacos','fish', 'socks');
$arr3=array('xx3','tacos','fish', 'socks');

// prints array
// var_dump($arr);

//prints menu
echo '<table id="display">
<tr>
	 <th>DiningHall</th>
	 <th>Bfast</th>
	 <th>Lunch</th>
	 <th>Din</th>
</tr>';

echo '<td>'.$dininghall. '</td>';
// bfast
echo '<td> ';
foreach ($arr as $val){
	echo '<li>' . $val . '</li>';
}
echo "</td>";
// lunch
echo '<td> ';
foreach ($arr2 as $val){
	echo '<li>' . $val . '</li>';
}
echo "</td>";
// dinner
echo '<td> ';
foreach ($arr3 as $val){
	echo '<li>' . $val . '</li>';
}
echo "</td>";
echo '</table>';

?>