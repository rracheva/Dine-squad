<?php

function getMax($meal, $cuisine) {
	// meal: string of meal of interest (e.g. "lunch")
	// cuisine: string of cuisine of interest (e.g. "italian")

	$str = file_get_contents($meal."data.json");
	$json = json_decode($str, true);

	$halls = ["frank", "frary", "oldenborg", "collins", "pitzer", "mudd", "scripps" ];
	$max=0; 
	$max_hall="frank";

	foreach ($halls as $hall) {

		if ($json[$cuisine][$hall] >= $max) {
			$max = $json[$cuisine][$hall];
			$max_hall = $hall;
		}

	}

	return $max_hall;
}

?> 