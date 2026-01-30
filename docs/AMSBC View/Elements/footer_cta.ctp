<div class="footer-cta">
  <?php 
    $footer_cta = $this->Prototype->instanceItems(
      $featureInstanceId,
      array('limit' => $numberOfFeaturesLimit)
    );

    foreach($footer_cta as $footerC) {
      ?>
      <div class="">
        <picture>
          <source srcset="<?php echo $this->Media->getImage($footerC['Image'][0], array('version' => 'large')); ?>" media="(min-width: 1241px)">
          <source srcset="<?php echo $this->Media->getImage($footerC['Image'][0], array('version' => 'medium')); ?>" media="(min-width: 481px)">
          <source srcset="<?php echo $this->Media->getImage($footerC['Image'][0], array('version' => 'thumb')); ?>">
          <img src="<?php echo $this->Media->getImage($footerC['Image'][0], array('version' => 'large')); ?>" width="800" height="600" alt="<?php echo $footerC['Image'][0]['alternative'] ?>" loading="lazy">
        </picture>
        
        <div class="text-overlay">
          <h2><?php echo $footerC['PrototypeItem']['tagline']; ?></h2>
        </div>
      <?php
    }
  ?>
</div>