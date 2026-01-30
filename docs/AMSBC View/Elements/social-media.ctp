<?php 
	$socialMediaHTML = "";
	if($this->Settings->show('Site.SocialMedia.facebook') != "") {
		$socialMediaHTML .= $this->Html->link(
			'Facebook',
			$this->Settings->show('Site.SocialMedia.facebook'),
			array('class' => 'social-icon facebook', 'target' => '_blank', 'rel' => 'noopener')
		);
	}
	if($this->Settings->show('Site.SocialMedia.twitter') != "") {
		$socialMediaHTML .= $this->Html->link(
			'Twitter',
			$this->Settings->show('Site.SocialMedia.twitter'),
			array('class' => 'social-icon twitter', 'target' => '_blank', 'rel' => 'noopener')
		);
	}
	if($this->Settings->show('Site.SocialMedia.instagram') != "") {
		$socialMediaHTML .= $this->Html->link(
			'Instagram',
			$this->Settings->show('Site.SocialMedia.instagram'),
			array('class' => 'social-icon instagram', 'target' => '_blank', 'rel' => 'noopener')
		);
	}
	if($this->Settings->show('Site.SocialMedia.youtube') != "") {
		$socialMediaHTML .= $this->Html->link(
			'YouTube',
			$this->Settings->show('Site.SocialMedia.youtube'),
			array('class' => 'social-icon youtube', 'target' => '_blank', 'rel' => 'noopener')
		);
	}
	if($this->Settings->show('Site.SocialMedia.linkedin') != "") {
		$socialMediaHTML .= $this->Html->link(
			'LinkedIn',
			$this->Settings->show('Site.SocialMedia.linkedin'),
			array('class' => 'social-icon linkedin', 'target' => '_blank', 'rel' => 'noopener')
		);
	}

	if($socialMediaHTML != "") {
		?>
		<div class="social-media">	
			<?php echo $socialMediaHTML; ?>		
		</div>
		<?php

	}
?>