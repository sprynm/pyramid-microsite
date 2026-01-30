    <?php
      $this->Html->script(
        array(
          'header-notice'
          ,'jquery.cookie'
          ,
        )
        , array(
          'block' => 'pluginScriptBottom'
          ,
        )
      );
    ?>
    <div id="hdr-notice">
      <div class="hdr-notice-content">
        <button id="close-notice" aria-label="Close Notice"></button>
        <?php 
          echo $this->Settings->show('HeaderNotice.text'); 

          if($this->Settings->show('HeaderNotice.link') != "") {
            ?> <a href="<?php echo $this->Settings->show('HeaderNotice.link'); ?>" class="notice-btn"><?php echo $this->Settings->show('HeaderNotice.link_text'); ?></a><?php
          }
        ?> 
      </div>
    </div>