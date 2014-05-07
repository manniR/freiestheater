<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <!--THE LOOP-->

    <article class="row">
        <?php get_template_part('partials/line', ''); // partials/loop-single.php ?>
        <div class="col-xs-12">
            <p class="paddT1em"><strong><?= get_the_date(); ?></strong></p>
            <h2><?php the_title();?></h2>
            <?php the_content(); ?>
        </div>
    </article>

<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>