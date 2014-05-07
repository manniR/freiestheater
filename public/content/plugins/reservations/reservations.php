<?php
/*
Plugin Name: Reservations
Version: 1.0
Plugin URI:
Description: email reservation db
Author: MR
Author URI:http://www.manfredraggl.com
*/



function add_dbTables () {

    global $wpdb;




   $table_name = $wpdb->prefix . "bookings";

    $sql = "CREATE TABLE IF NOT EXISTS". $table_name ."(
        booking_id bigint(11) NOT NULL AUTO_INCREMENT,
        created TIMESTAMP DEFAULT NOW(),
        post_id tinyint (1) NOT NULL DEFAULT '1',
        meta_id tinyint (1) NOT NULL DEFAULT '1',
        meta_value TIMESTAMP NULL,
        production_title VARCHAR(100) NOT NULL,
        production_type VARCHAR(30) NOT NULL,
        tickets_count tinyint (1) NOT NULL DEFAULT '1',
        name VARCHAR(30) NOT NULL,
        email VARCHAR(50) NULL,
        phone VARCHAR(50) NULL,
        comment text DEFAULT NULL,
        firstname tinytext NULL,
        lastname tinytext NULL
        )";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);


}

//calling the function
register_activation_hook(__FILE__,'add_dbTables');
