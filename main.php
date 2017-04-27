<?php
//include CSS Style Sheet
echo "<link rel='stylesheet' type='text/css' href='main.css' />";


//execute py script
$tmp=exec("python ascp_menu.py");
$real=substr($tmp, 1, -1);

//get menus
$menus=json_decode($real,true);

//all dininghalls except oldenborg
$names= array('frank','frary','cmc','mudd','scripps');

// oldenborg specific (only has lunch)
$dininghall= "Oldenborg";
$arr=$menus['oldenborg'][0];


//prints menu
echo '<table align="center" "border=1 rules=rows id="display">
<tr>
	 <th>DiningHall</th>
	 <th>Bfast</th>
	 <th>Lunch</th>
	 <th>Din</th>
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