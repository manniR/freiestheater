/*
 QUERY EVENTS
*/
"
    SELECT
        p.ID as POST_ID,
        p.post_title as POST_TITLE,
        GROUP_CONCAT(e.meta_id,'=>',from_unixtime(e.meta_value)) as EVENTS
    FROM
         $wpdb->posts p,
         $wpdb->postmeta e
    WHERE
            p.post_type LIKE %s
         AND e.post_id = p.ID
         AND e.meta_key LIKE %s
         AND e.meta_value >= %s
    group by
        p.ID
    ORDER by
        e.meta_value ASC

    LIMIT
        0,4
    ",
  'produktion', //posttype
  'events_%_datum', // meta_name: $ParentName_$RowNumber_$ChildName
  strtotime("now") // meta_value: 'type_3' for example
//SET lc_time_names = 'de_DE';
/*

    SELECT * FROM $wpdb->posts inner join $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id
    WHERE $wpdb->posts.post_type = %s
    AND $wpdb->postmeta.meta_key LIKE %s
    AND $wpdb->postmeta.meta_value >= %s
    ORDER BY $wpdb->postmeta.meta_value ASC
*/




/*
 AUSGABE
*/

array(2) {
  [0]=>
  object(stdClass)#2616 (3) {
    ["POST_ID"]=>
    string(1) "6"
    ["POST_TITLE"]=>
    string(8) "Antigone"
    ["EVENTS"]=>
    string(74) "459=>2014-03-25 16:00:00,544=>2014-03-28 20:00:00,546=>2014-03-30 16:00:00"
  }
  [1]=>
  object(stdClass)#2615 (3) {
    ["POST_ID"]=>
    string(2) "91"
    ["POST_TITLE"]=>
    string(12) "Lawinentraum"
    ["EVENTS"]=>
    string(99) "579=>2014-03-29 01:00:00,581=>2014-03-25 01:00:00,583=>2014-03-30 01:00:00,585=>2014-04-01 02:00:00"
  }
}