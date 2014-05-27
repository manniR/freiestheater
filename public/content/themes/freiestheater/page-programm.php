<?php get_header(); ?>

		<main role="main"><!--MAIN CONTENT-->


		<section class="container eventlist"><!--EVENT LISTING-->

		<div class="row eventlist-header">
				<div class="col-xs-12 col-title">

						<?php
						/* month/day/year */
						/*echo $wp_query->query['month'] .'<br>';
						echo $wp_query->query['year'];*/

						$month         = check_month( $wp_query->query['month'] );
						$day           = '/01/';
						$year          = check_year( $wp_query->query['year'] );
						$date          = new stdClass();
						$date_from_uri = new DateTime( $month . $day . $year );
						$date_from_uri = $date_from_uri->getTimestamp();

						/* selected date = date from uri else = now */
						$date->start    = strtotime( '2014/04/01' );
						$date->max      = strtotime( 'now + 2 month' );
						$date->selected = ( $date_from_uri ) ? $date_from_uri : strtotime( 'now' );
						$date->prev     = strtotime( '- 1 month', $date->selected );
						$date->next     = strtotime( '+ 1 month', $date->selected );
						function check_month( $m ) {
								for ( $i = 1; $i <= 12; $i ++ ) {
										if ( $i == $m ) {
												return $m;
										}
								}
						}

						function check_year( $y ) {
								$years = array( '2014', '2015' );
								foreach ( $years as $year ) {
										if ( $year == $y ) {
												return $y;
										}
								}
						}

						?>
						<div class="row">
								<div class="col-sm-6">
										<h1 class="clearfix">Pro Gramm </h1>
								</div>
								<div class="col-sm-6">
										<ul class="month-archive nav navbar-nav pull-right">
												<li class="month-prev <?= ( $date->prev >= $date->start ) ? '' : 'disabled'; ?>">
														<a href="/programm/<?= ( $date->prev >= $date->start ) ? date( 'm/Y', $date->prev ) : date( 'm/Y', $date->start ); ?>">
																<h3 class="fa fa-chevron-left"></h3>
														</a>
												</li>
												<li class="month-name">
														<h3><?= strftime( '%B %Y', $date->selected ); ?></h3>
												</li>
												<li class="month-next <?= ( $date->next < $date->max ) ? '' : 'disabled'; ?>">
														<a href="/programm/<?= ( $date->next < $date->max ) ? date( 'm/Y', $date->next ) : date( 'm/Y', $date->max ); ?>">
																<h3 class="fa fa-chevron-right"></h3>
														</a>
												</li>
										</ul>
								</div>
						</div>
				</div>
		</div>

		<?php $rows = get_monthly_programm( $month, $year );

		if ( $rows ): ?>
				<?php $i = 0; ?>
				<?PHP foreach ( $rows as $post ): setup_postdata( $post ); ?>
						<?php

						// EVENT ID AND DATE FROM JSON
						$events   = ( $post->post_events_json ) ? json_decode( $post->post_events_json ) : array( 'meta_value' => 'Keine Events gefunden!' );
						$category = ( $post->post_terms_json ) ? json_decode( $post->post_terms_json ) : '';
						$color    = ( $category[0]->name == 'Vorbrenner' ) ? 'orange' : 'black';

						?>
						<!--THE LOOP-->
						<article class="row event <?= ( $i % 2 == 0 ) ? 'even' : 'odd' ?> <?= strtolower( $category[0]->name ) ?>">
								<!--LINE-->
								<div class="col-xs-12 line">
										<div class="border-top-<?= $color ?>"></div>
								</div>

								<div class="col-sm-8 col-xs-12 col-event-info"> <!--EVENT INFO column-->
										<!--TIME-->

										<div class="row date <?= strtolower( $category[0]->name ) ?>">
												<div class="col-xs-12 col-sm-6 col-event-date">
														<time class="event-time clearfix"
														      datetime="<?= date( 'd-m-Y H:i', date( $events[0]->meta_value ) ); ?>">
																<span
																		class="<?= $color ?>BG "><?= strftime( '<span>%a %d.</span> %B %Y <span>%H:%M</span>', date( $events[0]->meta_value ) ); ?></span>
																<?php //<span><span>Fr 13.</span> Dezember 2013 <span>18:30</span></span> ?>
														</time>

												</div>
												<?php if ( $category[0]->name == 'Vorbrenner' ): ?>
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

												<?php //get_template_part( 'partials/template', 'produktionsdetailsMonthly' ); ?>

												<div class="col-xs-12">

														<h4 class="panel-title text-right">
																<a data-toggle="collapse" data-parent="#accordion"
																   href="#collapse<?= $events[0]->meta_id; ?>">Produktionsdetails</a>
														</h4>

														<div id="collapse<?= $events[0]->meta_id; ?>" class="panel-collapse collapse">
																<div class="panel-body">
																		<?php
																		// CONTENT BELOW MORE TAG
																		the_content( '', true, '' );
																		?>
																</div>
														</div>


														<!--TODO reservation form-->

														<?php //get_template_part( 'partials/template', 'ticket-reservation-form' ); ?>
														<?php $event_id=$events[0]->meta_id; ?>
														<div id="reservierung-event-<?= $events[0]->meta_id; ?>" class="panel-collapse collapse">

																		<form class="form-horizontal form-ticketreservierung"
																					name="<?= $event_id; ?>"
																					novalidate
																					ng-controller="BookingCtrl"
																					ng-init="eventinfos = { 'id': '<?= $event_id; ?>',
																																	'date' : '<?= date( 'd-m-Y H:i', date( $events[0]->meta_value ) ); ?>',
																																	'title' : '<?= the_title(); ?>',
																																	'availableTickets' : '<?= get_free_seats($id, $events[0]->meta_key) ?>'
																																}"

																				>
																				<fieldset>
																						<div class="form-event-title">
																								<p>für die Vorstellung<span><?php the_title(); ?><br>
																												<?= strftime( '%a %d. %B %Y um %H:%M', date( $events[0]->meta_value ) ); ?></span>
																								</p>

																						</div>

																						<!-- Text input-->
																						<div class="form-control-feedback">
																								<div class="">
																										<input name="name" type="text" placeholder="Name"
																										       class="form-control input-md"
																										       >

																								</div>
																						</div>

																						<!-- Text input-->
																						<div class="form-control-feedback">
																								<div class="">
																										<input name="email" type="text" placeholder="email"
																										       class="form-control input-md"
																										       >

																								</div>
																						</div>

																						<!-- Text input-->
																						<div class="form-inline form-group-anzahl">

																								<input id="tickets" name="tickets" type="text" placeholder="Tickets"
																								       class="form-control input-md"
																								       required="">
																								<label class="control-label" for="tickets">Anzahl Tickets</label>
																						</div>

																						<!-- Button -->
																						<div class="form-control-feedback">
																								<label class="control-label" for="submit"></label>

																								<div >
																										<button class="btn btn-default" ng-click="submitBookingForm('<?= $event_id; ?>')">Abschicken</button>
																								</div>
																						</div>
																						<div class="form-control-static">
																								<p class="ticket-form-note" >
																										Tickets bitte 30 Minuten vor Vorstellungsbeginn abholen. <br>
																										Sie erhalten ein Bestätigungsemail für diese Reservierung. Sollten Sie
																										keines
																										erhalten, könnte es an einer fehlerhanft eingefüllten Email-Adresse
																										liegen.
																										Versuchen Sie bitte die Reservierung dann nochmals
																								</p>
																						</div>
																				</fieldset>
																		</form>

														</div>





												</div>
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