<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 02.04.14
 * Time: 18:19
 */


// DEUTSCH MONATSNAMEN !!!!
setlocale(LC_ALL, 'de_DE.utf-8');


/**
 * PROGRAMM - LISTING PRODUKTIONEN
 * AKTUELLES DATUM ZUERST
 *
 * @param int $limit
 * @return mixed
 */
function get_programm($limit=5 ){

		global $wpdb;
		$rows = $wpdb->get_results($wpdb->prepare(
				"
        SELECT
            p.*,
            CONCAT('[',
                GROUP_CONCAT('{\"meta_id\":','\"',e.meta_id,'\",'
                              ,'\"meta_key\":','\"',e.meta_key,'\",'
                              ,'\"meta_value\": ','\"',e.meta_value,'\"}')
                ,']') as post_events_json,
						CONCAT('[',
                GROUP_CONCAT('{\"term_id\":','\"',t.term_id,'\",'
                              ,'\"name\":','\"',t.name,'\",'
                              ,'\"slug\": ','\"',t.slug,'\"}')
                ,']') as post_terms_json

       FROM
             $wpdb->posts p,
             $wpdb->postmeta e,
             $wpdb->term_relationships tr,
             $wpdb->terms t

        WHERE
             p.post_type LIKE %s
             AND e.post_id = p.ID
             AND e.meta_key LIKE %s
             AND e.meta_value >= %s
             AND tr.object_id = p.ID
             AND t.term_id = tr.term_taxonomy_id
        group by
            p.ID
        ORDER by
            e.meta_value ASC

        LIMIT
            0, $limit
        ",
				'produktion', //posttype
				'events_%_datum', // meta_name: $ParentName_$RowNumber_$ChildName
				strtotime("now") // meta_value: 'type_3' for example

		));
		//setlocale(LC_ALL, 'de_DE.utf-8'); //  deutsche Monatsnamen

		return $rows;

}


/**
 * FREIE PLÄTZE
 *
 * @param $post_id
 * @param $meta_key
 * @return mixed
 */
function get_free_seats($post_id, $meta_key){

		$meta_key = str_replace('datum','freie_plaetze', $meta_key);
		global $wpdb;
		$freie_plaetze = $wpdb->get_results(
				$wpdb->prepare(
						"SELECT
                            e.meta_value
                      FROM $wpdb->postmeta e
                      WHERE
                            e.post_id = %s
                            AND e.meta_key = %s
                      ORDER BY
                            e.meta_key ASC
                     ",
						$post_id, $meta_key) );


		return $freie_plaetze[0]->meta_value;
}


/**
 * ALL EVENTS FOR SINGLE PRODUKTION
 *
 * @param $post_id
 * @return \stdClass $post_events stdClass
 */
function get_post_events( $post_id) {
		global $wpdb;
		$events_date_json = $wpdb->get_results(
				$wpdb->prepare(
						"SELECT
                            e.meta_key,
                            e.meta_value
                      FROM $wpdb->postmeta e
                      WHERE
                            e.post_id = %s
                            AND (e.meta_key LIKE %s OR e.meta_key LIKE %s)
                      ORDER BY
                            e.meta_key ASC

                     ",
						$post_id, 'events_%_datum', 'events_%_freie_plaetze') );

		$post_events = new stdClass();
		$i = 0;
		foreach ($events_date_json as $meta) {

				if (strpos($meta->meta_key, 'datum') !== false){
						// true
						$event_key = str_replace('_datum','',$meta->meta_key);
						$post_events->$event_key =  new stdClass();
						$post_events->$event_key->datum_key = $meta->meta_key;
						$post_events->$event_key->datum = $meta->meta_value;
						$i++;
				}else{
						$post_events->$event_key->freie_plaetze_key=$meta->meta_key;
						$post_events->$event_key->freie_plaetze=$meta->meta_value;
				}
		}
		return $post_events;
}

/**
 * MONTHLY PROGRAMM - LISTING PRODUKTIONEN
 *
 * @param string $month
 * @param string $year
 *
 * @internal param int $limit
 * @return mixed
 */
