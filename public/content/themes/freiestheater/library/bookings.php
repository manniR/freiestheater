<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 02.05.14
 * Time: 16:03
 */


/**
 * create database tables for booking
 */

function add_dbTables () {

		global $wpdb;

		$table_name = $wpdb->prefix . "bookings";

		$sql = "CREATE TABLE IF NOT EXISTS " .$table_name . " (
        booking_id MEDIUMINT NOT NULL AUTO_INCREMENT,
        post_id MEDIUMINT NULL,
        meta_id MEDIUMINT NULL,
        meta_value TIMESTAMP NULL,
        production_title VARCHAR(100) NULL,
        tickets_count MEDIUMINT NULL,
        name VARCHAR(60) NULL,
        email VARCHAR(50) NULL,
        created TIMESTAMP DEFAULT NOW(),
        PRIMARY KEY (booking_id)
        )";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

}

//calling the function
register_activation_hook(__FILE__,'add_dbTables');

add_action('after_setup_theme','add_dbTables');



/**
 * handling angular form submission
 */

function test_ajax(){
		header("Content-Type: application/json");
		$posts_array = get_posts();

		echo json_encode($posts_array);
		die();
}

add_action('wp_ajax_nopriv_test_ajax', 'test_ajax');
add_action('wp_ajax_test_ajax', 'test_ajax');

function process_booking() {


		header("Content-Type: application/json");


//		TODO process Booking

		global $wpdb;
		$table_name = $wpdb->prefix . "bookings";
		/*
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$email = $_POST['email'];
				$address = $_POST['address'];

				if($wpdb->insert('customers',array(
								'name'=>$name,
								'email'=>$email,
								'address'=>$address,
								'phone'=>$phone
						))===FALSE){

						echo "Error";

				}
				else {
						echo "Customer '".$name. "' successfully added, row ID is ".$wpdb->insert_id;

				}
				die();*/


//		$response = array('email' => $_POST, 'password'=> $_POST['password']);

		/*foreach ( $_REQUEST as $key => $value) {
						echo $key . '::' . $value . '<br>';
 		}

		$data = array(
				'email'=>$_REQUEST['email'],
				'password'=>$_REQUEST['password'],
		);

		echo $_SERVER['REQUEST_METHOD'];
*/

		$postdata = file_get_contents('php://input');
		$request = json_decode($postdata);

		if($wpdb->insert($table_name ,array(
						'name'=>$request->password,
						'email'=>$request->email
				))===FALSE){

				echo "Error";

		}
		else {

				echo "Customer '".$request->password. "' successfully added, row ID is ".$wpdb->insert_id;
				add_filter( 'wp_mail_content_type', 'set_html_content_type' );
				$headers = 'From: FREIES THEATER INNSBRUCK <myname@example.com>' . "\r\n";
				$to = 'manfred.raggl@chello.at';
				$subject = 'karten-reservierung';
				$message = '<p><bold>karten</bold> fuer die <em>vorstellung</em> wurden reserviert!</p>';

				if (wp_mail($to, $subject,$message , $headers, $attachments=NULL )){

						// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578

						echo "email send";

				}
				remove_filter( 'wp_mail_content_type', 'set_html_content_type' );





		}
/*

		echo 'email:: '.$request->email;
		echo 'password:: '.$request->password;*/
		die();

}
add_action('wp_ajax_nopriv_process_booking', 'process_booking');
add_action('wp_ajax_process_booking', 'process_booking');

function set_html_content_type() {

		return 'text/html';
}
