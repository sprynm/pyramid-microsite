<?php // home.ctp
//
echo $this->element('layout/head');
echo $this->element('layout/nav');
echo $this->element('layout/home_masthead', array(
	'banner' => isset($banner) ? $banner : array(),
	'page' => isset($page) ? $page : array(),
));
$wrapperClasses = array('site-wrapper', 'site-wrapper--default');
?>
<div id="content" class="<?php echo implode(' ', $wrapperClasses); ?>">
	<section class="body-content l-single">
		<div class="home-content">
		<main class="home layout-home">
			<?php //
			//
			if (isset($pageHeading) && strlen($pageHeading) > 0):
				echo $this->Html->tag('h1', $pageHeading, ['class' => 'home__title text-center']);
			endif;
			//
			if (isset($pageIntro) && strlen($pageIntro) > 0):
				//
				echo $pageIntro;
				// (isset($pageIntro) && strlen($pageIntro) > 0)
			endif;
			//
			echo $this->Session->flash();
			//
			echo $this->fetch('content');
			//
			if (CmsPlugin::isInstalled('Products')):
				//
				echo $this->element('Products.products/featured');
				// (CmsPlugin::isInstalled('Products'))
			endif;
			?>
		</main>
		</div>

		<?php echo $this->element('feature_boxes', array('featureInstanceId' => 1, 'numberOfFeaturesLimit' => 2)); ?>


		<div class="secondary-content">
		<?php
		// Copy
		$explainerHtml = !empty($page['Page']['explainer']) ? $page['Page']['explainer'] : '';

		// Attachments (from your debug shape)
		$attachments = array();
		if (
			isset($page['Page']['explainer_img']['Attachment']) &&
			is_array($page['Page']['explainer_img']['Attachment'])
		) {
			$attachments = $page['Page']['explainer_img']['Attachment'];
		}
		$hasImage = !empty($attachments);
		?>

		<div class="secondary-content__inner<?php echo $hasImage ? ' has-image' : ''; ?>">
			<div class="secondary-content__copy">
				<?php echo $explainerHtml; ?>
			</div>

			<figure class="secondary-content__media">
				<?php if ($hasImage):
					$first = $attachments[0];
					// Force an alt if empty in the media record
					$alt = (isset($first['alternative']) && trim($first['alternative']) !== '')
						? $first['alternative']
						: 'Marine surveyor inspecting a vessel';

					// 1) Preferred: let the helper build the markup
					$imgHtml = $this->Media->mainImage($attachments, 'large', array('alt' => $alt));

					if (trim($imgHtml) !== '') {
						echo $imgHtml;
					} else {
						// 2) Fallback: manual picture using the generated versions
						$urls = array();
						foreach (array('large', 'medium', 'small') as $ver) {
							$u = $this->Media->getImage($first, array('version' => $ver));
							if ($u)
								$urls[$ver] = $u;
						}
						$fallbackSrc = isset($urls['large']) ? $urls['large']
							: (isset($urls['medium']) ? $urls['medium']
								: (isset($urls['small']) ? $urls['small'] : ''));

						if ($fallbackSrc === '' && isset($first['path']) && $first['path'] !== '') {
							$fallbackSrc = '/media/' . ltrim($first['path'], '/');
						}
						?>
						<picture>
							<?php if (isset($urls['large'])): ?>
								<source srcset="<?php echo $urls['large']; ?>" media="(min-width: 1241px)">
							<?php endif; ?>
							<?php if (isset($urls['medium'])): ?>
								<source srcset="<?php echo $urls['medium']; ?>" media="(min-width: 481px)">
							<?php endif; ?>
							<?php if (isset($urls['small'])): ?>
								<source srcset="<?php echo $urls['small']; ?>">
							<?php endif; ?>
							<img src="<?php echo $fallbackSrc; ?>" alt="<?php echo h($alt); ?>" loading="lazy" decoding="async">
						</picture>
						<?php
					}
				else: ?>
					<img src="/media/filter/large/img/marine_surveyor.jpg" alt="Marine surveyor inspecting a vessel"
						loading="lazy" decoding="async">
				<?php endif; ?>
			</figure>
		</div>
		</div>










		<?php echo $this->element('footer_cta', array('featureInstanceId' => 2, 'numberOfFeaturesLimit' => 1)); ?>
	</section>
</div><!-- "content" ends -->
<?php
// Uses preconfigrued "Feature Boxes" instance
// Pass the id of the instance and the limit for how many feature boxes to display
// Feature boxes selected randomly from all "Feature Box" items
//echo $this->element('feature_boxes', array('featureInstanceId' => 3, 'numberOfFeaturesLimit' => 3)); 
//
echo $this->element('layout/footer');
?>
