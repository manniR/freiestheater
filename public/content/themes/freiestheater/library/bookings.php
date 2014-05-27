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
 * enqueue scripts
 */

if (!function_exists("angular_scripts")) {
		function angular_scripts()
		{
				//echo(get_stylesheet_directory_uri());
				wp_enqueue_script('angular','http://ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.min.js', array(), null, false);
				wp_enqueue_script('app',get_stylesheet_directory_uri() . '/angular/app.js', array('angular'), null, true);
//				wp_enqueue_script('controller',get_stylesheet_directory_uri() . '/angular/controller.js', array('angular'), null, true);
//				wp_enqueue_script('directives',get_stylesheet_directory_uri() . '/angular/directives.js', array('angular'), null, true);
//				wp_enqueue_script('services',get_stylesheet_directory_uri() . '/angular/services.js', array('angular'), null, true);

		}
}
add_action('wp_enqueue_scripts', 'angular_scripts');



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

		$postdata = file_get_contents('php://input');
		$request = json_decode($postdata);

		$update = update_free_seats(  $request->tickets_count,
																	$request->post_id,
																	$request->meta_key
																);

		//CHECK IF UPDATE WAS SUCCESSFULL
		if (array_key_exists('error', $update)){
				// ERROR -> return-value =  array('error'=>'zuwenig freie plätze','available' => $available);
		}else{
				//SUCCESS return-value array('available' => $balance, 'count' => $count);
				// SAVE BOOKING
				$saved_booking = ft_insert_booking($request);
				if($saved_booking!==FALSE){
						// SUCCESS -> SEND EMAIL
						ft_send_mail($request);
						return array('message'=>'email wurde verschickt');
						// TODO UPDATE VIEW
				}
				else {

						// ERROR
				}
		}
		die();
}

add_action('wp_ajax_nopriv_process_booking', 'process_booking');
add_action('wp_ajax_process_booking', 'process_booking');


// send mail
function ft_send_mail($request){

		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		$headers = 'From: FREIES THEATER INNSBRUCK <myname@example.com>' . "\r\n";
		$to = $request->email;
		$subject = 'Kartenreservierung FTI';
		$message = '<p>Vielen Dank für Ihre Reservierung, die wir hiermit bestätigen!<br>
										Bitte kontrollieren Sie den von Ihnen gewählten Termin und die Kartenanzahl:<br><br>

										<strong>'. $request->production_title .'</strong><br>
										Datum: '.$request->meta_value.'<br>
										Stückzahl: '.$request->tickets_count .	' <br>
										Name:'.$request->name.'<br>
										<br>
										<br>
										<br>
										Bei Rückfragen schreiben Sie uns bitte eine Mail an: info@freiestheater.at <br><br>
										<br>
										Wenn nicht anders angegeben liegen reservierte Karten bis längstens 15 Minuten vor Vorstellungsbeginn an der Abendkassa zur Abholung bereit.<br>
										- Bezahlung nur in bar möglich<br>
										- Freie Platzwahl<br>
										<br>
										Wir freuen uns auf Ihren Besuch!

										</p>';

		if (wp_mail($to, $subject,$message , $headers, $attachments=NULL )){

				// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578

				echo "email send";

		}
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

}

function set_html_content_type() {

		return 'text/html';
}



