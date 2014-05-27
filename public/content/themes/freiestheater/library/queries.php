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
 * UPDATE PLÄTZE
 *
 * @param string $count
 * @param $post_id
 * @param $meta_key
 *
 * @return array();
 * post_id=143
 * passed meta_key = events_1_datum
 */

function update_free_seats($count='0',$post_id, $meta_key){

		$meta_key = str_replace('datum','freie_plaetze', $meta_key);

		$available = get_free_seats($post_id, $meta_key);

		$balance = $available - $count;


		if ($balance >= 0){

				// update
				global $wpdb;
				$result = $wpdb->update(
						$wpdb->postmeta,
						//column
						array( 'meta_value'=> $balance ),
						//where
						array('post_id'=> $post_id,'meta_key'=>$meta_key ),
						// substitute for column
						array ('%s'),//value is a string
						//substitution for where
						array ('%d', '%s')
				);

				return array('available' => $balance, 'count' => $count);

		}else{
				// ERROR
				return array('error'=>'zuwenig freie plätze','available' => $available);
		}

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
 *
 * INSERT BOOKINGS
 * @param $request
 *
 * @return false|int
 */
function ft_insert_booking($request){
		global $wpdb;

		$bookings_table = $wpdb->prefix . 'bookings';

		$result = $wpdb->insert($bookings_table ,array(
				'post_id'=>$request->post_id,
				'meta_id'=>$request->meta_id,
				'meta_value'=>$request->meta_value, // datum
				'production_title'=>$request->production_title, //produktionstitel
				'tickets_count'=>$request->tickets_count, // anzahl der reservierten tickets
				'name'=>$request->name,
				'email'=>$request->email
		), array('%d', '%d', '%s', '%s', '%d','%s','%s'));

		if ($result){
				//SUCCESS
				$request['booking_id'] = $wpdb->insert_id;

				return  $request;
		}else{
				//error
				return FALSE;
		}

}

/**
 *
 * INSERT BOOKINGS
 * @param $request
 *
 * @return false|int
 */
function ft_delete_booking($request){
		global $wpdb;

		$bookings_table = $wpdb->prefix . 'bookings';

		$result = $wpdb->delete($bookings_table ,array(
				'post_id'=>$request->post_id,
				'meta_id'=>$request->meta_id,
				'meta_value'=>$request->meta_value, // datum
				'production_title'=>$request->production_title, //produktionstitel
				'tickets_count'=>$request->tickets_count, // anzahl der reservierten tickets
				'name'=>$request->name,
				'email'=>$request->email
		), array('%d', '%d', '%s', '%s', '%d','%s','%s'));

		return $result;

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

/**
 * MONTHLY EVENTS
 *
 * @param string $month
 * @param string $year
 *
 * @internal param int $limit
 * @return mixed
 */
function get_monthly_events($month = '04', $year = '2014'){

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
		return $rows;
}

/**
 * MONTHLY EVENT BOOKINGS
 *
 * @param string $month
 * @param string $year
 *
 * @internal param int $limit
 * @return mixed
 * returns array of events for month as
 * bookings for event are grouped in event_bookings_json as json string
 */
function get_monthly_event_bookings( $month = '', $year = '') {
		global $wpdb;
		if ($month === ''){
				// set current month
				$month = date('m', strtotime('now'));
		}
		if ($year ===''){
				// set current year
				$year = date('Y', strtotime('now'));
		}

		$start = strtotime($month .'/01/'.$year);
		$end = strtotime('+ 4 month', $start);
		$bookingstable = $wpdb->prefix .'bookings';
		global $wpdb;
		$rows = $wpdb->get_results($wpdb->prepare(
				"
        SELECT
           e.*,
           CONCAT('[',
                GROUP_CONCAT('{\"booking_id\":','\"',b.booking_id,'\",'
                              ,'\"post_id\":','\"',b.post_id,'\",'
                              ,'\"event_id\":','\"',b.meta_id,'\",'
                              ,'\"event_date\":','\"',b.meta_value,'\",'
                              ,'\"event_title\":','\"',b.production_title,'\",'
                              ,'\"tickets_count\":','\"',b.tickets_count,'\",'
                              ,'\"name\":','\"',b.name,'\",'
                              ,'\"email\":','\"',b.email,'\",'
                              ,'\"created\": ','\"',b.created,'\"}')
                ,']') as event_bookings_json
        FROM
							$bookingstable b,
              $wpdb->posts p,
              $wpdb->postmeta e

        WHERE
              p.post_type LIKE %s
              AND e.post_id = p.ID
              AND e.meta_key LIKE %s
              AND e.meta_value >= %s AND e.meta_value < %s
              AND b.meta_id = e.meta_id
				GROUP BY
							e.meta_id
        ORDER by
             e.meta_value ASC
        ",
				'produktion',
				'events_%_datum',
				$start, $end
		));

		return $rows;


}

/**
 * EVENT BOOKINGS
 *
 * @param $event_id
 *
 * @internal param string $month
 * @internal param string $year
 *
 * @internal param int $limit
 * @return mixed
 */
function get_event_bookings( $event_id) {
		global $wpdb;
		$rows = $wpdb->get_results($wpdb->prepare(
				"
        SELECT
            b.*,
            CONCAT('[',
                GROUP_CONCAT('{\"booking_id\":','\"',b.booking_id,'\",'
                              ,'\"post_id\":','\"',b.post_id,'\",'
                              ,'\"event_id\":','\"',b.meta_id,'\",'
                              ,'\"event_date\":','\"',b.meta_value,'\",'
                              ,'\"event_title\":','\"',b.production_title,'\",'
                              ,'\"tickets_count\":','\"',b.tickets_count,'\",'
                              ,'\"name\":','\"',b.name,'\",'
                              ,'\"email\":','\"',b.email,'\",'
                              ,'\"created\": ','\"',b.created,'\"}')
                ,']') as event_bookings_json
       FROM
             $wpdb->bookings b,
        WHERE
             b.meta_id = %s
        group by
            b.created
        ORDER by
            b.created ASC
        ",
				$event_id
		));

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