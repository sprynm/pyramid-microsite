<?php
if ($this->Settings->show('HeaderNotice.display_header_notice') == 1) {
	echo $this->element('header-notice');
}
?>
<header class="primary-hdr">
	<div class="hdr-container">
		<a href="/" class="logo"><img src="/img/amsbc.png" width="80" height="80" alt="<?php echo $this->Settings->show('Site.name'); ?>"></a>

		<div class="hdr-links">
			<a id="responsive-menu-button" href="#sidr-main" aria-controls="sidr-main" aria-expanded="false">
				Menu
				<div class="hamburger" aria-hidden="true"><span></span><span></span><span></span></div>
			</a>
			<nav role="navigation">
				<?php echo $this->Navigation->show(1); ?>
			</nav>
			<?php
				/* Remove comment if using Products plugin
				echo $this->element('Products.cart/cart_count');
				*/
			?>
		</div>
	</div>
</header>
