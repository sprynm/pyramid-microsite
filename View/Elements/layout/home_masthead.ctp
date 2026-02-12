<?php
$pageData = !empty($page) ? $page : array();
$siteName = (string) $this->Settings->show('Site.name');
$pageHeading = isset($pageHeading) ? trim((string) $pageHeading) : '';
$pageName = !empty($pageData['Page']['name']) ? trim((string) $pageData['Page']['name']) : '';

$heroHeading = $pageHeading !== '' ? $pageHeading : ($pageName !== '' ? $pageName : $siteName);
$heroEyebrow = !empty($pageData['Page']['banner_header']) ? trim((string) $pageData['Page']['banner_header']) : '';
$heroSummary = !empty($pageData['Page']['banner_summary']) ? trim((string) $pageData['Page']['banner_summary']) : '';
$heroTitleParts = preg_split('/\s*\|\s*/', $heroHeading, 2);
$heroTitleMain = !empty($heroTitleParts[0]) ? $heroTitleParts[0] : $heroHeading;
$heroTitleAccent = !empty($heroTitleParts[1]) ? $heroTitleParts[1] : '';

$primaryCta = !empty($pageData['Page']['banner_cta']) && !empty($pageData['Page']['banner_cta_link']);
$secondaryCta = !empty($pageData['Page']['banner_cta_secondary']) && !empty($pageData['Page']['banner_cta_secondary_link']);
?>
<section class="page-hero page-hero--home page-hero--truck">
	<div class="page-hero__inner">
		<div class="page-hero__content">
			<?php if ($heroEyebrow !== ''): ?>
				<p class="page-hero__eyebrow"><?php echo h($heroEyebrow); ?></p>
			<?php endif; ?>

			<h1 class="page-hero__title">
				<?php echo h($heroTitleMain); ?>
				<?php if ($heroTitleAccent !== ''): ?>
					<span class="page-hero__title-accent"><?php echo h($heroTitleAccent); ?></span>
				<?php endif; ?>
			</h1>

			<?php if ($heroSummary !== ''): ?>
				<p class="page-hero__summary"><?php echo h($heroSummary); ?></p>
			<?php endif; ?>

			<?php if ($primaryCta || $secondaryCta): ?>
				<div class="page-hero__actions">
					<?php
					if ($primaryCta) {
						echo $this->Html->link($pageData['Page']['banner_cta'], $pageData['Page']['banner_cta_link'], array(
							'class' => 'page-hero__cta',
							'escape' => false,
						));
					}
					if ($secondaryCta) {
						echo $this->Html->link($pageData['Page']['banner_cta_secondary'], $pageData['Page']['banner_cta_secondary_link'], array(
							'class' => 'page-hero__cta page-hero__cta--secondary',
							'escape' => false,
						));
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="page-hero__truck" aria-hidden="true">
		<img src="/img/cranetruck.webp" alt="" fetchpriority="high" decoding="async">
	</div>
</section>
