<?php global $base_url; ?>

<div class="row spazio-30">
  <div class="col-sm-<?php print $columns; ?> footer-content negative">
    <?php if ($image) : ?>
      <div class="logo footer-logo spazio-40">
        <a href="<?php print $base_url; ?>" title="<?php print t('Home'); ?>">
          <?php print render($image); ?>
        </a>
      </div>
    <?php else : ?>
      <a class="name txt-brand txt-brand-footer <?php print $brand_classes; ?>" href="<?php print $base_url; ?>" title="<?php print t('Home'); ?>">
        <span class="site-title"><?php print $site_name; ?></span>
        <?php if (!empty($site_slogan)) : ?>
          <br/><span class="site-slogan small"><?php print $site_slogan; ?></span>
        <?php endif; ?>
      </a>
    <?php endif; ?>
  </div>

  <?php if ($main_menu) : ?>
    <div class="col-sm-<?php print $columns; ?> footer-content negative">

      <?php if ($main_menu_title) : ?>
        <h5><?php print $main_menu_title; ?></h5>
      <?php endif; ?>

      <div class="small">
        <?php print render($main_menu); ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($menu_social) : ?>
    <div class="col-sm-<?php print $columns; ?> footer-content negative">

      <?php if ($menu_social_title) : ?>
        <h5><?php print $menu_social_title; ?></h5>
      <?php endif; ?>

      <div class="small">
        <?php print render($menu_social); ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="col-sm-<?php print $columns; ?> footer-content negative">

    <?php if ($contatti_title) : ?>
      <h5><?php print $contatti_title; ?></h5>
    <?php endif; ?>

    <div class="small">
      <?php print $contatti; ?>
    </div>
  </div>
</div>

<div class="row spazio-50">
  <div class="col-md-12">
    <hr>
    <div class="text-center small negative footer-common-link">
      <?php print $common_link;?>
    </div>
  </div>
</div>