<?php
/**
 * Conference Cover
 * confcover.tpl.php
 */
hide($content['tabs']);

?>
<div class="parallax-w" data-bleed="1" data-parallax="scroll" data-image-src="<?php print $path; ?>" data-position-y="center">
  <div class="wrapper-over-parallax">
    <div class="over-parallax-dark">
      <div class="parallax-content">
        <div class="container negative">
          <div class="confcover-content">
            <?php print render($content); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="conference-tabs">
  <div class="container">
    <?php print render($content['tabs']); ?>
  </div>
</div>
