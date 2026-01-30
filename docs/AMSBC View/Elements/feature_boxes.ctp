<div class="feature-boxes">
  <?php 
    $featureBoxes = $this->Prototype->instanceItems(
      $featureInstanceId,
      array('limit' => $numberOfFeaturesLimit)
    );

    foreach($featureBoxes as $featureBox) {
      ?>
      <a class="u-font-spectral" href="<?php echo $featureBox['PrototypeItem']['cta_link']; ?>">
        <?php
          
          if(!empty($featureBox['Image'])) {
        ?>  
        <picture>
          <source srcset="<?php echo $this->Media->getImage($featureBox['Image'][0], array('version' => 'large')); ?>" media="(min-width: 1241px)">
          <source srcset="<?php echo $this->Media->getImage($featureBox['Image'][0], array('version' => 'medium')); ?>" media="(min-width: 481px)">
          <source srcset="<?php echo $this->Media->getImage($featureBox['Image'][0], array('version' => 'thumb')); ?>">
          <img src="<?php echo $this->Media->getImage($featureBox['Image'][0], array('version' => 'large')); ?>" width="800" height="600" alt="<?php echo $featureBox['Image'][0]['alternative'] ?>" loading="lazy">
        </picture>
        <?php
          }
        ?>
        <div class="feature-text">
          <h2><?php echo $featureBox['PrototypeItem']['name']; ?></h2>
        </div>
      </a>
      <?php
    }
  ?>
</div>