<?php
$bannerData = !empty($banner) ? $banner : array();
$pageData = !empty($page) ? $page : array();

$bannerImage = !empty($bannerData['Image'][0]) ? $bannerData['Image'][0] : array();
$hasBannerImage = !empty($bannerImage);

// Alt text: keep this plain text (even if “trusted”, it’s an attribute)
$siteName = (string) $this->Settings->show('Site.name');
$pageName = !empty($pageData['Page']['name']) ? trim((string) $pageData['Page']['name']) : '';
$imgAlt = !empty($bannerImage['alternative']) ? trim((string) $bannerImage['alternative']) : '';

$heroAlt = $imgAlt !== '' ? $imgAlt : ($pageName !== '' ? $pageName : $siteName);

// Fallback hero: accept either <img ...> snippet or a src string
$commonHeroSetting = trim((string) $this->Settings->show('Site.common_head_image'));
$fallbackSrc = '';

if ($commonHeroSetting !== '') {
	if (stripos($commonHeroSetting, '<img') !== false) {
		if (preg_match('/\ssrc\s*=\s*["\']([^"\']+)["\']/i', $commonHeroSetting, $m)) {
			$fallbackSrc = $m[1];
		}
	} else {
		$fallbackSrc = $commonHeroSetting;
	}
}

$renderFallbackPicture = function ($src, $alt, $priorityHigh = false) {
	if ($src === '')
		return '';

	ob_start();
	?>
	<picture>
		<img src="<?php echo h($src); ?>" alt="<?php echo h($alt); ?>" <?php echo $priorityHigh ? 'fetchpriority="high" decoding="async"' : 'loading="lazy" decoding="async"'; ?>>
	</picture>
	<?php
	return ob_get_clean();
};

$hasAnyHero = $hasBannerImage || $fallbackSrc !== '';
?>

<?php if ($hasAnyHero): ?>
	<div class="banner">
		<?php if ($hasBannerImage): ?>
			<picture>
				<source srcset="<?php echo h($this->Media->getImage($bannerImage, array('version' => 'banner-xlrg'))); ?>"
					media="(min-width: 1440px)">
				<source
					srcset="<?php echo h($this->Media->getImage($bannerImage, array('version' => 'banner-lrg'))); ?> 1x, <?php echo h($this->Media->getImage($bannerImage, array('version' => 'banner-xlrg'))); ?> 2x"
					media="(min-width: 1024px)">
				<source srcset="<?php echo h($this->Media->getImage($bannerImage, array('version' => 'banner-med'))); ?>"
					media="(min-width: 992px)">
				<source srcset="<?php echo h($this->Media->getImage($bannerImage, array('version' => 'banner-sm'))); ?>"
					media="(min-width: 768px)">
				<source srcset="<?php echo h($this->Media->getImage($bannerImage, array('version' => 'banner-xsm'))); ?>">
				<img src="<?php echo h($this->Media->getImage($bannerImage, array('version' => 'banner-med'))); ?>" width="1920"
					height="970" alt="<?php echo h($heroAlt); ?>" fetchpriority="high" decoding="async">
			</picture>
		<?php else: ?>
			<?php echo $renderFallbackPicture($fallbackSrc, $heroAlt, true); ?>
		<?php endif; ?>

		<div class="overlay">
			<div class="text-block">
				<?php
				// Trusted HTML allowed here (per your instruction)
				if (!empty($pageData['Page']['banner_header'])) {
					echo $this->Html->tag('span', $pageData['Page']['banner_header'], array(
						'class' => 'header-tagline',
						'escape' => false,
					));
				}

				if (!empty($pageData['Page']['banner_cta']) && !empty($pageData['Page']['banner_cta_link'])) {
					echo $this->Html->link($pageData['Page']['banner_cta'], $pageData['Page']['banner_cta_link'], array(
						'class' => 'btn',
						'escape' => false,
					));
				}
				?>
			</div>
		</div>
	</div>
<?php endif; ?>
