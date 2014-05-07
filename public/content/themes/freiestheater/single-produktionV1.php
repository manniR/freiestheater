<?php get_header(); ?>

<main role="main"><!--MAIN CONTENT-->

    <section class="container eventlist"><!--EVENT LISTING-->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="row event <?= ($i % 2 == 0) ? 'even' : 'odd' ?>">
        <!--LINE-->
        <div class="col-xs-12 line">
            <div class="border-top-black"></div>
        </div>

        <div class="col-sm-8 col-xs-12 col-event-info"> <!--EVENT INFO column-->
            <!--TIME-->

            <div class="row date">
                <div class="col-xs-12 col-sm-6 col-event-date">
                    <time class="event-time clearfix" datetime="<?= date('d-m-Y H:i',strtotime($events[0]->meta_value)); ?>">
                        <?= strftime('<span><span>%a %d.</span> %B %Y <span>%H:%M</span></span>', strtotime($events[0]->meta_value)); ?>
                        <?php //<span><span>Fr 13.</span> Dezember 2013 <span>18:30</span></span> ?>
                    </time>

                </div>
            </div>
            <div class="event-header">
                <h2><?php the_title(); ?></h2>
                <?php
                /*show only content before more tag*/
                global $more;
                $more = false;
                the_content('');
                $more = true;
                ?>

                <p>Wo: <?= get_field('wo'); ?></p>
            </div>
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-2 paddR0">
                    <span class="ticket-symbol"></span>
                </div>
                <div class="col-xs-8">
                    <p>
                                    <span class="bb">
                                        <?= get_field('eintritt_kinder') ? get_field('eintritt_kinder') . "</span> Eintritt Kinder |" : ''; ?>
                                        <?= get_field('eintritt_erwachsene') ? get_field('eintritt_erwachsene') . "</span> Eintritt <br>" : ''; ?>
                                        <span class="bb">
                                  <?= get_field('plaetze') ? get_field('plaetze') . "</span> freie Plätze" : ''; ?>
                                </p>
                </div>
            </div>
            <div class="row">
                <!--TODO reservation form-->
                <div class="col-xs-12">
                    <h4 class="panel-title text-right">
                        Produktionsdetails
                    </h4>
                    <div id="collapse<?= $post->ID; ?>" class="panel-collapse">
                        <div class="panel-body">
                            <?php
                            // CONTENT BELOW MORE TAG
                            the_content('', TRUE, '');
                            ?>
                        </div>

                        <?php $events = get_field('datum');?>

                        <div class="termine">
                            <?php foreach($events as $event): ?>
                                <div class="row">
                                    <div class="col-xs-4 paddR0"><p><?= strftime('<span class="bb">%a %d.</span> %B %Y %H:%M', strtotime($event['datum'])); ?></p></div>
                                    <div class="col-xs-8 paddL0">
                                        <div class="col-xs-4 paddLR0"><p><span class="bb">60</span> freie Plätze</p></div>
                                        <div class="col-xs-8 paddL0 ticket"><p><a href="#" data-eventID="<?= $event->meta_id ?>">Tickets reservieren</a></p></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!--END EVENT INFO column-->

        <div class="col-sm-4 col-xs-12 image">
            <!--  <img class="w100" src="http://lorempixel.com/320/260/fashion/5" alt=""/>-->
            <?php the_post_thumbnail('medium', array('class' => 'w100'));
            /*
             Post Thumbnail Linking to Large Image Size This example links to the "large" Post Thumbnail image size and must be used within The Loop.
            */
            /*if (has_post_thumbnail()) {
              $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
              echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
              the_post_thumbnail('thumbnail', array('class' => 'w100'));
              echo '</a>';
            }*/

            ?>
        </div>

    </article><!--end EVENT ARTICLE-->


<?php endwhile; ?>

    <?php wp_reset_postdata(); ?>
<?php else:  ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php  endif; ?>

</section>
    </main>

<?php get_footer(); ?>