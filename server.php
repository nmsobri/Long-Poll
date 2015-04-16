<?php

session_start();

/*Init $_SESSION['count'] when it does not exist*/
if (!isset($_SESSION['count'])) {
	$_SESSION['count'] = 0;
	$init = true;
}

$db = new PDO("mysql:host=localhost;dbname=longpoll;charset=utf8", 'root', 'root');

function getData($db) {
   $stmt = $db->query("SELECT * FROM poll");
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

while(true) {
	$results = getData($db);	
	
	if ( count($results) == $_SESSION['count'] ) {
		sleep(3); //long poll, wait if there is no new message
	}
	else {
		$_SESSION['count'] = count($results);
		$offset = isset($init) ? 0 : $_SESSION['count'] -1;
		echo json_encode( array_slice($results,$offset));
		return;
	}
}

