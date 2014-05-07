<?php get_header(); ?>

		<main role="main"><!--MAIN CONTENT-->


				<section class="container eventlist"><!--EVENT LISTING-->

						<div class="row eventlist-header">
								<div class="col-xs-12 col-title">
										<h1 class="clearfix">Pro Gramm

												<!--                    <span class="top-link pull-right smaller"><a href="/programm">Wollen Sie alle Programmpunkte sehen</a></span>-->
										</h1>
								</div>
						</div>
						<?php $rows = get_programm(1000);//get_programm( 100 );

						if ( $rows ): ?>
								<?php $i = 0; ?>
								<?PHP foreach ( $rows as $post ): setup_postdata( $post ); ?>
										<?php

										// EVENT ID AND DATE FROM JSON
										$events = ( $post->post_events_json ) ? json_decode( $post->post_events_json ) : array( 'meta_value' => 'Keine Events gefunden!' );
										$category = ( $post->post_terms_json ) ? json_decode( $post->post_terms_json ) : '';
										$color = ($category[0]->name == 'Vorbrenner')? 'orange':'black';

										?>
										<!--THE LOOP-->
										<article class="row event <?= ( $i % 2 == 0 ) ? 'even' : 'odd' ?> <?= strtolower($category[0]->name) ?>">
												<!--LINE-->
												<div class="col-xs-12 line">
														<div class="border-top-<?= $color ?>"></div>
												</div>

												<div class="col-sm-8 col-xs-12 col-event-info"> <!--EVENT INFO column-->
														<!--TIME-->

														<div class="row date <?= strtolower($category[0]->name) ?>">
																<div class="col-xs-12 col-sm-6 col-event-date">
																		<time class="event-time clearfix"
																		      datetime="<?= date( 'd-m-Y H:i', date( $events[0]->meta_value ) ); ?>">
																				<span class="<?= $color ?>BG "><?= strftime( '<span>%a %d.</span> %B %Y <span>%H:%M</span>', date( $events[0]->meta_value ) ); ?></span>
																				<?php //<span><span>Fr 13.</span> Dezember 2013 <span>18:30</span></span> ?>
																		</time>

																</div>
																<?php if($category[0]->name == 'Vorbrenner'): ?>
																<div class="col-xs-12 col-sm-6 col-event-date">
																		<h5 class="<?= $color ?>"><?= $category[0]->name ?></h5>
																</div>
																<?php endif; ?>
														</div>
														<div class="event-header">
																<h2><?php the_title(); ?></h2>
																<?php
																/*show only content before more tag*/
																global $more;
																$more = false;
																the_content( '' );
																$more = true;
																?>

																<p>Wo: <?= get_field( 'wo' ); ?></p>
														</div>
														<div class="row">
																<?php get_template_part( 'partials/template', 'ticketinfos' ) ?>
														</div>
														<div class="row">
																<!--TODO reservation form-->

																<?php get_template_part( 'partials/template', 'produktionsdetails' ); ?>

														</div>
												</div>
												<!--END EVENT INFO column-->

												<div class="col-sm-4 col-xs-12 image">
														<!--  <img class="w100" src="http://lorempixel.com/320/260/fashion/5" alt=""/>-->
														<!--                            --><?php //the_post_thumbnail('medium', array('class' => 'w100'));
														/*
														 Post Thumbnail Linking to Large Image Size This example links to the "large" Post Thumbnail image size and must be used within The Loop.
														*/
														if ( has_post_thumbnail() ) {
																$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'programmbild' );
																echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute( 'echo=0' ) . '" class="gallery" >';
																the_post_thumbnail( 'prod-thumbnail', array( 'class' => 'w100' ) );
																echo '</a>';
														}
														?>
												</div>
										</article><!--end EVENT ARTICLE-->

										<?php $i ++; endforeach; ?>
						<?php endif; ?>
						<?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>
				</section>
				<!--END EVENT LISTING-->
		</main><!-- END MAIN CONTENT-->


<?php get_footer() ?>