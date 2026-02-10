		<footer>
			<div class="ftr-container">
				<?php
					$footerNav = trim((string) $this->Navigation->show(1, false));
					$footerSocial = trim((string) $this->element('social-media'));
					$contactBits = array();
					if (!empty($siteContact['address'])) {
						$contactBits[] = $siteContact['address'];
					}
					$city = isset($siteContact['city']) ? $siteContact['city'] : '';
					$province = isset($siteContact['province_state']) ? $siteContact['province_state'] : '';
					$postal = isset($siteContact['postal_zip']) ? $siteContact['postal_zip'] : '';
					$cityLine = trim($city . ', ' . $province . ' ' . $postal);
					if ($cityLine !== ',') {
						$contactBits[] = $cityLine;
					}
					if (!empty($siteContact['phone'])) {
						$phone = $siteContact['phone'];
						$contactBits[] = 'Tel: <a href="tel:' . $phone . '">' . $phone . '</a>';
					}
				?>

				<div class="ftr-grid">
					<div class="ftr-brand">
						<div class="ftr-logo"><?php echo h($this->Settings->show('Site.name')); ?></div>
					</div>

					<?php if ($footerNav !== '' && $footerNav !== '<ul></ul>'): ?>
						<nav class="ftr-nav" aria-label="Footer navigation">
							<h4 class="ftr-heading">Pages</h4>
							<?php echo $footerNav; ?>
						</nav>
					<?php endif; ?>

					<?php if ($footerSocial !== ''): ?>
						<div class="ftr-social">
							<h4 class="ftr-heading">Social</h4>
							<?php echo $footerSocial; ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($contactBits)): ?>
						<div class="ftr-contact">
							<h4 class="ftr-heading">Contact</h4>
							<?php echo implode('<br>', $contactBits); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="copyright">
					<?php
						if(isset($page) && $page['Page']['id'] == 1) {
							$rhText = $this->Html->link('Radar Hill Web Design', $this->Settings->show('Site.Footer.portfolio_link'), array('rel' => 'nofollow'));
						} else {
							$rhText = "Radar Hill Web Design";
						}
					?>
					&copy; <?php echo $this->Copyright->year(); ?> <?php echo $this->Copyright->name(); ?> | A <?php echo $this->Settings->show('Site.Footer.industry_identifier'); ?> website by <span class="avoid-break"><?php echo $rhText; ?></span><br>
					The content of this website is the responsibility of the website owner.
				</div>
			</div>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
		<?php 
		// add 'youtube' if you will be embedding youtube videos (http://labnol.org/?p=27941)
		// add 'jquery.fancybox' and 'fancybox-init' if using fancybox, add _jquery.fancybox into stylesheet.scss
		// add 'jquery.cookie' if easy jQuery cookie use is needed
		$scriptArray = array('jquery.passive-listeners', 'custom', 'navigation-modern', 'forms', 'observers');
		
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
