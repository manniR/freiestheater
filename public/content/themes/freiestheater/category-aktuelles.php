<?php get_header(); ?>

<main role="main"><!--MAIN CONTENT-->

    <section class="container"><!--EVENT LISTING-->

        <div class="row eventlist-header">
            <div class="col-sm-7 col-title">
                <h1 class="clearfix"><?php $description = get_the_category(); if ($description) echo $description[0]->description;  ?></h1>
            </div>


        </div>

        <?php get_template_part('partials/loop', 'single'); // partials/loop-single.php ?>

    </section>
    <!--END EVENT LISTING-->
</main><!-- END MAIN CONTENT-->
<?php get_footer() ?>
