<footer role="contentinfo" class="">
		<div class="border-top-black"></div>
		<!--LINE-->
		<div class="container">
				<div class="row">
						<div class="col-sm-8 ">
								<div class="row">
										<nav class="col-xs-12">
												<ul class="nav navbar-nav navbar-footer">
														<li class="<?= ( is_category( 'aktuelles' ) ? 'active' : '' ) ?>"><a href="/aktuelles">Akt uell</a></li>
														<li class="seperator">|</li>
														<li class="<?= ( is_page( 'liebes-akt-oder-wer-wir-sind' ) ? 'active' : '' ) ?>"><a href="/liebes-akt-oder-wer-wir-sind">Liebes Akt</a></li>
														<li class="seperator">|</li>
														<li class="<?= ( is_page( 'vorbrenner' ) ? 'active' : '' ) ?>"><a href="/vorbrenner">Vorbrenner</a></li>
														<li class="seperator">|</li>
														<li class="<?= ( is_page( 'kontakt' ) ? 'active' : '' ) ?>"><a href="/kontakt">Kont Akt</a></li>
														<li class="seperator">|</li>
														<li class="<?= ( is_page( 'programm' ) ? 'active' : '' ) ?>"><a href="/programm">Pro Gramm</a></li>
														<li class="seperator">|</li>
														<li class="<?= ( is_post_type_archive( 'presse' ) ? 'active' : '' ) ?>"><a href="/presse">Presse</a></li>
												</ul>
										</nav>
										<div class="col-xs-12 premiera-smaller">
												<p>Kontakt: Wilhelm-Greil-Straße 23, 6020 Innsbruck</p>

												<p>Carmen Sulzenbacher, mobil +43 664 1129285, c.sulzenbacher(at)freiestheater.at <br>
														Daniel Dlouhy, d.dlouhy(at)freiestheater.at</p>
										</div>

								</div>
						</div>

						<div class="col-sm-4">
								<form
										action="http://freiestheater.us6.list-manage.com/subscribe/post?u=86b1f81fbb23e8c8bea626de5&amp;id=5bd8df3ac6"
										class="form-inline validate" method="post" id="mc-embedded-subscribe-form"
										name="mc-embedded-subscribe-form" role="form" target="_blank" novalidate="">
										<label for="inputEmail"><span class="premiera-smaller">Newsletter abonnieren</span></label>

										<div class="input-group">
												<input type="email" class="form-control" value="" name="EMAIL" id="mce-EMAIL"
												       placeholder="Email Adresse" required="" type="email"/>
												<span class="input-group-btn"><button class="btn btn-primary" type="submit">Submit
														</button></span>
										</div>
								</form>
						</div>

				</div>
		</div>
		<div class="supplementary">
				<div class="container">
						<div class="pull-left">
								<p>© Freies Theater Innsbruck | <a href="#">Impressum</a></p>
						</div>
						<div class="pull-right">
								<p>Webdesign <a href="http://manfredraggl.com/">manfredraggl.com</a> <a
												href="http://www.hofergrafik.at/">hofergrafik.at</a></p>
						</div>

				</div>
		</div>
</footer> <!-- end footer -->

<!--[if lt IE 7 ]>
<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
<script>window.attachEvent('onload', function () {
		CFInstall.check({mode: 'overlay'})
})</script>
<![endif]-->

<?php wp_footer(); // js scripts are inserted using this function ?>

</body>

</html>
