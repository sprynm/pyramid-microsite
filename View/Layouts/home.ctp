<?php // home.ctp

echo $this->element('layout/head');
echo $this->element('layout/nav');

$banner      = !empty($banner) ? $banner : array();
$page        = !empty($page) ? $page : array();
$pageHeading = !empty($pageHeading) ? $pageHeading : '';
$pageIntro   = !empty($pageIntro) ? $pageIntro : '';

echo $this->element('layout/home_masthead', array(
	'banner'      => $banner,
	'page'        => $page,
	'pageHeading' => $pageHeading,
));
?>


<div id="content" class="site-wrapper site-wrapper--default home">
	<div class="c-frame c-container--normal cq-main c-region">
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
	</div>
</div><!-- "content" ends -->
<?php
echo $this->element('layout/footer');
?>