function get_monthly_programm($month = '04', $year = '2014'){

		$start = strtotime($month .'/01/'.$year);
		$end = strtotime('+ 1 month', $start);

		global $wpdb;
		$rows = $wpdb->get_results($wpdb->prepare(
				"
        SELECT
            p.*,
            CONCAT('[',
                GROUP_CONCAT('{\"meta_id\":','\"',e.meta_id,'\",'
                              ,'\"meta_key\":','\"',e.meta_key,'\",'
                              ,'\"meta_value\": ','\"',e.meta_value,'\"}')
                ,']') as post_events_json,
						CONCAT('[',
                GROUP_CONCAT('{\"term_id\":','\"',t.term_id,'\",'
                              ,'\"name\":','\"',t.name,'\",'
                              ,'\"slug\": ','\"',t.slug,'\"}')
                ,']') as post_terms_json

       FROM
             $wpdb->posts p,
             $wpdb->postmeta e,
             $wpdb->term_relationships tr,
             $wpdb->terms t

        WHERE
             p.post_type LIKE %s
             AND e.post_id = p.ID
             AND e.meta_key LIKE %s
             AND e.meta_value >= %s AND e.meta_value < %s
             AND tr.object_id = p.ID
             AND t.term_id = tr.term_taxonomy_id
        group by
            e.meta_value
        ORDER by
            e.meta_value ASC

        ",
				'produktion', //posttype
				'events_%_datum', // meta_name: $ParentName_$RowNumber_$ChildName
				$start, $end//strtotime("now") // meta_value: 'type_3' for example

		));
		//setlocale(LC_ALL, 'de_DE.utf-8'); //  deutsche Monatsnamen

		return $rows;

}


/**
 * PROGRAMM - LISTING PRODUKTIONEN GEFILTERT NACH CATEGORY
 * AKTUELLES DATUM ZUERST
 *
 * @param int $limit
 * @param string $category_name
 *
 * @return mixed
 */
function get_programmFor($limit=5,  $category_name = 'Vorbrenner' ){

//		term_relationship -> object_id (= posts -> post_id);
//		term_relationship -> term_taxonomy_id (= terms -> term_id (taxonomy = name))


		global $wpdb;
		$rows = $wpdb->get_results($wpdb->prepare(
				"
        SELECT
            p.*,
            CONCAT('[',
                GROUP_CONCAT('{\"meta_id\":','\"',e.meta_id,'\",'
                              ,'\"meta_key\":','\"',e.meta_key,'\",'
                              ,'\"meta_value\": ','\"',e.meta_value,'\"}')
                ,']') as post_events_json,
						CONCAT('[',
                GROUP_CONCAT('{\"term_id\":','\"',t.term_id,'\",'
                              ,'\"name\":','\"',t.name,'\",'
                              ,'\"slug\": ','\"',t.slug,'\"}')
                ,']') as post_terms_json

       FROM
             $wpdb->terms t,
             $wpdb->term_relationships tr,
             $wpdb->posts p,
             $wpdb->postmeta e

        WHERE
             t.name = %s
             AND tr.term_taxonomy_id = t.term_id
             AND p.ID = tr.object_id
             AND e.post_id = p.ID
             AND e.meta_key LIKE %s
             AND e.meta_value >= %s

        group by
            p.ID
        ORDER by
            e.meta_value ASC

        LIMIT
            0, $limit
        ",

				$category_name,
				//'produktion', //posttype
				'events_%_datum', // meta_name: $ParentName_$RowNumber_$ChildName
				strtotime('now - 1 year') // meta_value: 'type_3' for example


		));
		//setlocale(LC_ALL, 'de_DE.utf-8'); //  deutsche Monatsnamen

		return $rows;

}


// category nicename in body and post class
function category_id_class($classes) {
		global $post;
		foreach((get_the_category($post->ID)) as $category)
				$classes[] = $category->category_nicename;
		return $classes;
}
add_filter('post_class', 'category_id_class');