<?php get_header(); get_header_image()?>


<main role="main"><!--MAIN CONTENT-->

  <section class="container"><!--EVENT LISTING-->

    <div class="row eventlist-header">
      <div class="col-sm-7 col-title">
        <h1 class="clearfix">Reservierung</h1>
      </div>

    </div>

    <?php
    echo '<pre>';
    var_dump(wp_bootstrap_main_nav());
    echo '</pre>';
    ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <!--THE LOOP-->

      <article class="row">


      </article><!--end EVENT ARTICLE-->

      <?php endwhile;?>
    <?php endif; ?>
    <?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>
  </section><!--END EVENT LISTING-->
</main><!-- END MAIN CONTENT-->
<?php get_footer() ?>
