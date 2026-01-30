<!DOCTYPE html>
<html lang="en">
  <head>
		<?php
		$gtm_association_code	= $this->Settings->show('Site.Google.gtm_association_code');
		if (!empty($gtm_association_code)) :
			echo $this->element('gtm_head', array('gtm_association_code' => $gtm_association_code));
		// (!empty($gtm_association_code))
		endif;
		?>
    <title><?php echo $titleTag; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
		echo $this->Html->canonical();
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		// Additional metas should the site be employing the Blog plugin.
		echo $this->element('metas');
		$cssArray		= array('stylesheet');

		// Un-remark this if the site needs the VrebListings plugin.
		//if ($this->Vreb->includeVrebAssets(isset($page) ? $page : null)) :
			//
			//$cssArray[]	= 'VrebListings.vreb';
		// ($this->Vreb->includeVrebAssets(isset($page) ? $page : null))
		//endif;

		echo $this->Html->css($cssArray);
		echo $this->Html->css('print', null, array('media' => 'print'));
		echo '{{block type="css"}}';
		//
		if (isset($extraHeaderCode)) :
			//
			echo $extraHeaderCode;
		// 
		endif;
		?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
		<?php // 
		//
		if (isset($page) && !empty($page['Page']['schema_code'])) :
			//
			echo "\n" . $page['Page']['schema_code'] . "\n";
		// 
		endif;
		?>
  </head>
  <body id="<?php echo $bodyId; ?>" <?php if (isset($bodyClass) && !empty($bodyClass)) { echo 'class="'.$bodyClass.'"'; } ?>>
		<?php
		if (!empty($gtm_association_code)) :
			echo $this->element('gtm_body', array('gtm_association_code' => $gtm_association_code));
		// (!empty($gtm_association_code))
		endif;
		// 
		echo $this->element('schema/location');
		?>
    <?php echo $this->Html->link('Skip to main content', '#content', array('id' => 'skiplink')); ?>
  
		<?php 
			if($this->Settings->show('HeaderNotice.display_header_notice') == 1) {
				echo $this->element('header-notice');
			}
		?> 
		<header class="primary-hdr">
			<div class="hdr-container">
				<a href="/" class="logo"><img src="/img/logo.svg" width="275" height="28" alt="<?php echo $this->Settings->show('Site.name'); ?>" style="--logo-width: 27.5rem;"></a>

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

		<!--
		<div class="search-bar">
			<div class="search-form-container">
				<?php //echo $this->element('search'); ?>
			</div>
		</div>
		-->

		<?php
			if(isset($banner['Image']) && !empty($banner['Image'])) {
				?>
				<div class="banner">
					<picture>
						<source srcset="<?php echo $this->Media->getImage($banner['Image'][0], array('version' => 'banner-lrg')); ?>" media="(min-width: 1441px)">
						<source srcset="<?php echo $this->Media->getImage($banner['Image'][0], array('version' => 'banner-med')); ?>" media="(min-width: 801px)">
						<source srcset="<?php echo $this->Media->getImage($banner['Image'][0], array('version' => 'banner-sm')); ?>" media="(min-width: 641px)">
						<source srcset="<?php echo $this->Media->getImage($banner['Image'][0], array('version' => 'banner-xsm')); ?>">
						<img src="<?php echo $this->Media->getImage($banner['Image'][0], array('version' => 'banner-lrg')); ?>" width="1920" height="500" alt="<?php echo $banner['Image'][0]['alternative']; ?>" fetchpriority="high">
					</picture>
				</div>
				<?php 
			}
		?>		
		<div id="content">
