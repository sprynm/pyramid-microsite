<div class="feature-boxes">
  <?php
    $featureBoxes = $this->Prototype->instanceItems(
      $featureInstanceId,
      array('limit' => $numberOfFeaturesLimit, 'order' => 'rand()')
    );

    foreach ($featureBoxes as $featureBox) {
      $item = isset($featureBox['PrototypeItem']) ? $featureBox['PrototypeItem'] : array();
      $heading = isset($item['heading']) && $item['heading'] !== '' ? $item['heading'] : (isset($item['name']) ? $item['name'] : '');
      $title = isset($item['title']) ? $item['title'] : '';
      $subheading = isset($item['subheading']) ? $item['subheading'] : '';
      $content = isset($item['text']) ? $item['text'] : (isset($item['content']) ? $item['content'] : '');
      $ctaText = isset($item['cta_link_text']) ? $item['cta_link_text'] : (isset($item['cta_text']) ? $item['cta_text'] : '');
      $ctaLink = isset($item['cta_link']) ? $item['cta_link'] : '';
      $image = (!empty($featureBox['Image']) && !empty($featureBox['Image'][0])) ? $featureBox['Image'][0] : null;
      $imageAlt = $image && !empty($image['alternative']) ? $image['alternative'] : $heading;
      $imageCaption = $image && !empty($image['caption']) ? $image['caption'] : '';
      ?>
      <?php if ($ctaLink !== '' && $ctaText === ''): ?>
        <a class="tile tile--linked" href="<?php echo h($ctaLink); ?>">
          <?php if ($image): ?>
            <span class="tile__bg" style="background-image: url('<?php echo h($this->Media->getImage($image, array('version' => 'large'))); ?>');"></span>
          <?php endif; ?>
          <span class="tile__overlay"></span>
          <span class="tile__content">
            <?php if ($heading !== ''): ?>
              <span class="tile__heading"><?php echo h($heading); ?></span>
            <?php endif; ?>
            <?php if ($title !== ''): ?>
              <span class="tile__title"><?php echo h($title); ?></span>
            <?php endif; ?>
            <?php if ($subheading !== ''): ?>
              <span class="tile__subheading"><?php echo h($subheading); ?></span>
            <?php endif; ?>
            <?php if ($content !== ''): ?>
              <span class="tile__text"><?php echo nl2br(h($content)); ?></span>
            <?php endif; ?>
          </span>
        </a>
      <?php else: ?>
        <article class="tile">
          <?php if ($image): ?>
            <span class="tile__bg" style="background-image: url('<?php echo h($this->Media->getImage($image, array('version' => 'large'))); ?>');"></span>
          <?php endif; ?>
          <span class="tile__overlay"></span>
          <div class="tile__content">
            <?php if ($heading !== ''): ?>
              <h2 class="tile__heading"><?php echo h($heading); ?></h2>
            <?php endif; ?>
            <?php if ($title !== ''): ?>
              <p class="tile__title"><?php echo h($title); ?></p>
            <?php endif; ?>
            <?php if ($subheading !== ''): ?>
              <p class="tile__subheading"><?php echo h($subheading); ?></p>
            <?php endif; ?>
            <?php if ($content !== ''): ?>
              <div class="tile__text"><?php echo nl2br(h($content)); ?></div>
            <?php endif; ?>
            <?php if ($ctaLink !== '' && $ctaText !== ''): ?>
              <?php echo $this->Html->link(h($ctaText), $ctaLink, array('class' => 'tile__cta btn')); ?>
            <?php endif; ?>
          </div>
        </article>
      <?php endif; ?>
      <?php
    }
  ?>
</div>
