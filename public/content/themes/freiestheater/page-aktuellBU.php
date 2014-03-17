<?php
   // echo($wp_query->query['monat']);


/*echo '<pre>';
var_dump($wp_query);
echo '</pre>';*/

/**
 * @var wpdb $wpdb
 *
 */


$rows = $wpdb->get_results($wpdb->prepare(
    "
    SELECT * FROM $wpdb->posts inner join $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id
    WHERE $wpdb->posts.post_type = %s
    AND $wpdb->postmeta.meta_key LIKE %s
    AND $wpdb->postmeta.meta_value >= %s
    ORDER BY $wpdb->postmeta.meta_value ASC
    ",
    'produktion', //posttype
    'events_%_event', // meta_name: $ParentName_$RowNumber_$ChildName
    strtotime("now") // meta_value: 'type_3' for example


));

/*
echo '<pre>';
var_dump($rows);f
echo '</pre>';
*/

// query all posts with post-type production
foreach ($rows as $row) {
    echo ('<h3>Title: '.$row->post_title.' ---- ' . $row->post_type . '</h3>');
    echo ('<h3>PostID: '.$row->ID.'</h3>');
    echo ('<h3>metaValue: '.$row->meta_value.'</h3>');


    echo ('<h3>metaValue: '.date('y-m-d H:i', $row->meta_value).'</h3>');

    echo("<p>".$row->post_content . "</p>");
/*
    echo '<pre>';
    var_dump($row);
    echo '</pre>';*/

}




 wp_reset_query();  // Restore global post data stomped by the_post().