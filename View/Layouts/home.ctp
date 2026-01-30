<?php // home.ctp
echo $this->element('layout/head');
echo $this->element('layout/nav');
echo $this->element('layout/home_masthead', array(
	'banner' => isset($banner) ? $banner : array(),
	'page' => isset($page) ? $page : array(),
	'pageHeading' => isset($pageHeading) ? $pageHeading : '',
));
?>
<div id="content" class="site-wrapper site-wrapper--default">
	<div class="c-container c-container--normal">
		<section class="l-single">
		
				<main class="home layout-home">
					<?php
					if (isset($pageHeading) && strlen($pageHeading) > 0) {
						echo $this->Html->tag('h1', $pageHeading);
					}

					if (isset($pageIntro) && strlen($pageIntro) > 0) {
						echo $pageIntro;
					}

					echo $this->Session->flash();
					echo $this->fetch('content');

					if (CmsPlugin::isInstalled('Products')) {
						echo $this->element('Products.products/featured');
					}
					?>
				</main>
		
		</section>
	</div>
</div><!-- "content" ends -->
<?php
echo $this->element('layout/footer');
?>
