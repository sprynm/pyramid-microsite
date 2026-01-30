<?php
echo $this->element('layout/head');
echo $this->element('layout/nav');
echo $this->element('layout/body_masthead', array(
	'banner' => isset($banner) ? $banner : array(),
	'page' => isset($page) ? $page : array(),
	'pageHeading' => isset($pageHeading) ? $pageHeading : '',
	'bodyId' => isset($bodyId) ? $bodyId : null,
));
?>
<div id="content" class="site-wrapper site-wrapper--default">
	<div class="c-container c-container--normal">
		<div class="l-single">
			<main class="contact layout-main">
				<?php
				if (!empty($pageIntro)) {
					echo $this->Html->div('layout-rail', $pageIntro);
				}

				echo $this->Session->flash();
				?>
				<div class="contact-content">
					<div class="contact-text">
						<?php
						echo $this->fetch('content');
						?>
						<!-- <h2><?php echo $this->Settings->show('Site.Contact.name'); ?></h2>
						<p><?php echo $this->Settings->show('Site.Contact.address'); ?><br>
							<?php echo $this->Settings->show('Site.Contact.city'); ?>,
							<?php echo $this->Settings->show('Site.Contact.province_state'); ?>
							<?php echo $this->Settings->show('Site.Contact.postal_zip'); ?><br>
							<?php
							if ($this->Settings->show('Site.Contact.phone') != "") {
								$phone = $this->Settings->show('Site.Contact.phone');
								$phoneHTML = '<a href="tel:' . $phone . '">' . $phone . '</a>';
								?>
								Phone: <?php echo $phoneHTML; ?>
								<?php
							}

							if ($this->Settings->show('Site.Contact.toll_free') != "") {
								$toolFreePhone = $this->Settings->show('Site.Contact.toll_free');
								$toolFreePhoneHTML = '<a href="tel:' . $toolFreePhone . '">' . $toolFreePhone . '</a>';
								?>
								<br>Toll-Free: <?php echo $toolFreePhoneHTML; ?>
								<?php
							}
							?>
						</p> -->
					</div>
					<div class="contact-form" id="contact-form">
						{{block type="EmailForm" id="1"}}
					</div>
				</div>
			</main>
		</div>
	</div>
</div><!-- "content" ends -->
<?php
echo $this->element('layout/footer');
?>
