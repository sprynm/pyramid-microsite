		<footer>
			<div class="ftr-container">
				<div class="ftr-top">
					<nav>
						<?php echo $this->Navigation->show(1, false); ?>
					</nav>
				</div>
				<div class="copyright">
					<?php
						if(isset($page) && $page['Page']['id'] == 1) {
							$rhText = $this->Html->link('Radar Hill Web Design', $this->Settings->show('Site.Footer.portfolio_link'), array('rel' => 'nofollow'));
						} else {
							$rhText = "Radar Hill Web Design";
						}
					?>
					&copy; <?php echo $this->Copyright->year(); ?> <?php echo $this->Copyright->name(); ?> | A <?php echo $this->Settings->show('Site.Footer.industry_identifier'); ?> website by Radar Hill Web Design. The content of this website is the responsibility of the website owner.
				</div> 
			</div>   
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
		<?php 
		// add 'youtube' if you will be embedding youtube videos (http://labnol.org/?p=27941)
		// add 'jquery.fancybox' and 'fancybox-init' if using fancybox, add _jquery.fancybox into stylesheet.scss
		// add 'jquery.cookie' if easy jQuery cookie use is needed
		$scriptArray = array('jquery.passive-listeners', 'jquery.sidr.min', 'custom', 'desktop-nav', 'forms', 'observers');
		
		echo $this->fetch('pluginScriptBottom');
		// Un-remark this if the site needs the VrebListings plugin.
		// if ($this->Vreb->includeVrebAssets(isset($page) ? $page : null)) :
		// 	echo '{{block type="script"}}';
		// 	$scriptArray[] = 'VrebListings.jquery.flexslider-min';
		// 	$scriptArray[] = 'VrebListings.js.cookie';
		// 	$scriptArray[] = 'VrebListings.extra_1';
		// 	$scriptArray[] = 'VrebListings.vreb_listings';
		// endif;
		
		echo $this->Html->script($scriptArray);

		if (isset($extraFooterCode)) :
			echo $extraFooterCode;
		// (isset($extraFooterCode))
		endif;
		?>
  </body>
</html>
