<?php



function getBookings_ajax(){

		header("Content-Type: application/json");

/*		$postdata = file_get_contents('php://input');
		$request = json_decode($postdata);*/


//		echo json_encode(array('data'=>$_GET['date']));
//		echo json_encode(array('message'=>'Hello from the Server'));
		$postdata = file_get_contents('php://input');
		//echo $postdata;
		echo '<pre>';
		var_dump($_SERVER);
		echo '</pre>';;
		die();
}


add_action('wp_ajax_getBookings_ajax','getBookings_ajax');


