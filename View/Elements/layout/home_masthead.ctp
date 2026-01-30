<?php
$bannerData = isset($banner) ? $banner : array();
$pageData = isset($page) ? $page : array();

$hasBannerImage = isset($bannerData['Image'][0]) && !empty($bannerData['Image'][0]);
$bannerImage = $hasBannerImage ? $bannerData['Image'][0] : array();

$heroAlt = '';
if ($hasBannerImage && !empty($bannerImage['alternative'])) {
	$heroAlt = trim($bannerImage['alternative']);
} elseif (!empty($pageData['Page']['name'])) {
	$heroAlt = trim($pageData['Page']['name']);
} else {
	$heroAlt = $this->Settings->show('Site.name');
}

$fallbackWebp = '';
$fallbackPng = '';
$commonHeroSetting = trim((string)$this->Settings->show('Site.common_head_image'));

if ($commonHeroSetting !== '') {
	$extractedSrc = '';
	if (preg_match('/src=["\']([^"\']+)["\']/', $commonHeroSetting, $match)) {
		$extractedSrc = $match[1];
	} elseif (filter_var($commonHeroSetting, FILTER_VALIDATE_URL) || strpos($commonHeroSetting, '/') === 0) {
		$extractedSrc = $commonHeroSetting;
	}

	if ($extractedSrc !== '') {
		$fallbackWebp = $extractedSrc;
		$fallbackPng = $extractedSrc;
	}
}

$renderFallbackPicture = function ($alt, $priority = 'lazy') use ($fallbackWebp, $fallbackPng) {
	if ($fallbackWebp === '' && $fallbackPng === '') {
		return '';
	}

	ob_start();
	?>
	<picture>
		<?php if ($fallbackWebp !== '' && $fallbackWebp !== $fallbackPng): ?>
			<source srcset="<?php echo $fallbackWebp; ?>" type="image/webp">
		<?php endif; ?>
		<img src="<?php echo $fallbackPng !== '' ? $fallbackPng : $fallbackWebp; ?>" alt="<?php echo h($alt); ?>"
			<?php echo $priority === 'high' ? 'fetchpriority="high"' : 'loading="lazy" decoding="async"'; ?>>
	</picture>
	<?php
	return ob_get_clean();
};

if ($hasBannerImage || $fallbackWebp !== '' || $fallbackPng !== ''):
?>
<div class="banner home-banner">
	<?php if ($hasBannerImage): ?>
	<picture>
		<source srcset="<?php echo $this->Media->getImage($bannerImage, array('version' => 'banner-xlrg')); ?>" media="(min-width: 1981px)">
		<source srcset="<?php echo $this->Media->getImage($bannerImage, array('version' => 'banner-lrg')); ?> 1x, <?php echo $this->Media->getImage($bannerImage, array('version' => 'banner-xlrg')); ?> 2x" media="(min-width: 1441px)">
		<source srcset="<?php echo $this->Media->getImage($bannerImage, array('version' => 'banner-med')); ?>" media="(min-width: 801px)">
		<source srcset="<?php echo $this->Media->getImage($bannerImage, array('version' => 'banner-sm')); ?>" media="(min-width: 641px)">
		<source srcset="<?php echo $this->Media->getImage($bannerImage, array('version' => 'banner-xsm')); ?>">
		<img src="<?php echo $this->Media->getImage($bannerImage, array('version' => 'banner-lrg')); ?>" width="1920" height="970" alt="<?php echo h($heroAlt); ?>" fetchpriority="high">
	</picture>
	<?php else: ?>
		<?php echo $renderFallbackPicture($heroAlt, 'high'); ?>
	<?php endif; ?>

	<div class="overlay">
		<div class="text-block">
			<?php
			if (!empty($pageData['Page']['banner_header'])) {
				echo $this->Html->tag('span', $pageData['Page']['banner_header'], array('class' => 'header-tagline', 'escape' => false));
			}
			if (!empty($pageData['Page']['banner_cta']) && !empty($pageData['Page']['banner_cta_link'])) {
				echo $this->Html->link($pageData['Page']['banner_cta'], $pageData['Page']['banner_cta_link'], array('class' => 'btn', 'escape' => false));
			}
			?>
		</div>
	</div>
</div>
<?php endif; ?>
