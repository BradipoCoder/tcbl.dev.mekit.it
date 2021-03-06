<?php
/**
 * Conference Cover
 * confcover.tpl.php
 */
hide($content['tabs']);
hide($content['more']);


?>
<div class="parallax-w" data-bleed="1" data-parallax="scroll" data-image-src="<?php print $path; ?>" data-position-y="center">
  <div class="wrapper-over-parallax">
    <div class="over-parallax-dark">
      <div class="parallax-content-conference">
        <div class="container">
          <div class="confcover-content">
            <div class="negative">
              <?php print render($content['title']); ?>
            </div>
            <div class="negative">
              <?php print render($content['sub']); ?>
            </div>
            <div class="text-center margin-t-1">
              <?php print render($content['more']); ?>
            </div>
            <a name="conference"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="conference-tabs-<?php print $nid; ?>" class="conference-tabs">
  <div class="container">
    <?php print render($content['tabs']); ?>
  </div>
</div>
