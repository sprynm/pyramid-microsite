<?php // home.ctp

echo $this->element('layout/head');
echo $this->element('layout/nav');

$banner      = !empty($banner) ? $banner : array();
$page        = !empty($page) ? $page : array();
$pageHeading = !empty($pageHeading) ? $pageHeading : '';
$pageIntro   = !empty($pageIntro) ? $pageIntro : '';
$featureBoxesHtml = '';
$featureBoxesPath = APP . 'Plugin' . DS . 'Prototype' . DS . 'View' . DS . 'feature-boxes';
if (is_dir($featureBoxesPath)) {
	$featureBoxesHtml = (string) $this->element('feature_boxes', array(
		'featureInstanceId' => 1,
		'numberOfFeaturesLimit' => 3,
	));
}
$hasFeatureBoxes = trim($featureBoxesHtml) !== '';

echo $this->element('layout/home_masthead', array(
	'banner'      => $banner,
	'page'        => $page,
	'pageHeading' => $pageHeading,
));
?>


<div id="content" class="site-wrapper site-wrapper--default home">
	<div class="c-frame c-container--normal cq-main c-region">
		<?php if ($hasFeatureBoxes): ?>
			<section class="c-sidebar">
				<main>

					<?php

					if ($pageIntro !== '') {
						echo h($pageIntro);
					}

					echo $this->Session->flash();

					echo $this->fetch('content');

					?>

				</main>

				<aside class="home-sidebar">
					<?php echo $featureBoxesHtml; ?>
				</aside>
			</section>
		<?php else: ?>
			<section class="c-stack">
				<main>

					<?php

					if ($pageIntro !== '') {
						echo h($pageIntro);
					}

					echo $this->Session->flash();

					echo $this->fetch('content');

					?>

				</main>
			</section>
		<?php endif; ?>
	</div>
</div><!-- "content" ends -->
<?php
echo $this->element('layout/footer');
?>
