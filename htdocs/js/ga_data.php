<?php

//////////////////////////////////////////////////
// CONFIGURATION PARAMETERS
//////////////////////////////////////////////////

// Where to cache the data
$cache_file = "/tmp/cache.json";
// For how long to keep the cache warm (in seconds)
$cache_time = 60;

// Which URL to cache under with JS variable
$cache_urls = array(
		'number_of_users_session_bounce_rate' => 'https://river-device-94414.appspot.com/query?id=ahRlfnJpdmVyLWRldmljZS05NDQxNHIVCxIIQXBpUXVlcnkYgICAgK-ckQoM',
		'number_of_users_per_country' => 'https://river-device-94414.appspot.com/query?id=ahRlfnJpdmVyLWRldmljZS05NDQxNHIVCxIIQXBpUXVlcnkYgICAgK-ckQsM&format=json',
		'percentage_male_female' => 'https://river-device-94414.appspot.com/query?id=ahRlfnJpdmVyLWRldmljZS05NDQxNHIVCxIIQXBpUXVlcnkYgICAgK-ckQkM',
		'top_10_countries_by_users' => 'https://river-device-94414.appspot.com/query?id=ahRlfnJpdmVyLWRldmljZS05NDQxNHIVCxIIQXBpUXVlcnkYgICAgKvvlgoM',
		'top_10_countries_by_female' => 'https://river-device-94414.appspot.com/query?id=ahRlfnJpdmVyLWRldmljZS05NDQxNHIVCxIIQXBpUXVlcnkYgICAgOu4jwkM'
	);

//////////////////////////////////////////////////

// Load cache
$cache = array( 'timestamp' => time() - $cache_time, 'buffer' => '' );
if (file_exists($cache_file)) 
	$cache = json_decode(file_get_contents($cache_file), true);

// Cache age
$age = time() - $cache['timestamp'];

// If the cache is still warm, return buffer
if ($age < $cache_time) {

	// Calculate how much cache time is left
	$offset = $cache_time - $age;
	header("Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT");
	header("Cache-Control: max-age=" . $offset . ", must-revalidate");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s", $cache['timestamp']) . " GMT");
	header("Content-Type: text/plain");
	// Send cache buffer and exit
	die($cache['buffer']);

}

// Download URLs and update cache buffer
$buffer = "";
foreach ($cache_urls as $var => $url) {

	// Prepare buffer
	$buffer .= "var " . $var . " = ";
	$buffer .= file_get_contents($url);
	$buffer .= ";\n";

}

// Update cache file
file_put_contents($cache_file, json_encode(array(
		'timestamp' => time(),
		'buffer' => $buffer
	)));

// Send current buffer
header("Expires: " . gmdate("D, d M Y H:i:s", (time() + $cache_time)) . " GMT");
header("Cache-Control: max-age=" . $cache_time . ", must-revalidate");
header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
header("Content-Type: text/plain");
die($buffer);


?>