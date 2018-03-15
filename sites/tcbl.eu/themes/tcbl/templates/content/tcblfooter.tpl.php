<?php
/**
 * Tcbl Footer
 * tcblfooter.tpl.php
 */
?>
<div class="row row-tcbl-footer">
  <div class="tcbl-footer bg-blue">
    <div class="container">
      <div class="tcbl-footer-content">
        <?php print render($content['logo']); ?>

        <div class="footer-menu">
          <?php print render($content['menu']); ?>
        </div>

        <?php print render($content['menu_user']); ?>
        <?php print render($content['menu_social']); ?>
      </div>
    </div>
  </div>
</div>
