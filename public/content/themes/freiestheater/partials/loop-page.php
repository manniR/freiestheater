<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="row eventlist-header">
        <div class="col-sm-7 col-title">
            <h1 class="clearfix"><?php the_title();?></h1>
        </div>
        <?php get_template_part('partials/line', ''); // partials/loop-single.php ?>

    </div>

    <!--THE LOOP-->

    <article class="row single-page">

        <div class="col-xs-12 ">
            <?php the_content(); ?>
        </div>
    </article><!--end EVENT ARTICLE-->

<?php endwhile;?>
<?php endif; ?>
<?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>