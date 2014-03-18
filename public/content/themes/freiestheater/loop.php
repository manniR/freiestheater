<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 3/18/14
 * Time: 9:03 AM
 */
?>

<main role="main"><!--MAIN CONTENT-->
  <section class="container eventlist"><!--EVENT LISTING-->

    <div class="row eventlist-header">
      <div class="col-sm-7 col-title">
        <h1 class="clearfix">Pro Gramm</h1>
      </div>
      <div class="col-sm-5 col-link-all-events">
        <a href="programm">alte Hüte</a>
      </div>
    </div>

<?php if ($rows): foreach ($rows as $post): setup_postdata($post); ?>
  <!--THE LOOP-->
  <article class="row event even <?php post_class(); ?>">
    <!--LINE-->
    <div class="col-xs-12 line"><div class="border-top-black"></div></div>


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
  </article><!--end EVENT ARTICLE-->
<?php endforeach;?>
<?php endif; ?>
<?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>
</section><!--END EVENT LISTING-->
</main><!-- END MAIN CONTENT-->