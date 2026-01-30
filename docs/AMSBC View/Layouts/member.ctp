<?php
echo $this->element('layout/head');
echo $this->element('layout/nav');
$memberHeroData = isset($memberHero) ? $memberHero : null;
echo $this->element('layout/body_masthead', array(
	'banner' => array(),
	'page' => array(),
	'pageHeading' => ($memberHeroData && isset($memberHeroData['name'])) ? $memberHeroData['name'] : '',
	'bodyId' => isset($bodyId) ? $bodyId : null,
	'memberHero' => $memberHeroData,
));

?>
<div id="content" class="site-wrapper site-wrapper--default">
	<div class="c-container c-container--normal">
		<main class="default l-single member-layout">
			<?php
			if (!empty($pageIntro)) {
				echo $this->Html->div('layout-rail', $pageIntro);
			}
			echo $this->Session->flash();

			echo $this->fetch('content');
			?>
		</main>
	</div>
</div><!-- "content" ends -->
<?php
echo $this->element('layout/footer');
?>