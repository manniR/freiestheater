<!DOCTYPE html>
<!--[if lt IE 7]>
<html  ng-app="app" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html ng-app="app"  class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html ng-app="app" class="no-js lt-ie9"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html ng-app="app" <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo bloginfo('name'); wp_title('|', true, 'left'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<!-- media-queries.js (fallback) -->
	<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<!-- html5.js -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<!-- wordpress head functions -->
	<?php wp_head(); ?>
	<!-- end of wordpress head -->

</head>
<body <?php body_class(); ?>>


<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
	your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to
	improve your experience.</p>
<![endif]-->
<header>
	<div class="container">
		<div class="row">
				<div class="col-md-8">
					<a href="/"><h1 class="logo">"Frei est heater in nsbruck."</h1></a>
				</div>
				<div class="col-md-3 col-md-offset-1">
					<div class="row">

					<div class="col-xs-12 " style="margin-top: 1rem;">
						<a href="http://www.facebook.com/FreiesTheaterInnsbruck?ref=ts&fref=ts"><span
								class="fa-stack fa-1x" style="">
                          <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                          <i class="fa fa-facebook fa-stack-1x white"></i>
                        </span></a>
						<a href="http://www.twitter.com/freiestheater"><span class="fa-stack fa-1x" style="">
                          <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                          <i class="fa fa-twitter fa-stack-1x white"></i>
                        </span></a>

<!--									<a class="btn btn-default pull-right" href="http://freiestheater.us6.list-manage.com/subscribe/post?u=86b1f81fbb23e8c8bea626de5&amp;id=5bd8df3ac6">NEWSLETTER</a>-->
									<a class="btn pull-right" href="#newsletter-accordion" style="line-height: 2rem" data-toggle="collapse" data-parent="header">NEWSLETTER <i class="fa fa-caret-down">&nbsp;</i></a>

					</div>
							<div class="col-xs-12 panel-collapse collapse" id="newsletter-accordion" style="margin: 1rem 0;">
									<form
											action="http://freiestheater.us6.list-manage.com/subscribe/post?u=86b1f81fbb23e8c8bea626de5&amp;id=5bd8df3ac6"
											class="form-inline validate" method="post" id="mc-embedded-subscribe-form"
											name="mc-embedded-subscribe-form" role="form" target="_blank" novalidate="">
											<div class="input-group">
													<input type="email" class="form-control" value="" name="EMAIL" id="mce-EMAIL"
													       placeholder="Email Adresse" required="" type="email"/>
												<span class="input-group-btn"><button class="btn btn-primary" type="submit">Submit
														</button></span>
											</div>
									</form>
							</div>

					<div class="col-xs-12" style="margin-top:1rem;">

							<form action="<?= home_url() . '/' ?>" method="get" class="" role="search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search" name="s"
									       id="s" value="Search">

									<div class="input-group-btn">
										<button class="btn btn-default " type="submit"><i
												class="glyphicon glyphicon-search"></i>
										</button>
									</div>
								</div>
							</form>

					</div>
				</div>
				</div>
		</div>
		<nav class="navbar-default row">
			<div class="col-xs-12 padd0">
				<a class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar" style="color: #000000  "></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<div class="navbar-collapse collapse ">
					<ul class="nav navbar-nav">

						<li class="<?= ( is_category( 'aktuelles' ) ? 'active' : '' ) ?>"><a href="/aktuelles">Akt uell</a></li>
						<li class="seperator">|</li>
						<li class="<?= ( is_page( 'liebes-akt-oder-wer-wir-sind' ) ? 'active' : '' ) ?>"><a href="/liebes-akt-oder-wer-wir-sind">Liebes Akt</a></li>
						<li class="seperator">|</li>
						<li class="<?= ( is_page( 'vorbrenner' ) ? 'active' : '' ) ?>"><a href="/vorbrenner">Vorbrenner</a></li>
						<li class="seperator">|</li>
						<li class="<?= ( is_page( 'kontakt' ) ? 'active' : '' ) ?>"><a href="/kontakt">Kont Akt</a></li>
						<li class="seperator">|</li>
						<li class="<?= ( is_page( 'programm' ) ? 'active' : '' ) ?>"><a href="/programm/<?= date('m/Y', strtotime('now')) ?>">Pro Gramm</a></li>
						<li class="seperator">|</li>
						<li class="<?= ( is_post_type_archive( 'presse' ) ? 'active' : '' ) ?>"><a href="/presse">Presse</a></li>
					</ul>


				</div>

			</div>

		</nav>
	</div>
</header>



