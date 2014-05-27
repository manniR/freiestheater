<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 05.03.14
 * Time: 23:42
 */


/*
 * BOOKINGS MENU
 */

add_action( 'admin_menu', 'register_ft_bookings_menu_page' );

function register_ft_bookings_menu_page(){
		add_menu_page( 'Reservierungen', 'RESEVIERUNGEN', 'administrator', 'bookings', 'ft_show_bookings', '', 6 );
}

function ft_show_bookings(){
	echo "<h1>RESERVIERUNGEN</h1>";
	echo '<hr>';
	echo '<h2>11.05.2014 - Antigone </h2>';
		echo '<table>
    <tr>exit();
		<th>Tickets</th>
        <th>email</th>
        <th>Name</th>
        <th>Bestelldatum</th>
    </tr>
    <tr>
        <td>2</td>
        <td>bestellt@jkd.com</td>
        <td>Test BestellerIn</td>
        <td>11.02.2014</td>
    </tr>
    <tr>
        <td>4</td>
        <td>jdkien@oi.com</td>
        <td>Irgendein Name</td>
        <td>10.02.2014</td>
    </tr>

</table>    ';


/*
 * TODO: 2 pages:
 *
 * EVENTS:      list all events grouped by date
 *              link to event bookings list page
 *
 * BOOKINGS (event_id):     get all bookings for event
 *                          update/delete for single booking
 *                          print-functionality
 *
 *
 */



}



add_action( 'admin_action_getBookings', 'getBookings_admin_action' );

function getBookings_admin_action(){

		//do your stuff here
		return 'helo';
		echo '<pre>';
		var_dump(get_queried_object());
		echo '</pre>';

		wp_redirect( $_SERVER['HTTP_REFERER'] );


}


/*
 * BOOKINGS Listing
 */

// table header
add_filter('manage_bookings_custom_head', 'ft_bookings_table_head');

function ft_bookings_table_head($defaults)
{
  //$defaults['datum'] = 'Datum';

  $columns = array(
    'cb' => '<input type="checkbox" />',
    'event_id' => __('ID'),
		'event_date' => __('Datum'),
    'event_title' => __('Event-Title'),
    'name' => __('Name'),
    'email' => __('E-Mail'),
    'tickets' => __('Tickets')
  );

  return $columns;
  //return $defaults;

}


//table data
add_action('manage_bookings_custom_column', 'mr_manage_tourdate_columns', 10, 2);

function mr_manage_tourdate_columns($column, $post_id)
{
  global $post;

  switch ($column) {
    case 'tourdate':
      //setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
      setlocale(LC_TIME, 'de_DE'); //  deutsch Monatsnamen
      echo strftime('%d. %B %Y', strtotime(get_field('datum', $post_id)));
      break;
    default:
      break;
  }
}

//make it sortable
add_filter('manage_edit-tourdate_sortable_columns', 'mr_tourdate_sortable_columns');

function mr_tourdate_sortable_columns($columns)
{

  $columns['tourdate'] = 'tourdate';
  return $columns;
}


/* Only run our customization on the 'edit.php' page in the admin. */
add_action('load-edit.php', 'mr_edit_tourdate_load');

function mr_edit_tourdate_load()
{
  add_filter('request', 'mr_sort_tourdate');
}

/* Sorts the tourdates. */
function mr_sort_tourdate($vars)
{

  /* Check if we're viewing the 'movie' post type. */
  if (isset($vars['post_type']) && 'touredate' == $vars['post_type']) {

    /* Check if 'orderby' is set to 'duration'. */
    if (isset($vars['orderby']) && 'touredate' == $vars['orderby']) {

      /* Merge the query vars with our custom variables. */
      $vars = array_merge(
        $vars,
        array(
          'meta_key' => 'datum',
          'orderby' => 'meta_value_num'
        )
      );
    }
  }

  return $vars;
}



// gets triggerd when click on edit
add_action('load-post.php', 'mr_edit_post');
function mr_edit_post()
{

  /**
   * @var wpbd $wpdb
   */

  /*global $wpdb;

  $post = get_post( $_GET['post']);
  echo $post->post_title;
  //$meta = new stdClass();
  $meta = get_post_meta($_GET['post']);
  //$meta = get_metadata('post',$_GET['post']);

  foreach ($meta as $fa => $fk) {
      echo $fa . '<br/>' ;
      foreach ($fk as $k => $v) {
          echo $k . ':::' . $v . '<br/>';
      }

  }*/


  /* echo '<pre>';
   var_dump($meta);
   echo '</pre>';*/


  //echo $_GET['post'];


  /*echo '<pre>';
   var_dump($wpdb);
   echo '</pre>';*/
}

add_action( 'admin_action_wpse10500', 'wpse10500_admin_action' );
function wpse10500_admin_action()
{

		wp_redirect( $_SERVER['HTTP_REFERER'] );
		exit();
}

add_action( 'admin_menu', 'wpse10500_admin_menu' );
function wpse10500_admin_menu()
{
		add_menu_page( 'WPSE 10500 Test page', 'TEST PAGE', 'administrator', 'wpse10500', 'wpse10500_do_page' );
}

function wpse10500_do_page()
{
		?>
		<a href="<?php echo admin_url( 'admin.php?action=wpse10500&event_id=12121212&noheader=true' );?>" class="btn btn-primary">CLICK ME</a>
		<!--<form method="POST" action="<?php /*echo admin_url( 'admin.php' ); */?>">
				<input type="hidden" name="action" value="wpse10500" />
				<input type="submit" value="Do it!" />
		</form>-->
<?php
}