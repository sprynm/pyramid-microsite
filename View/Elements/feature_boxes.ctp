<div class="feature-boxes">
  <?php 
    $featureBoxes = $this->Prototype->instanceItems(
      $featureInstanceId,
      array('limit' => $numberOfFeaturesLimit, 'order' => 'rand()')
    );

    foreach($featureBoxes as $featureBox) {
      ?>
      <a href="<?php echo $featureBox['PrototypeItem']['cta_link']; ?>">
        <?php
          $noImgClass = "";
          if(!empty($featureBox['Image'])) {
        ?>  
        <picture>
          <source data-srcset="<?php echo $this->Media->getImage($featureBox['Image'][0], array('version' => 'large')); ?>" media="(min-width: 1241px)">
          <source data-srcset="<?php echo $this->Media->getImage($featureBox['Image'][0], array('version' => 'medium')); ?>" media="(min-width: 481px)">
          <source data-srcset="<?php echo $this->Media->getImage($featureBox['Image'][0], array('version' => 'thumb')); ?>">
          <img data-src="<?php echo $this->Media->getImage($featureBox['Image'][0], array('version' => 'large')); ?>" width="800" height="600" alt="<?php echo $featureBox['Image'][0]['alternative'] ?>" class="lazy">
        </picture>
        <?php
          } else {
            $noImgClass = " no-img";
          }
        ?>
        <div class="feature-text<?php echo $noImgClass; ?>">
          <h2><?php echo $featureBox['PrototypeItem']['name']; ?></h2>
          <h3><?php echo $featureBox['PrototypeItem']['subheading']; ?></h3>
          <p><?php echo $featureBox['PrototypeItem']['text']; ?></p>
        </div>
        <span class="feature-cta<?php echo $noImgClass; ?>"><?php echo $featureBox['PrototypeItem']['cta_link_text']; ?></span>
      </a>
      <?php
    }
  ?>
</div>