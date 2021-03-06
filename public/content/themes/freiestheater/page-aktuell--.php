<?php
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
  'events_%_datum', // meta_name: $ParentName_$RowNumber_$ChildName
  strtotime("now") // meta_value: 'type_3' for example

));

setlocale(LC_ALL, 'de_DE.utf-8'); //  deutsche Monatsnamen

?>

<?php if ($rows):
  foreach ($rows as $post):
    setup_postdata($post); ?>
    <div <?php post_class(); ?>>

      <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
      <?php the_content('', TRUE, ''); ?>
      <time><?= strftime('<span><span>%a %d.</span> %B %Y <span>%H:%M</span></span>', $post->meta_value); ?></time>

      <?php //the_post_thumbnail('thumbnail');
      /*
       Post Thumbnail Linking to Large Image Size This example links to the "large" Post Thumbnail image size and must be used within The Loop.
      */
      if (has_post_thumbnail()) {
        $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
        echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
        the_post_thumbnail('thumbnail');
        echo '</a>';
      }

      ?>

      <?php
      /*
       BILDER GALERIE
      */
      ?>

      <?php if (get_field('events')): ?>
      <div>
        <ul class="gallery">
        <?php while(have_rows('bilder_galerie')): the_row(); ?>
        <?php
          /*echo '<pre>';
          var_dump(get_sub_field('bild'));
          echo '</pre>';*/
          ?>
        <li class="image">

          <img  src="<?php $bild = get_sub_field('bild'); echo $bild['sizes']['medium']; ?> ">

        </li>

        <?php endwhile; ?>

        </ul>
      </div>

    <?php endif; ?>
    </div> <!--END POST-->
  <?php endforeach;?>
  <?php endif; ?>


<?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>






