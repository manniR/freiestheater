<?php get_header(); get_header_image()?>
INDEX
<!--SLIDER-->
<div id="slider" style="max-height: 340px;">
    <!--SLIDER-->

    <div class="container">
        <?= do_shortcode("[slider id='64' name='Home']"); ?>
    </div>
</div>

<main role="main"><!--MAIN CONTENT-->

  <section class="container eventlist"><!--EVENT LISTING-->

    <div class="row eventlist-header">
      <div class="col-sm-7 col-title">
        <h1 class="clearfix">Der nächste Akt ...</h1>
      </div>
      <div class="col-sm-5 col-link-all-events">
        <a href="/programm">Wollen Sie alle Programmpunkte sehen</a>
      </div>
    </div>

    <?php if ($rows): $i = 0; foreach ($rows as $post): setup_postdata($post); ?>
      <!--THE LOOP-->

      <article class="row event <?= ($i%2 == 0)? 'even': 'odd' ?>">
        <!--LINE-->
        <div class="col-xs-12 line"><div class="border-top-black"></div></div>

        <div class="col-sm-8 col-xs-12 col-event-info"> <!--EVENT INFO column-->
          <!--TIME-->
          <div class="row date">
            <div class="col-xs-12 col-sm-6 col-event-date">
              <time class="event-time clearfix" datetime="2008-02-14T18:30">
                <?= strftime('<span><span>%a %d.</span> %B %Y <span>%H:%M</span></span>', $post->meta_value); ?>
                <!--<span><span>Fr 13.</span> Dezember 2013 <span>18:30</span></span>-->
              </time>
            </div>
          </div>
          <h2><?php the_title(); ?></h2>

          <?php global $more; $more = false; ?>
          <?php the_content(''); ?>
          <?php $more = true; ?>

          <p>Wo: <?= get_field('wo');?></p>

          <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-2 paddR0">
              <span class="ticket-symbol"></span>
            </div>
            <div class="col-xs-8">
              <p>
              <span class="bb">
                <?= get_field('eintritt_kinder')? get_field('eintritt_kinder')."</span> Eintritt Kinder |" : '' ;?>
                <?= get_field('eintritt_erwachsene')? get_field('eintritt_erwachsene')."</span> Eintritt <br>" : '' ;?>
                <span class="bb"><?= get_field('plaetze')? get_field('plaetze')."</span> freie Plätze" : '' ;?>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12"><!--ACCORDION-->
              <!--<p class="pull-right"><a href="#">Produktionsdetails und Termine</a></p>-->

              <!--TODO-->

              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title text-right">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $post->meta_id; ?>">
                      Produktionsdetails
                    </a>
                  </h4>
                </div>
                <div id="collapse<?= $post->meta_id; ?>" class="panel-collapse collapse">
                  <div class="panel-body">
                    <?php the_content('',TRUE,''); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!--END EVENT INFO column-->

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

      <?php $i++; endforeach;?>
    <?php endif; ?>
    <?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>
  </section><!--END EVENT LISTING-->



    <section class="container about">
        <div class="row">
            <div class="col-xs-12 col-line">
                <div class="border-top-black"></div>
            </div>
            <!--LINE-->
            <div class="col-sm-4 col-wir">

                <h2>Liebes Akt oder Wer wir sind</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus esse et harum iste minima
                    nostrum officiis, placeat quae quasi qui, sapiente velit!</p>

                <p>Expedita iste labore provident suscipit vitae. Enim fugiat nesciunt pariatur quis quo tempora ut!
                    Ab animi assumenda fugit magni nam ut voluptas!</p>

                <p>At atque doloremque et nobis odit tenetur ullam. Ab aspernatur eveniet ipsam iusto laboriosam
                    minus nihil quaerat quam veritatis voluptate! Eum, rem?</p>


            </div>
            <div class="col-sm-4 col-kontakt">

                <h2>Kon takt ier uns</h2>

                <p>Lorem ipsum dolor sit amet.</p>

                <p>Aperiam fugiat repellat ut voluptas.</p>

                <p>Dolore pariatur sequi soluta vel.</p>

            </div>
            <div class="col-sm-4 col-vorbrenner">
                <h2>Vorbrenner 14</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto corporis eos id iste neque,
                    provident quae reprehenderit sed sunt! Aperiam aspernatur corporis deserunt dicta eos.</p>

                <p>Aliquam at consequatur culpa cumque delectus ducimus earum explicabo facilis illo illum ipsum iusto
                    maiores minus nesciunt nostrum numquam </p>

                <p><span class="accentuate">*Vorbrenner</span></p>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus delectus dicta incidunt inventore
                    minima nulla praesentium sapiente. Blanditiis consequatur nobis possimus ullam.</p>

            </div>
        </div>

    </section>

</main><!-- END MAIN CONTENT-->


<?php get_footer() ?>
